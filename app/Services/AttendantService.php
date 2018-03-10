<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 05/02/2018
 * Time: 01:01
 */

namespace App\Services;


use App\Repositories\AttendantRepository;
use App\Validators\AttendantValidator;

class AttendantService
{

    private $repository;
    private $validator;

    public function __construct(AttendantValidator $validator, AttendantRepository $repository)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
    }

    public function index()
    {
        try{
            return CategoryResource::collection($this->repository->paginate());
        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function store($data)
    {
        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->repository->create($data);
            return new CategoryResource($user);

        } catch (\Exception $e) {
            switch (get_class($e))
            {
                case ValidatorException::class: return $e; break;
                default: return Error::getError(true,'Ocorreu um error no servidor',500);
            }
        }
    }

    public function show($id)
    {
        try{
            if($id < 0) {
                return Error::getError(true, 'ID inválido, ID não pode ser menor que zero', 400);
            }
            $category = $this->repository->findById($id);
            if($category) {
                return new CategoryResource($category);
            } else {
                return Error::getError(true,'Não existe categoria com ID '.$id,404);
            }
        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function update($data, $id)
    {
        try{
            if($id < 0) {
                return Error::getError(true, 'ID inválido, ID não pode ser menor que zero', 400);
            }
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $category = $this->repository->update($data,$id);
            return new CategoryResource($category);

        } catch (\Exception $e) {
            switch (get_class($e))
            {
                case ValidatorException::class: return $e;
                case ModelNotFoundException::class: return Error::getError(true,'Não atualizado, verifique os parâmetros',400);
                default: return Error::getError(true,'Ocorreu um error no servidor',500);
            }
        }
    }

    public function destroy($id)
    {
        try{
            if($id < 0) {
                return Error::getError(true, 'ID inválido, ID não pode ser menor que zero', 400);
            }

            $this->repository->delete($id);
            return response()->json([], 204);

        } catch (\Exception $e) {
            switch (get_class($e))
            {
                case ModelNotFoundException::class: return Error::getError(true,'Não excluido, verifique os parâmetros',400);
                default: return Error::getError(true,'Ocorreu um error no servidor',500);
            }
        }
    }

    public function isCoordinator(){
        try{
            $attendant = $this->repository->findWhere(['user_id' => \Auth::user()->token()->user_id]);

            if($attendant['0']->coordinator){
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }

    }


}
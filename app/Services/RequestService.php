<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 04/02/2018
 * Time: 22:43
 */

namespace App\Services;


use App\Exceptions\Error;
use App\Http\Resources\RequestResource;
use App\Repositories\AttendantRepository;
use App\Repositories\RequestRepository;
use App\Validators\RequestValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class RequestService
{

    private $repository;
    private $attendantRepository;
    private $validator;

    public function __construct(RequestValidator $validator, RequestRepository $repository, AttendantRepository $attendantRepository)
    {
        $this->validator            = $validator;
        $this->repository           = $repository;
        $this->attendantRepository   = $attendantRepository;
    }

    public function index()
    {
        try{

            $attendant = $this->attendantRepository->findWhere(['user_id' => \Auth::user()->token()->user_id]);
            if($attendant['0']->coordinator){
                return RequestResource::collection($this->repository->paginate());
            } else {
                return Error::getError(true,'Você não tem permissão para essa ação',400);
            }

        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function myRequests()
    {

    }

    public function store($data)
    {
        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->repository->create($data);
            return new RequestResource($user);

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
                return new RequestResource($category);
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
            return new RequestResource($category);

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


}
<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 05/02/2018
 * Time: 01:01
 */

namespace App\Services;


use App\Exceptions\Error;
use App\Http\Resources\AttendantResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\RequestResource;
use App\Repositories\AttendantRepository;
use App\Repositories\RequestRepository;
use App\Validators\AttendantValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class AttendantService
{

    private $repository;
    private $validator;
    private $requestRepository;

    public function __construct(AttendantValidator $validator, AttendantRepository $repository, RequestRepository $requestRepository)
    {
        $this->validator            = $validator;
        $this->repository           = $repository;
        $this->requestRepository    = $requestRepository;
    }

    public function index()
    {
        try{
            return AttendantResource::collection($this->repository->paginate());
        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function store($data)
    {
        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $attendant = $this->repository->create($data);
            return new AttendantResource($attendant);

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
            $attendant = $this->repository->findById($id);
            if($attendant) {
                return new AttendantResource($attendant);
            } else {
                return Error::getError(true,'Não existe atendente com ID '.$id,404);
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

            $attendant = $this->repository->update($data,$id);
            return new AttendantResource($attendant);

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


    public function myRequests()
    {
        try{
            $attendant = $this->repository->findWhere(['user_id'=>\Auth::user()->token()->user_id]);
            $requests = $this->requestRepository->where('attendant_id','=',$attendant[0]->id, 15);

            return RequestResource::collection($requests);

        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

}
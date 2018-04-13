<?php

namespace App\Services;


use App\Exceptions\Error;
use App\Http\Resources\DepartmentResource;
use App\Repositories\DepartmentRepository;
use App\Validators\DepartmentValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class DepartmentService
{

    private $repository;
    private $validator;

    public function __construct(DepartmentValidator $validator, DepartmentRepository $repository)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
    }

    public function index()
    {
        try{
            return DepartmentResource::collection($this->repository->paginate());
        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function store($data)
    {
        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->repository->create($data);
            return new DepartmentResource($user);

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
            if($id < 1) {
                return Error::getError(true, 'ID inválido, ID não pode ser menor ou igual a zero', 400);
            }
            $department = $this->repository->findById($id);
            if($department) {
                return new DepartmentResource($department);
            } else {
                return Error::getError(true,'Não existe departamento com ID '.$id,404);
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

            $department = $this->repository->update($data,$id);
            return new DepartmentResource($department);

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
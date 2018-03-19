<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 04/02/2018
 * Time: 18:32
 */

namespace App\Services;


use App\Exceptions\Error;
use App\Http\Resources\EquipmentResource;
use App\Repositories\EquipmentRepository;
use App\Validators\EquipmentValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class EquipmentService
{

    private $repository;
    private $validator;

    public function __construct(EquipmentRepository $repository, EquipmentValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index()
    {
        try{
            return EquipmentResource::collection($this->repository->paginate());
        } catch (\Exception $e) {
            return Error::getError(true, 'Ocorreu um error no servidor',500);
        }
    }

    public function store($data)
    {
        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $equipment = $this->repository->create($data);
            return new EquipmentResource($equipment);

        } catch (\Exception $e) {
            switch (get_class($e))
            {
                case ValidatorException::class: return $e;
                case ModelNotFoundException::class: return Error::getError(true,'Não cadastrado, verifique os parâmetros',400);
                default: return Error::getError(true,'Ocorreu um error no servidor',500);
            }

        }
    }

    public function show($id)
    {
        try{
            if($id < 0 || !is_int($id)) {
                return Error::getError(true,'Id inválido, não pode ser menor que zero',400);
            }
            $equipment = $this->repository->findById($id);
            if($equipment) {
                return new EquipmentResource($equipment);
            } else {
                return Error::getError(true, 'Não existe Equipamento com ID '. $id,404);
            }
        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function update($data, $id)
    {
        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $equipment = $this->repository->update($data,$id);
            return new EquipmentResource($equipment);

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
                return Error::getError(true,'Id inválido, não pode ser menor que zero',400);
            }

            $this->repository->delete($id);
            return response()->json([], 204);


        } catch (\Exception $e) {
            switch (get_class($e))
            {
                case ModelNotFoundException::class: return Error::getError(true,'Não excluído, verifique os parâmetros',400);
                default: return Error::getError(true,'Ocorreu um error no servidor',500);
            }
        }
    }

}
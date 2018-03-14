<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 04/02/2018
 * Time: 22:43
 */

namespace App\Services;


use App\Exceptions\Error;
use App\Http\Resources\RequestCollection;
use App\Http\Resources\RequestResource;
use App\Models\Request;
use App\Repositories\RequestRepository;
use App\Validators\RequestValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class RequestService
{

    private $repository;
    private $validator;

    public function __construct(RequestValidator $validator, RequestRepository $repository)
    {
        $this->validator            = $validator;
        $this->repository           = $repository;
    }

    public function index()
    {
        try{
             return RequestResource::collection($this->repository->paginate());

        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
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

    public function newsRequests()
    {
        try{
            $requests = $this->repository->findWhere(['attendant_id' => null, 'finalized'=> '0']);
            return RequestResource::collection($requests);
        } catch(\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function openRequests()
    {
        try{
            $requests = $this->repository->findWhere(['finalized'=> '1']);
            return RequestResource::collection($requests);
        } catch(\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

}
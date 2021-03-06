<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 04/02/2018
 * Time: 22:43
 */

namespace App\Services;


use App\Exceptions\Error;
use App\Http\Resources\Request;
use App\Http\Resources\RequestResource;
use App\Http\Resources\StatusRequestResource;
use App\Repositories\AttendantRepository;
use App\Repositories\RequestRepository;
use App\Validators\RequestValidator;
use App\Validators\RequestStatusValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class RequestService
{

    private $repository;
    private $validator;
    private $attendantRepository;
    private $requestStatusValidator;

    public function __construct(RequestValidator $validator, RequestStatusValidator $requestStatusValidator, RequestRepository $repository, AttendantRepository $attendantRepository)
    {
        $this->validator                = $validator;
        $this->repository               = $repository;
        $this->attendantRepository      = $attendantRepository;
        $this->requestStatusValidator   = $requestStatusValidator;
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

            $request = $this->repository->create($data);

            $equipment_request['request_id'] = $request->id;
            $equipment_request['equipment_id'] = $data['equipment_id'];

            return new RequestResource($request);

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
            $request = $this->repository->findById($id);
            if($request) {
                return new Request($request);
            } else {
                return Error::getError(true,'Não existe solicitação com ID '.$id,404);
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

            $request = $this->repository->update($data,$id);
            return new RequestResource($request);

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
            $requests = $this->repository->orderBy('created_at', 'desc')->findWhere(['attendant_id' => null, 'finalized'=> '0']);
            return RequestResource::collection($requests);
        } catch(\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function openRequests()
    {
        try{
            $attendant = $this->attendantRepository->findWhere(['user_id'=>Auth::user()->token()->user_id]);

            if($attendant[0]->coordinator){
                $requests = $this->repository->orderBy('created_at', 'desc')->findWhere(['finalized'=> '0', ['attendant_id', '>', '0']]);
            } else {
                $requests = $this->repository->orderBy('created_at', 'desc')->findWhere(['finalized'=> '0', 'attendant_id'=>$attendant[0]->id]);
            }

            return RequestResource::collection($requests);

        } catch(\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function closedRequests()
    {
        try{
            $attendant = $this->attendantRepository->findWhere(['user_id'=>\Auth::user()->token()->user_id]);

            if($attendant[0]->coordinator){
                $requests = $this->repository->where('finalized', '=', '1', 15);
            } else {
                $requests = $this->repository->getFinalizedByAttendant($attendant[0]->id);
            }

            return RequestResource::collection($requests);

        } catch(\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function meet($id)
    {
        try{
              $attendant = $this->attendantRepository->findWhere(['user_id'=>\Auth::user()->token()->user_id]);
              if($attendant){
                  $request = $this->repository->find($id);
                  $request->attendant_id = $attendant[0]->id;

                  $this->repository->save($request);
                  return response()->json(['data'=> $request->id],200);
              } else {
                  return Error::getError(true,'Atendente não localizado',204);
              }


        } catch(\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function finalize($id)
    {
        try{
            $request = $this->repository->find($id);
            $request->finalized = true;
            $this->repository->save($request);

            return response()->json(['data'=> ['id'=>$request->id]],200);
        } catch (\Exception $e){
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function defineStatus($data)
    {
        try{
            $this->requestStatusValidator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            if($this->repository->defineStatus($data)){
                $status = $this->repository->getStatusRequest($data['request_id']);
                return StatusRequestResource::collection($status);
            }
                     

        } catch (\Exception $e){
            switch (get_class($e))
            {
                case ValidatorException::class: return $e;
                default: return Error::getError(true,'Ocorreu um error no servidor',500);
            }
        }
    }

    public function getStatusRequest($request_id)
    {
        try{
            $status = $this->repository->getStatusRequest($request_id);

            return StatusRequestResource::collection($status);

        } catch(\Exception $e){
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }
}
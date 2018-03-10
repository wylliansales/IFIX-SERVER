<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 04/02/2018
 * Time: 05:22
 */

namespace App\Services;


use App\Exceptions\Error;
use App\Services\UserService;
use App\Http\Resources\SectorResource;
use App\Repositories\SectorRepository;
use App\Validators\SectorValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class SectorService
{

       private $repository;
       private $validator;
       private $attendantService;

        public function __construct(SectorRepository $repository, SectorValidator $validator, UserService $attendantService)
       {
           $this->repository = $repository;
           $this->validator  = $validator;
           $this->attendantService = $attendantService;
       }

       public function index()
       {
           try{
               return SectorResource::collection($this->repository->paginate(7));
           } catch (\Exception $e) {
               return Error::getError(true,'Ocorreu um error no servidor',500);
           }
       }

       public function store($data)
       {
           try{
               $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

               $user = $this->repository->create($data);
               return new SectorResource($user);

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
               $sector = $this->repository->findById($id);
               if($sector) {
                   return new SectorResource($sector);
               } else {
                   return Error::getError(true,'Não existe setor com ID '.$id,404);
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

               $sector = $this->repository->update($data,$id);
               return new SectorResource($sector);

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
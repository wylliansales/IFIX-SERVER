<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 04/02/2018
 * Time: 05:22
 */

namespace App\Services;


use App\Http\Resources\SectorResource;
use App\Repositories\SectorRepository;
use App\Validators\SectorValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class SectorService
{

       private $repository;
       private $validator;

       public function __construct(SectorRepository $repository, SectorValidator $validator)
       {
           $this->repository = $repository;
           $this->validator  = $validator;
       }

       public function index()
       {
           try{
               return SectorResource::collection($this->repository->paginate());
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
}
<?php


namespace App\Services;


use App\Exceptions\Error;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class UserService
{

    private $repository;
    private $validator;

    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    public function index()
    {
        try{
            return UserResource::collection($this->repository->paginate());
        } catch (\Exception $e){
            return Error::getError(false, 'Ocorreu um error no servidor',500);
        }
    }

    public function store($data)
    {
        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->repository->create([
                'name'      => $data['name'],
                'email'      => $data['email'],
                'password'   => bcrypt($data['password']),
            ]);

            return new UserResource($user);

        } catch (\Exception  $e) {
            switch (get_class($e))
            {
                case ValidatorException::class: return $e;
                case ModelNotFoundException::class: return Error::getError(true,'Não atualizado, verifique os parâmetos',400);
                default: return Error::getError(true,'Ocorreu um error no servidor',500);
            }
        }

    }

    public function show($id)
    {
        try{
            if($id < 0) {
                return Error::getError(true, 'ID inválido, Id não pode ser menor que zero', 400);
            }
            $user = $this->repository->findById($id);

            if($user){
                return new UserResource($user);
            } else {
                return Error::getError(true, 'Não existe usuário com ID '.$id, 404);
            }

        } catch (\Exception $e){
             return Error::getError(true,'Ocorreu um error no servidor',500);

        }
    }

    public function update(array $data, $id)
    {
         try{
             $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            if($id < 0){
                return Error::getError(true, 'ID inválido, Id não pode ser menor que zero', 400);
            }
            $user = $this->repository->update($data,$id);

            return new UserResource($user);
        } catch (\Exception $e){
             switch (get_class($e))
             {
                 case ValidatorException::class: return $e;
                 case ModelNotFoundException::class: return Error::getError(true,'Não atualizado, verifique os parâmetos',400);
                 default: return Error::getError(true,'Ocorreu um error no servidor',500);
             }
        }    
    }

    public function destroy($id)
    {
        try{
            if($id < 0){
                return Error::getError(true, 'ID inválido, Id não pode ser menor que zero', 400);
            }

            if($this->repository->delete($id)){
                return response()->json([],204);
            } else {
                return Error::getError(true, 'Usuário com ID '.$id.' não encontrado', 404);
            }
        } catch (\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

    public function blocked()
    {
        try {
            $users = $this->repository->findByField('activated', '0');
            return UserResource::collection($users);
        } catch (\Exception $e) {
            return Error::getError(true, 'Ocorreu um error no servidor', 500);
        }
    }

    public function released()
    {
        try {
            $users = $this->repository->findByField('activated', '1');

            return UserResource::collection($users);

        } catch (\Exception $e) {
            return Error::getError(true, 'Ocorreu um error no servidor', 500);
        }

    }

    public function releaseUser(array $data, $id)
    {
        try{
            $user = $this->repository->find($id);
            $user->activated = true;
            $this->repository->save($user);
            return new UserResource($user);
        } catch (\Exception $e) {
            return Error::getError(true, 'Ocorreu um error no servidor', 500);
        }
    }

    public function blockUser(array $data, $id)
    {
        try{
            $user = $this->repository->find($id);
            $user->activated = false;
            $this->repository->save($user);
            return new UserResource($user);
        } catch (\Exception $e) {
            return Error::getError(true, 'Ocorreu um error no servidor', 500);
        }
    }

    public function getUserLogin()
    {
        try{
            $user = $this->repository->findById(\Auth::user()->token()->user_id);
            return new UserResource($user);

        } catch(\Exception $e) {
            return Error::getError(true,'Ocorreu um error no servidor',500);
        }
    }

}
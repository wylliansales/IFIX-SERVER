<?php


namespace App\Services;


use App\Exceptions\Error;
use App\Http\Resources\UserResource;
use App\Repositories\AttendantRepository;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class UserService
{

    private $repository;
    private $validator;
    private $attendantRepository;

    public function __construct(UserRepository $repository, UserValidator $validator, AttendantRepository $attendantRepository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->$attendantRepository = $attendantRepository;
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

    public function loginIsCoordinator($user_id){
        try{
            $attendant = $this->attendantRepository->findWhere(['user_id' => \Auth::user()->token()->user_id]);

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
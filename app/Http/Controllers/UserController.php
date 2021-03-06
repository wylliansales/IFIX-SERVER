<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Models\Attendant;
use App\Repositories\AttendantRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;


class UserController extends Controller
{
   
   private $service;

    public function __construct(UserService $service)
    {
       $this->service = $service;
    }


    public function index()
    {
        return $this->service->index();
    }


    public function store(UserRequest $request)
    {
        return $this->service->store($request->all());

    }


    public function show($id)
    {       
        return $this->service->show($id);
    }


    public function update(UserRequest $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }


    public function destroy($id)
    {
       return $this->service->destory($id);

    }

    public function loginIsCoordinator($user_id){
        return $this->service->loginIsCoordinator($user_id);
    }

    public function blocked()
    {
        return $this->service->blocked();
    }

    public function released()
    {
        return $this->service->released();
    }

    public function releaseUser(Request $request, $id)
    {
        return $this->service->releaseUser($request->all(), $id);
    }

    public function blockUser(Request $request, $id)
    {
        return $this->service->blockUser($request->all(), $id);
    }

    public function getUserLogin()
    {
        return $this->service->getUserLogin();
    }

}

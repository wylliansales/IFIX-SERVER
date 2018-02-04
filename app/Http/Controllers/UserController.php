<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;


class UserController extends Controller
{
   
   private $service;

    public function __construct(UserService $service)
    {
       $data = $this->service = $service;

       return $data;
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

    public function createToken(){
        return Token::all('user_id');
    }

}

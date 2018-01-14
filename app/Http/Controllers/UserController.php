<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;

class UserController extends Controller
{
    use \Cyvelnet\Laravel5Fractal\Traits\Transformable;

    protected $transformer;

    public function __construct()
    {
        $this->transformer = UserTransformer::class ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->transform(User::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
            $user = User::create($request->all());
            if($user){
                return response($this->transform($user), 201);
            } else {
                return response()->json(['message' => 'Erro ao criar usuário'],400);
            }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id < 0) {
            return response()->json(['message'=>'ID menor que zero, por favor, informe um ID válido'], 400);
        }
        $user = User::find($id);
        if($user){
            return $this->transform($user);
        } else {
            return response()->json(['message'=>'O usuário com id '. $id .' não existe'],404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        if($user){
            $user->update($request->all());
            return $this->transform($user);
        } else {
            return response()->json(['message'=>'O usuário com id '. $id .' não existe'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return UserResource::collection(User::paginate());
        } catch(\Exception $e) {
            return response()->json(['message'=>'Ocorreu um error no servidor, contate o administrador'],500);
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try{
            $user = User::create($request->all());
            if($user){
                return new UserResource($user);
            } else {
                return response()->json(['message' => 'Erro ao criar usuário'],400);
            }
        } catch (\Exception $e) {
            return response()->json(['message'=>'Ocorreu um error no servidor, contate o administrador'],500);
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
        try{
            if($id < 0) {
                return response()->json(['message'=>'ID menor que zero, por favor, informe um ID válido'], 400);
            }
            $user = User::find($id);
            if($user){
                return new UserResource($user);
            } else {
                return response()->json(['message'=>'O usuário com id '. $id .' não existe'],404);
            }
        } catch (\Exception $e) {
            return response()->json(['message'=>'Ocorreu um error no servidor, contate o administrador'],500);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $user = User::find($id);
            if($user){
                $user->update($request->all());
                return new UserResource($user);
            } else {
                return response()->json(['message'=>'O usuário com id '. $id .' não existe'],404);
            }
        } catch (\Exception $e) {
            return response()->json(['message'=>'Ocorreu um error no servidor, contate o administrador'],500);
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
        try{
            if($id < 0){
                return response()->json(['message'=>'ID inválido'],400);
            }

            $user = User::find($id);
            if($user){
                $user->activated = false;
                $user->save();
                return response()->json([],204);
            } else {
                return response()->json(['message'=>'Usuário com id '.$id.' não existe'],404);
            }
        } catch (\Exception $e) {
            return response()->json(['message'=>'Ocorreu um error no servidor, contate o administrador'],500);
        }

    }
}

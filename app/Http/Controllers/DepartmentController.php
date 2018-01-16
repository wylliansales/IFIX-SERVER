<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\Department as DepartmentResource;
use App\Models\Department;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return DepartmentResource::collection(Department::all());
        } catch (\Exception $e) {
            return response()->json(['message'=>'Ocorreu um error no servidor, contate o administrador'],500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try{
            $department = Department::create($request->all());
            if ($department) {
                return new DepartmentResource($department);
            } else {
                return response()->json(['message'=>'Error ao cadastrar Departamento'],400);
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
            if($id < 0){
                return response()->json(['message'=>'ID menor que zero, por favor, informe um ID válido'], 400);
            }
            $department = Department::find($id);
            if($department){
                return new DepartmentResource($department);
            } else {
                return response()->json(['message'=>'Departamento com id '.$id.' não encontrato'],404);
            }
        } catch(\Exception $e) {
            return response()-> json(['message'=>'Ocorreu um error no servidor, contate o administrador'],500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        try{
            if($id < 0){
                return response()->json(['message'=>'ID menor que zero, por favor, informe um ID válido'], 400);
            }
            $department = Department::find($id);
            if($department){
                $department->update($request->all());
                return new DepartmentResource($department);
            } else {
                return response()->json(['message'=>'Não existe Departamento com ID '.$id],404);
            }
        } catch (\Exception $e) {
            return response()->json(['message'=>'Ocorreu um error no servidor'],500);
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

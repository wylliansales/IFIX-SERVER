<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource as DepartmentResource;
use App\Models\Department;
use App\Exceptions\Error;


class DepartmentController extends Controller
{
    /**
     * Lista os Departamentos cadastrados.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try{
            return DepartmentResource::collection(Department::all());
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Cadastra Departamento no Banco de dados.
     *
     * @param DepartmentRequest $request
     * @return DepartmentResource|\Illuminate\Http\JsonResponse
     */
    public function store(DepartmentRequest $request)
    {
        try{
            $department = Department::create($request->all());
            if ($department) {
                return new DepartmentResource($department);
            } else {
                return Error::getError('Error ao cadastrar Departamento','Departamento não cadastrado',400);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Busca Departamento pelo ID.
     *
     * @param int $id
     * @return DepartmentResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try{
            if($id < 0){
                return Error::getError('ID ivalido','ID menor que zero, por favor, informe um ID válido',400);
            }
            $department = Department::find($id);
            if($department){
                return new DepartmentResource($department);
            } else {
                return Error::getError('Não existe','Não existe Departamento com ID '.$id,404);
            }
        } catch(\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Atualiza o cadastro do Departamendo com ID informado.
     *
     * @param DepartmentRequest $request
     * @param int $id
     * @return DepartmentResource|\Illuminate\Http\JsonResponse
     */
    public function update(DepartmentRequest $request, $id)
    {
        try{
            if($id < 0){
                return Error::getError('ID ivalido','ID menor que zero, por favor, informe um ID válido',400);
            }
            $department = Department::find($id);
            if($department){
                $department->update($request->all());
                return new DepartmentResource($department);
            } else {
                return Error::getError('Não encotrato','Não existe Departamento com ID '.$id,404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Remove o Departamento com ID Informado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if($id < 0) {
                return Error::getError('ID inválido','ID não pode ser menor que zero',400);
            }
            $department = Department::find($id);
            if($department) {
                try{
                    $department->delete();
                } catch (\Illuminate\Database\QueryException $e) {
                    return Error::getError('Error ao excluir Departamento',
                                            'O Departamento está relacionado à um Atendente',
                                            500);
                }

                return response()->json([],204);
            } else {
                return Error::getError('Não existe','Não existe Departamento com ID '.$id,404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }

    }
}

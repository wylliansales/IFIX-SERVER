<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Http\Requests\EquipmentRequest;
use App\Http\Resources\Equipment as EquipmentResource;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    /**
     * Lista os Equipamentos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return EquipmentResource::collection(Equipment::paginate());
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }

    }

    /**
     * Cadastra Equipamento no Banco de dados.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EquipmentRequest $request)
    {
        try{
            $equipment = Equipment::create($request->all());
            if($equipment){
                return new EquipmentResource($equipment);
            } else {
                return Error::getError('Error ao cadastrar equipamento','Equipamento não cadastrado',400);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Busca equipamento por ID.
     *
     * @param int $id
     * @return EquipmentResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try{
            if($id < 0) {
                return Error::getError('Id inválido','ID não pode ser menor que zero',400);
            }
            $equipment = Equipment::find($id);
            if($equipment) {
                return new EquipmentResource($equipment);
            } else {
                return Error::getError('Não encotrado', 'Não existe Equipamento com id '. $id,404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
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
        //
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

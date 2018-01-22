<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Http\Requests\AttendantRequest;
use App\Http\Resources\AttendantResource as AttendantResource;
use App\Models\Attendant;

class AttendantController extends Controller
{

    public function index()
    {
        try{
            return AttendantResource::collection(Attendant::paginate());
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }

    }


    public function store(AttendantRequest $request)
    {
        try{
            $attendant = Attendant::create($request->all());
            if($attendant) {
                return new AttendantResource($attendant);
            } else {
                return Error::getError('Erro ao adicinar atendente','Atendente não cadastrado',400);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }


    public function show($id)
    {
        try{
            if($id < 0) {
                return Error::getError('ID inválido', 'ID não pode ser menor que zero', 400);
            }
            $attendant = Attendant::find($id);
            if($attendant) {
                return new AttendantResource($attendant);
            } else {
                return Error::getError('Não encontrato','Não existe atendente com ID '.$id,404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }



    public function update(AttendantRequest $request, $id)
    {
        try{
            if($id < 0) {
                return Error::getError('ID inválido', 'ID não pode ser menor que zero', 400);
            }
            $attendant = Attendant::find($id);
            if($attendant){
                $attendant->update($request->all());
                return new AttendantResource($attendant);
            } else {
                return Error::getError('Não encontrado','Não existe atendente com ID '. $id,404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }


    public function destroy($id)
    {
        try{
            if($id < 0) {
                return Error::getError('ID inválido', 'ID não pode ser menor que zero', 400);
            }
            $attendant = Attendant::find($id);
            if($attendant){
                try{
                    $attendant->delete();
                } catch (\Illuminate\Database\QueryException $e) {
                    return Error::getError('Error ao excluir Atendente',
                        'O Atendente está relacionada à um solicitação',
                        500);
                }
                return response()->json([], 204);
            } else {
                return Error::getError('Não existe', 'Não existe atendente com ID ' . $id, 404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }
}

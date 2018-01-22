<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Http\Requests\SectorRequest;
use App\Http\Resources\SectorResource as SectorResource;
use App\Models\Sector;

class SectorController extends Controller
{

    public function index()
    {
        try{
            $sector = Sector::paginate();
            return SectorResource::collection($sector);
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }


    public function store(SectorRequest $request)
    {
        try{
            $sector = Sector::create($request->all());
            if($sector){
                return new SectorResource($sector);
            } else {
                return Error::getError('Erro ao adicinar setor','Setor não cadastrado',400);
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
            $sector = Sector::find($id);
            if($sector) {
                return new SectorResource($sector);
            } else {
                return Error::getError('Não encontrato','Não existe setor com ID '.$id,404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }


    public function update(SectorRequest $request, $id)
    {
        try{
            if($id < 0) {
                return Error::getError('ID inválido', 'ID não pode ser menor que zero', 400);
            }
            $sector = Sector::find($id);
            if($sector){
                $sector->update($request->all());
                return new SectorResource($sector);
            } else {
                return Error::getError('Não encontrado','Não existe setor com ID '. $id,404);
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
            $sector = Sector::find($id);
            if($sector){
                try{
                    $sector->delete();
                } catch (\Illuminate\Database\QueryException $e) {
                    return Error::getError('Error ao excluir Setor',
                        'O Setor está relacionada à um equipamento',
                        500);
                }
                return response()->json([], 204);
            } else {
                return Error::getError('Não existe', 'Não existe setor com ID ' . $id, 404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }
}

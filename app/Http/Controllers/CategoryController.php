<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Lista de Categorias cadastradas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return CategoryResource::collection(Category::paginate());
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Cadastra Categoria no Banco de dados.
     *
     * @param CategoryRequest $request
     * @return CategoryResource|\Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        try{
            $category = Category::create($request->all());
            if($category){
                return new CategoryResource($category);
            } else {
                return Error::getError('Erro ao adicionar categoria','Categoria não cadastrada',400);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Busca Categoria pelo ID.
     *
     * @param int $id
     * @return CategoryResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try{
            if($id < 0) {
                return Error::getError('ID inválido', 'ID não pode ser menor que zero', 400);
            }
            $category = Category::find($id);
            if($category) {
                return new CategoryResource($category);
            } else {
                return Error::getError('Não encontrado', 'Não existe Departamento com ID '.$id, 404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Atualiza a Categoria com o ID informado.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return CategoryResource|\Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        try{
            if($id < 0) {
                return Error::getError('ID inválido', 'ID não pode ser menor que zero', 400);
            }
            $category = Category::find($id);
            if($category) {
                $category->update($request->all());
                return new CategoryResource($category);
            } else {
                return Error::getError('Não encontrato', 'Não existe Departamento com ID '.$id, 404);
            }
        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }
    }

    /**
     * Remove a Categoria com ID informado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($id < 0) {
                return Error::getError('ID inválido', 'ID não pode ser menor que zero', 400);
            }
            $category = Category::find($id);
            if ($category) {
                try{
                    $category->delete();
                } catch (\Illuminate\Database\QueryException $e) {
                    return Error::getError('Error ao excluir Categoria',
                        'Está categoria está relacionada à um equipamento',
                        500);
                }
                return response()->json([], 204);
            } else {
                return Error::getError('Não existe', 'Não existe Categoria com ID ' . $id, 404);
            }

        } catch (\Exception $e) {
            return Error::getError('Error no servidor', 'Ocorreu um Error no servidor', 500);
        }

    }
}

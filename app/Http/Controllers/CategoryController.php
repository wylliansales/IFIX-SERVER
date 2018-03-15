<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource as CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{

    private $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function store(CategoryRequest $request)
    {
        return $this->service->store($request-all());
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(CategoryRequest $request, $id)
    {
       return $this->update($request->all(), $id);
    }

    public function destroy($id)
    {
       return $this->destroy($id);
    }
}

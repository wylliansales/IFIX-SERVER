<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Services\DepartmentService;


class DepartmentController extends Controller
{

    private $service;

    public function __construct(DepartmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }


    public function store(DepartmentRequest $request)
    {
       return $this->service->store($request->all());
    }


    public function show($id)
    {
        return $this->service->show($id);
    }


    public function update(DepartmentRequest $request, $id)
    {
       return $this->service->update($request->all(), $id);
    }

    public function destroy($id)
    {
       return $this->service->destroy($id);
    }
}

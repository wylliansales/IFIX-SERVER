<?php

namespace App\Http\Controllers;

use App\Services\StatusService;

class StatusController extends Controller
{
    private $service;

    public function __construct(StatusService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        return $this->service->index();
    }


    public function store(StatusRequest $request)
    {
        return $this->service->store($request->all());
    }


    public function show($id)
    {
        return $this->service->show($id);
    }


    public function update(StatusRequest $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }


    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Http\Requests\EquipmentRequest;
use App\Http\Resources\EquipmentResource as EquipmentResource;
use App\Models\Equipment;
use App\Services\EquipmentService;

class EquipmentController extends Controller
{

    private $service;

    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        return $this->service->index();
    }


    public function store(EquipmentRequest $request)
    {
        return $this->service->store($request->all());
    }


    public function show($id)
    {
        return $this->service->show($id);
    }



    public function update(EquipmentRequest $request, $id)
    {
        return $this->service->update($request->all(),$id);
    }


    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}

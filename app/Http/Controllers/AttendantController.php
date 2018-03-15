<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Http\Requests\AttendantRequest;
use App\Http\Resources\AttendantResource as AttendantResource;
use App\Models\Attendant;
use App\Services\AttendantService;

class AttendantController extends Controller
{

    private $service;

    public function __construct(AttendantService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function store(AttendantRequest $request)
    {
        return $this->service->store($request->all());
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(AttendantRequest $request, $id)
    {
        return $this->service->update($request->all(),$id);
    }


    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public function myRequests()
    {
        return $this->service->myRequests();
    }
}

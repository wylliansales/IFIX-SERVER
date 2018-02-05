<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Http\Requests\SectorRequest;
use App\Http\Resources\SectorResource as SectorResource;
use App\Models\Sector;
use App\Services\SectorService;

class SectorController extends Controller
{

    private $service;

    public function __construct(SectorService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
       return $this->service->index();
    }


    public function store(SectorRequest $request)
    {
       return $this->service->store($request->all());
    }


    public function show($id)
    {
        return $this->service->show($id);
    }


    public function update(SectorRequest $request, $id)
    {
       return $this->service->update($request->all(), $id);
    }


    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}

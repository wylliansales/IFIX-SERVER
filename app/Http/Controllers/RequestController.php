<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestRequest;
use Illuminate\Http\Request;
use App\Services\RequestService;


class RequestController extends Controller
{

    private $service;

    public function __construct(RequestService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }



    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(RequestRequest $request, $id)
    {
        $this->service->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public function newsRequests()
    {
        return $this->service->newsRequests();
    }

    public function openRequests()
    {
        return $this->service->openRequests();
    }

    public function closedRequests()
    {
        return $this->service->closedRequests();
    }

    public function meet(Request $request, $id)
    {
        return $this->service->meet($id);
    }

    public function finalize(Request $request, $id)
    {
        return $this->service->finalize($id);
    }

    public function defineStatus(Request $request)
    {
        return $this->service->defineStatus($request->all());
    }

    public function getStatusRequest($id)
    {
        return $this->service->getStatusRequest($id);
    }
}

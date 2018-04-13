<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class StatusRequestResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
               'name'           => $this->name,
               'description'    => $this->description,
               'observation'    => $this->observation,
               'created_at'     => $this->created_at 
        ];
    }
}

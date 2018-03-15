<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Request extends Resource
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
            'id'                => $this->id,
            'subject_matter'    => $this->subject_matter,
            'description'       => $this->description,
            'department'        =>  new DepartmentResource($this->department),
            'user'              =>  new UserResource($this->user),
            'attendant'         =>  new AttendantResource($this->attendant),
            'equipaments'       =>  EquipmentResource::collection($this->equipaments),
            'status'            =>  StatusResource::collection($this->status),
            'finalized'         => $this->finalized,
            'created_at'        => optional($this->created_at)->format('d/m/Y H:i'),

        ];
    }
}

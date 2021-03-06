<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AttendantResource extends Resource
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
            'id'            => $this->id,
            'name'          => $this->user->name,
            'email'         => $this->user->email,
            'active'        => $this->active,
            'coordinator'   => $this->coordinator,
            'departments'   => DepartmentResource::collection($this->departments),
            
        ];
    }
}

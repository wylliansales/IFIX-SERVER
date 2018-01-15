<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Attendant extends Resource
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
            'coordinator'   => $this->coordinator,
        ];
    }
}

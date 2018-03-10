<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class StatusResource extends Resource
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
            'name'          => $this->name,
            'description'   => $this->description,
            'created_at'    => optional($this->created_at)->format('d/m/Y'),
            'updated_at'    => optional($this->updated_at)->format('d/m/Y')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EquipmentResource extends Resource
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
            'code'          => $this->code,
            'description'   => $this->description,
            'created_at'    => $this->created_at->format('d/m/Y'),
            'updated_at'    => $this->updated_at->format('d/m/Y'),
            'category'      => $this->category,
        ];
    }
}

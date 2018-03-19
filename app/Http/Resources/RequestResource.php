<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RequestResource extends Resource
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
            'department'        => optional($this->department)->name,
            'user'              => optional($this->user)->name,
           // 'attendant'         => !empty($this->attendant_id)? $this->attendant->user->name: null,
            'finalized'         => $this->finalized,
            'created_at'        => optional($this->created_at)->format('d/m/Y H:i'),
        ];
    }
}

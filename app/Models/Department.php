<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function attendants()
    {
        return $this->belongsToMany('App\Models\Attendant', 'attendant_department');
    }
}

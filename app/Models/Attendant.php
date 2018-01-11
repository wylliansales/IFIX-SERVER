<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
    protected $fillable = [
        'user_id', 'coordinator'
    ];


    public function departments()
    {
        return $this->belongsToMany('App\Models\Department', 'attendant_department');
    }
}

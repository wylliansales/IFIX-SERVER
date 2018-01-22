<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'department_id','user_id','subject_matter', 'description'
    ];

    public function equipaments()
    {
        return $this->belongsToMany('App\Models\Equipment', 'equipment_request');
    }

    public function status()
    {
        return $this->belongsToMany('App\Models\Status', 'request_status');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

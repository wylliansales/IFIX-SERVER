<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class administrator extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        $this->belongsTo('App\Models\User');
    }

}

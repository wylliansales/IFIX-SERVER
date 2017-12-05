<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class attendant extends Model
{
    protected $fillable = [
        'user_id', 'coordinator'
    ];
}

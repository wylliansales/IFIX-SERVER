<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'department_id','user_id','subject_matter', 'description'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requests_has_Equipments extends Model
{
        protected $fillable = [
            'request_id', 'equipment_id'
        ];

        protected $table = 'requests_has_equipments';
}

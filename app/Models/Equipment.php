<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'sector_id', 'category_id', 'code', 'description'
    ];

    protected $table = 'equipments';

    public function requests()
    {
        return $this->belongsToMany('App\Models\Request', 'equipment_request');
    }

    public function sector()
    {
        return $this->belongsTo('App\Models\Sector');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}

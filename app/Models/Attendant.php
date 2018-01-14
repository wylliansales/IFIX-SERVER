<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attendant
 * @package App\Models
 *
 * @property int user_id
 * @property  boolean coordinator
 */
class Attendant extends Model
{
    protected $fillable = [
        'user_id', 'coordinator'
    ];


    public function departments()
    {
        return $this->belongsToMany('App\Models\Department', 'attendant_department');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User','user_id','id');
    }
}

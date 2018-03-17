<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Department.
 * @package namespace App\Models;
 *
 * @property int id
 * @property string name
 * @property string description
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Department extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = ['name', 'description'];
    protected $dates = ['deleted_at'];

    public function attendants()
    {
        return $this->belongsToMany('App\Models\Attendant', 'attendant_department');
    }

    public function requests()
    {
        return $this->hasMany('App\Models\Request');
    }

}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Attendant.
 * @package namespace App\Models;
 *
 * @property int id
 * @property int user_id
 * @property boolean coordinator
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Attendant extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = ['user_id', 'coordinator'];
    protected $dates = ['deleted_at'];

    public function departments()
    {
        return $this->belongsToMany('App\Models\Department', 'attendant_department');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}

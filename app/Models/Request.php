<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Request.
 * @package namespace App\Models;
 *
 * @property int id
 * @property int department_id
 * @property int user_id
 * @property string subject_matter
 * @property string description
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Request extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = ['department_id','user_id', 'attendant_id', 'subject_matter', 'description', 'finalized'];
    protected $dates = ['deleted_at'];
    protected $hidden = ['deleted_at'];

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

    public function attendant()
    {
        return $this->belongsTo('App\Models\Attendant', 'attendant_id','id' );
    }
}

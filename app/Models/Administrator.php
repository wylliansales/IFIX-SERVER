<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Administrator.
 *
 * @package namespace App\Models;
 *
 * @property int id
 * @property int user_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Administrator extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id'];
    protected $dates = ['deleted_at'];

}

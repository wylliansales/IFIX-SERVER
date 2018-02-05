<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Category.
 * @package namespace App\Models;
 *
 * @property int id
 * @property string name
 * @property string description
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Category extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable =['name', 'description'];
    protected $dates = ['deleted_at'];
}

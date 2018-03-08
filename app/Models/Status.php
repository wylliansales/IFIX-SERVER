<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Status
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property string description
 * @property Cabon created_at
 * @property Cabon updated_at
 */
class Status extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name','description',];
    protected $dates = ['deleted_at'];
    protected $table = 'status';

}

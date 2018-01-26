<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Status.
 *
 * @package namespace App\Models;
 */
class Status extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name','description',
    ];

    protected $table = 'status';

}

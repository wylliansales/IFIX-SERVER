<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Equipment.
 * @package namespace App\Models;
 *
 * @property int id
 * @property int sector_id
 * @property int category_id
 * @property string code
 * @property string description
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Equipment extends Model implements Transformable
{
    use TransformableTrait;

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

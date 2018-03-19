<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EquipmentRepository;
use App\Models\Equipment;
use App\Validators\EquipmentValidator;

/**
 * Class EquipmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EquipmentRepositoryEloquent extends BaseRepository implements EquipmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Equipment::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function searchEquipment($term)
    {
        return $this->model
            ->leftJoin('categories', 'equipments.category_id', '=', 'categories.id')
            ->where('code', 'like', $term.'%')
            ->orWhere('equipments.description', 'like', $term.'%')
            ->orWhere('categories.name', 'like', $term.'%')
            ->orderBy('code', 'asc')
            ->limit(8)
            ->get();
    }
    
}

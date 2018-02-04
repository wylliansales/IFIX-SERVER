<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SectorRepository;
use App\Models\Sector;
use App\Validators\SectorValidator;

/**
 * Class SectorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SectorRepositoryEloquent extends BaseRepository implements SectorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sector::class;
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
}

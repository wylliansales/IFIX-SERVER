<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdministratorRepository;
use App\Models\Administrator;
use App\Validators\AdministratorValidator;

/**
 * Class AdministratorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdministratorRepositoryEloquent extends BaseRepository implements AdministratorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Administrator::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

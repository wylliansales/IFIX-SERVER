<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AttendantRepository;
use App\Models\Attendant;
use App\Validators\AttendantValidator;

/**
 * Class AttendantRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AttendantRepositoryEloquent extends BaseRepository implements AttendantRepository
{

    protected $fieldSearchable = [
            'user.name'         => 'like',
            'user.email'        => 'like',
            'departments.name'  => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Attendant::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

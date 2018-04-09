<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\StatusRepository;
use App\Models\Status;
use App\Validators\StatusValidator;

/**
 * Class StatusRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StatusRepositoryEloquent extends BaseRepository implements StatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Status::class;
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

    public function searchStatus($term)
    {
        return \DB::table('status')
            ->where('name', 'like', $term.'%')
            ->orWhere('description', 'like', $term.'%')
            ->orderBy('name', 'asc')
            ->limit(8)
            ->get();
    }
    
}

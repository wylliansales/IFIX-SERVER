<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RequestRepository;
use App\Models\Request;
use App\Validators\RequestValidator;

/**
 * Class RequestRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RequestRepositoryEloquent extends BaseRepository implements RequestRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Request::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function where($column, $condition, $value, $paginate)
    {
        return $this->model->where($column, $condition, $value)->paginate($paginate);
    }


    public function getFinalizedByAttendant($attendant_id)
    {
        return $this->model->where([
            ['finalized', '=', '1'],
            ['attendant_id', '=', $attendant_id]
        ])->paginate(15);
    }

    public function save(Request $request)
    {
        $request->save();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }


}

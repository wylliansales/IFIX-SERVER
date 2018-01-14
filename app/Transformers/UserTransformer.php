<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;


class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * Transform object into a generic array
     *
     * @var $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'        => (int) $user->id,
			'name'      => $user->name,
            'email'     => $user->email,
            'activated' => $user->activated,
            'created_at'=> $user->created_at->format('d/m/Y'),
            'updated_at'=> $user->updated_at->format('d/m/Y'),
        ];
    }
}

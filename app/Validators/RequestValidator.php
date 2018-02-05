<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class RequestValidator.
 *
 * @package namespace App\Validators;
 */
class RequestValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'department_id' => 'required|int',
            'user_id'       => 'required|int',
            'subject_matter'=> 'required|min:3',
            'description'   => 'required|min:3',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'department_id' => 'required|int',
            'user_id'       => 'required|int',
            'subject_matter'=> 'required|min:3',
            'description'   => 'required|min:3',
        ],
    ];
}

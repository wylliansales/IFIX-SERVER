<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class AttendantValidator.
 *
 * @package namespace App\Validators;
 */
class AttendantValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id'       => 'required|integer|min:1'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'user_id'       => 'required|integer|min:1'
        ],
    ];
}

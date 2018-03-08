<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class SectorValidator.
 *
 * @package namespace App\Validators;
 */
class StatusValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'          => 'required|min:3',
            'description'   => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'          => 'required|min:3',
            'description'   => 'required'
        ],
    ];
}

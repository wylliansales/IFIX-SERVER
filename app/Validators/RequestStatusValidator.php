<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class RequestStatusValidator.
 *
 * @package namespace App\Validators;
 */
class RequestStatusValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
        	'request_id' 		=> 'required|int',
            'status_id'       	=> 'required|int',
            'observation'		=> 'required|min:3',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}

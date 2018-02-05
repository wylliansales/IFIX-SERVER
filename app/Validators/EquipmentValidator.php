<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EquipmentValidator.
 *
 * @package namespace App\Validators;
 */
class EquipmentValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'sector_id'     => 'required|int',
            'category_id'   => 'required|int',
            'description'   => 'required|min:3',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'sector_id'     => 'required|int',
            'category_id'   => 'required|int',
            'description'   => 'required|min:3',
        ],
    ];
}

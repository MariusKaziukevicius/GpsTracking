<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Latitude extends Constraint
{
    public $message = 'Latitude is not valid.';
}
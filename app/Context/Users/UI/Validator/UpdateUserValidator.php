<?php

namespace App\Context\Users\UI\Validator;

use App\Context\Users\Domain\UserEmail;
use Cordo\Core\UI\Validator\AbstractValidator;

class UpdateUserValidator extends AbstractValidator
{
    protected function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:filter',
                'max:' . UserEmail::EMAIL_MAX_LENGTH,
            ],
            'active' => 'required|boolean'
        ];
    }
}

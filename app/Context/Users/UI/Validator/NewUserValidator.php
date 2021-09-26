<?php

namespace App\Context\Users\UI\Validator;

use App\Context\Users\Domain\UserEmail;
use App\Context\Users\Domain\UserPassword;
use Cordo\Core\UI\Validator\AbstractValidator;
use Particle\Validator\Exception\InvalidValueException;
use App\Context\Users\Application\Service\UserQueryService;
use Cordo\Core\Application\Exception\ResourceNotFoundException;

class NewUserValidator extends AbstractValidator
{
    private $service;
    
    public function __construct(UserQueryService $service)
    {
        parent::__construct();
        $this->service = $service;
    }
    
    protected function validationRules(): void
    {
        $this->validator
            ->required('password')
            ->string()
            ->lengthBetween(UserPassword::PASSWORD_MIN_LENGTH, UserPassword::PASSWORD_MAX_LENGTH);

        $this->validator
            ->required('email')
            ->email()
            ->lengthBetween(0, UserEmail::EMAIL_MAX_LENGTH)
            ->callback(function ($value) {
                try {
                    $this->service->getOneByEmail($value);
                    throw new InvalidValueException('Email address is not unique', 'Unique::EMAIL_NOT_UNIQUE');
                } catch (ResourceNotFoundException $exception) {
                    return true;
                }
            });
    }
}

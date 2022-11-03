<?php

namespace App\Context\Users\UI\Validator;

use App\Context\Users\Domain\UserEmail;
use App\Context\Users\Domain\UserPassword;
use Cordo\Core\UI\Validator\AbstractValidator;
use App\Context\Users\Application\Service\UserQueryService;
use Cordo\Core\Application\Exception\ResourceNotFoundException;

class NewUserValidator extends AbstractValidator
{
    private $service;
    
    public function __construct(UserQueryService $service, array $data)
    {
        parent::__construct($data);
        $this->service = $service;
    }
    
    protected function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'between:' . UserPassword::PASSWORD_MIN_LENGTH . ', ' . UserPassword::PASSWORD_MAX_LENGTH,
            ],
            'email' => [
                'required',
                'email:filter',
                'max:' . UserEmail::EMAIL_MAX_LENGTH,
                function ($attribute, $value, $fail) {
                    try {
                        $this->service->getOneByEmail($value);
                        $fail($this->factory->getTranslator()->get('validation.callbacks.email_exists'));
                    } catch (ResourceNotFoundException $exception) {
                        return true;
                    }
                },
            ],
        ];
    }
}

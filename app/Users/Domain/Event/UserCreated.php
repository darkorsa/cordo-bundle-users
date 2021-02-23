<?php

declare(strict_types=1);

namespace App\Context\Users\Domain\Event;

use League\Event\AbstractEvent;

class UserCreated extends AbstractEvent
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getName()
    {
        return 'context.users.created';
    }

    public function email(): string
    {
        return $this->email;
    }
}

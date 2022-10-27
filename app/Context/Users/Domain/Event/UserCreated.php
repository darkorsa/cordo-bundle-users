<?php

declare(strict_types=1);

namespace App\Context\Users\Domain\Event;

use League\Event\AbstractEvent;

class UserCreated extends AbstractEvent
{
    public function __construct(public readonly string $email)
    {
    }

    public function getName()
    {
        return 'context_users.created';
    }
}

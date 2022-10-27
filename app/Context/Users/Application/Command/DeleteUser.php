<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Command;

class DeleteUser
{
    public function __construct(public readonly string $id)
    {
    }
}

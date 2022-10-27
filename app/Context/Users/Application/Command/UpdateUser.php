<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Command;

class UpdateUser
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly bool $isActive,
    ) {
    }
}

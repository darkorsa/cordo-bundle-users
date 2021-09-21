<?php

namespace App\Context\Users\Domain;

use Cordo\Core\Domain\ValueObject\Uuid;

use Ramsey\Uuid\Uuid as RamseyUuid;

class UserId extends Uuid
{
    public static function random(): self
    {
        return new self(RamseyUuid::uuid1()->toString());
    }
}

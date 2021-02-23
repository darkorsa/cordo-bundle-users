<?php

namespace App\Context\Acl\Application\Service;

interface AuthServiceInterface
{
    public function hashPassword(string $password): string;
}

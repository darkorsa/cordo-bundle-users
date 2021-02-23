<?php

use App\Context\Acl\Application\Command\CreateUserAcl;
use App\Context\Acl\Application\Command\DeleteUserAcl;
use App\Context\Acl\Application\Command\UpdateUserAcl;
use App\Context\Acl\Application\Command\Handler\CreateUserAclHandler;
use App\Context\Acl\Application\Command\Handler\DeleteUserAclHandler;
use App\Context\Acl\Application\Command\Handler\UpdateUserAclHandler;

return [
    CreateUserAcl::class    => CreateUserAclHandler::class,
    UpdateUserAcl::class    => UpdateUserAclHandler::class,
    DeleteUserAcl::class    => DeleteUserAclHandler::class,
];

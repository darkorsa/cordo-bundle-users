<?php

use App\Context\Acl\Application\Service\AclQueryService;
use App\Context\Acl\Application\Command\Handler\CreateUserAclHandler;
use App\Context\Acl\Application\Command\Handler\DeleteUserAclHandler;
use App\Context\Acl\Application\Command\Handler\UpdateUserAclHandler;
use App\Context\Acl\Infrastructure\Persistance\Doctrine\Query\AclDoctrineQuery;
use App\Context\Acl\Infrastructure\Persistance\Doctrine\ORM\AclDoctrineRepository;
use App\Context\Users\Infrastructure\Persistance\Doctrine\ORM\UserDoctrineRepository;

return [
    CreateUserAclHandler::class => DI\create()
        ->constructor(
            DI\get(AclDoctrineRepository::class),
            DI\get(UserDoctrineRepository::class),
            DI\get('emitter')
        ),
    UpdateUserAclHandler::class => DI\create()
        ->constructor(
            DI\get(AclDoctrineRepository::class),
            DI\get(UserDoctrineRepository::class),
            DI\get('emitter')
        ),
    DeleteUserAclHandler::class => DI\create()
        ->constructor(
            DI\get(AclDoctrineRepository::class),
            DI\get('emitter')
        ),
    'context.acl.query.service' => DI\create(AclQueryService::class)
        ->constructor(DI\get(AclDoctrineQuery::class)),
];

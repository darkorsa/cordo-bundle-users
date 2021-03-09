<?php

use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Application\Service\UserQueryService;
use App\Context\Users\Infrastructure\Persistance\Doctrine\Query\UserDoctrineQuery;
use App\Context\Users\Infrastructure\Persistance\Doctrine\ORM\UserDoctrineRepository;

return [
    UserRepository::class => DI\autowire(UserDoctrineRepository::class),
    'context.users.query.service' => DI\create(UserQueryService::class)
        ->constructor(DI\get(UserDoctrineQuery::class)),
];

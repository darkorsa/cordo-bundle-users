<?php

use App\Context\Acl\Domain\AclRepository;
use App\Context\Acl\Application\Service\AclQueryService;
use App\Context\Acl\Infrastructure\Persistance\Doctrine\Query\AclDoctrineQuery;
use App\Context\Acl\Infrastructure\Persistance\Doctrine\ORM\AclDoctrineRepository;

return [
    AclRepository::class => DI\autowire(AclDoctrineRepository::class),
    'context.acl.query.service' => DI\create(AclQueryService::class)
        ->constructor(DI\get(AclDoctrineQuery::class)),
];

<?php

declare(strict_types=1);

namespace App\Context\Users\Infrastructure\Persistance\Doctrine\Query;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use App\Context\Users\Application\Query\UserView;
use App\Context\Users\Application\Query\UserQuery;
use Cordo\Core\Application\Query\QueryFilterInterface;
use Cordo\Core\Infractructure\Persistance\Doctrine\Query\BaseQuery;

class UserDoctrineQuery extends BaseQuery implements UserQuery
{
    public function count(?QueryFilterInterface $userFilter = null): int
    {
        $queryBuilder = $this->createQB();
        $queryBuilder
            ->select('count(u.id_user)')
            ->from('context_user', 'u');

        return (int) $this->column($queryBuilder, new UserDoctrineFilter($userFilter));
    }

    public function getOne(QueryFilterInterface $userFilter): UserView
    {
        return $this->getOneByQuery($this->createQB(), $userFilter);
    }

    public function getAll(?QueryFilterInterface $userFilter = null): ArrayCollection
    {
        $queryBuilder = $this->createQB();
        $queryBuilder
            ->select('u.*')
            ->from('context_user', 'u');

        $usersData = $this->all($queryBuilder, new UserDoctrineFilter($userFilter));

        return $this->createCollection($usersData, UserView::class);
    }

    private function getOneByQuery(QueryBuilder $queryBuilder, ?QueryFilterInterface $userFilter = null): UserView
    {
        $queryBuilder
            ->select('u.*')
            ->from('context_user', 'u');

        $userData = $this->assoc($queryBuilder, new UserDoctrineFilter($userFilter));

        return UserView::fromArray($userData);
    }
}

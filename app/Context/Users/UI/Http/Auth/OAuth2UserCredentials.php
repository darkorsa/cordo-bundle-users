<?php

namespace App\Context\Users\UI\Http\Auth;

use Doctrine\DBAL\Connection;
use OAuth2\Storage\UserCredentialsInterface;

class OAuth2UserCredentials implements UserCredentialsInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function checkUserCredentials($username, $password)
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('u.password')
            ->from('context_user', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $username);

        $result = $this->connection->fetchAssociative($queryBuilder->getSQL(), $queryBuilder->getParameters());

        if (!$result || !password_verify($password, $result['password'])) {
            return false;
        }

        return true;
    }

    public function getUserDetails($username)
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('u.id_user as id_user')
            ->from('context_user', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $username);

        $userId = $this->connection->fetchOne($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return ['user_id' => $userId];
    }
}

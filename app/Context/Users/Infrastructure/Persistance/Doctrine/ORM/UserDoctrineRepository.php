<?php

declare(strict_types=1);

namespace App\Context\Users\Infrastructure\Persistance\Doctrine\ORM;

use App\Context\Users\Domain\User;
use Doctrine\ORM\EntityManager;
use App\Context\Users\Domain\UserRepository;
use Cordo\Core\Application\Exception\ResourceNotFoundException;

class UserDoctrineRepository implements UserRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find(string $id): User
    {
        /**
         * @var \App\Context\Users\Domain\User | null $user
         */
        $user = $this->entityManager->find(User::class, $id);

        if (!$user) {
            throw new ResourceNotFoundException();
        }

        return $user;
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function update(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}

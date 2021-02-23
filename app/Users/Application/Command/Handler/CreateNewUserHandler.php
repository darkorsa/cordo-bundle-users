<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Command\Handler;

use League\Event\EmitterInterface;
use App\Context\Users\Domain\User;
use App\Context\Users\Domain\UserId;
use App\Context\Users\Domain\UserEmail;
use App\Context\Users\Domain\UserActive;
use App\Context\Users\Domain\UserPassword;
use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Domain\UserPasswordHash;
use App\Context\Users\Application\Command\CreateNewUser;

class CreateNewUserHandler
{
    private $users;

    private $emitter;

    public function __construct(UserRepository $users, EmitterInterface $emitter)
    {
        $this->users = $users;
        $this->emitter = $emitter;
    }

    public function __invoke(CreateNewUser $command): void
    {
        $user = new User(
            UserId::random(),
            new UserEmail($command->email()),
            new UserPasswordHash((new UserPassword($command->password()))->value()),
            new UserActive(true),
            $command->createdAt(),
            $command->createdAt()
        );

        $this->users->add($user);
        $user->created();

        $this->emitter->emitBatch($user->pullDomainEvents());
    }
}

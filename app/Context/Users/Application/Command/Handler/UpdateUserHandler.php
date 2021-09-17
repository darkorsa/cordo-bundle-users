<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Command\Handler;

use League\Event\EmitterInterface;
use App\Context\Users\Domain\User;
use App\Context\Users\Domain\UserEmail;
use App\Context\Users\Domain\UserActive;
use App\Context\Users\Domain\UserPasswordHash;
use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Application\Command\UpdateUser;
use App\Context\Users\Domain\UserId;

class UpdateUserHandler
{
    private $users;

    private $emitter;

    public function __construct(UserRepository $users, EmitterInterface $emitter)
    {
        $this->users = $users;
        $this->emitter = $emitter;
    }

    public function __invoke(UpdateUser $command): void
    {
        $user = $this->users->find($command->id());

        $user = new User(
            new UserId($command->id()),
            new UserEmail($command->email()),
            new UserPasswordHash($user->password()),
            new UserActive($command->isActive()),
            $user->createdAt(),
            $command->updatedAt()
        );

        $this->users->update($user);
    }
}

<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Event\Register;

use App\Context\Users\Domain\Event\UserCreated;
use Cordo\Core\Application\Service\Register\ListenersRegister;
use App\Context\Users\Application\Event\Listener\UserCreatedListener;

class UsersListeners extends ListenersRegister
{
    public function register(): void
    {
        $this->emitter->addListener(
            "context.users.created",
            function (UserCreated $userCreated) {
                (new UserCreatedListener($this->container))->handle($userCreated);
            }
        );
    }
}

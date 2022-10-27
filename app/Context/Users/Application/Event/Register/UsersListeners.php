<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Event\Register;

use Cordo\Core\Application\App;
use App\Context\Users\Domain\Event\UserCreated;
use Cordo\Core\Application\Service\Register\ListenersRegister;
use App\Context\Users\Application\Command\SendUserWelcomeMessage;

class UsersListeners extends ListenersRegister
{
    public function register(): void
    {
        $this->emitter->addListener(
            "context.users.created",
            function (UserCreated $userCreated) {
                $this->commandBus->handle(new SendUserWelcomeMessage($userCreated->email, App::locale()));
            }
        );
    }
}

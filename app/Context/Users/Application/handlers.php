<?php

use App\Context\Users\Application\Command\DeleteUser;
use App\Context\Users\Application\Command\UpdateUser;
use App\Context\Users\Application\Command\CreateNewUser;
use App\Context\Users\Application\Command\SendUserWelcomeMessage;
use App\Context\Users\Application\Command\Handler\DeleteUserHandler;
use App\Context\Users\Application\Command\Handler\UpdateUserHandler;
use App\Context\Users\Application\Command\Handler\CreateNewUserHandler;
use App\Context\Users\Application\Command\Handler\SendUserWelcomeMessageHandler;

return [
    CreateNewUser::class            => CreateNewUserHandler::class,
    UpdateUser::class               => UpdateUserHandler::class,
    DeleteUser::class               => DeleteUserHandler::class,
    SendUserWelcomeMessage::class   => SendUserWelcomeMessageHandler::class,
];

<?php

namespace App\Context\Users\UI\Http\Controller;

use Ramsey\Uuid\Uuid;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Cordo\Core\UI\Http\Controller\BaseController;
use App\Context\Users\UI\Validator\NewUserValidator;
use App\Context\Users\Application\Command\DeleteUser;
use App\Context\Users\Application\Command\UpdateUser;
use App\Context\Users\UI\Validator\UpdateUserValidator;
use App\Context\Users\Application\Command\CreateNewUser;

class UserCommandsController extends BaseController
{
    public function createAction(ServerRequestInterface $request): ResponseInterface
    {
        $params = (array) $request->getParsedBody();
        $service = $this->container->get('context.users.query.service');

        $validator = new NewUserValidator($service, $params);
        if ($validator->fails()) {
            return $this->respondBadRequestError($validator->messages()->toArray());
        }

        $params = (object) $params;

        $command = new CreateNewUser(
            (string) $params->email,
            (string) $params->password
        );

        $this->commandBus->handle($command);

        return $this->respondWithSuccess();
    }

    public function updateAction(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $request->getAttribute('user_id');
        $params = (array) $request->getParsedBody();

        $validator = new UpdateUserValidator($params);
        if ($validator->fails()) {
            return $this->respondBadRequestError($validator->messages()->toArray());
        }

        $user = $this->container->get('context.users.query.service')->getOneById($userId);

        $params = (object) $params;

        $command = new UpdateUser(
            $user->id(),
            (string) $params->email,
            (bool) $params->active,
        );

        $this->commandBus->handle($command);

        return $this->respondWithSuccess();
    }

    public function deleteAction(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $request->getAttribute('user_id');

        $user = $this->container->get('context.users.query.service')->getOneById($userId);

        $command = new DeleteUser($user->id());

        $this->commandBus->handle($command);

        return $this->respondWithSuccess();
    }
}

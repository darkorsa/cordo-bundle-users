<?php

declare(strict_types=1);

namespace App\Context\Users\UI\Http\Route;

use Cordo\Core\UI\Http\Middleware\OAuth2Middleware;
use App\Context\Shared\UI\Http\Middleware\AclMiddleware;
use Cordo\Core\Application\Service\Register\RoutesRegister;

class UsersRoutes extends RoutesRegister
{
    public function register(): void
    {
        (new AuthRoutes($this->router, $this->container, $this->resource))->register();

        $this->getUsersRoute();
        $this->getUserRoute();
        $this->createUserRoute();
        $this->updateUserRoute();
        $this->deleteUserRoute();
    }

    private function getUsersRoute(): void
    {
        /**
         * @api {get} /context/users Get users list
         * @apiName GetUsers
         * @apiGroup ContextUsers
         *
         * @apiParam {Number} [offset] Records offset
         * @apiParam {Number} [limit] Records limit
         *
         * @apiSuccessExample Success-Response:
         * HTTP/1.1 200 OK
         * {
         *     "response": {
         *         "data": [
         *             {
         *                 "type": "user",
         *                 "id": "8c8d6582-851a-11e9-92e2-3035ada7b0f2",
         *                 "attributes": {
         *                     "email": "admin@test.pl",
         *                     "modified": {
         *                         "date": "2019-06-02 09:41:08.000000",
         *                         "timezone_type": 3,
         *                         "timezone": "UTC"
         *                     }
         *                 },
         *                 "links": {
         *                     "self": "http://plain.ninja/user/8c8d6582-851a-11e9-92e2-3035ada7b0f2"
         *                 }
         *             }
         *         ],
         *         "total": 1
         *     }
         * }
         */
        $this->router->addRoute(
            'GET',
            "/context/users",
            'App\Context\Users\UI\Http\Controller\UserQueriesController@index'
        );
    }

    private function getUserRoute(): void
    {
        /**
         * @api {get} /context/users/:id Get user
         * @apiName GetUser
         * @apiGroup ContextUsers
         *
         * @apiParam {Number} id User ID
         *
         * @apiErrorExample {json} Error-Response:
         * HTTP/1.1 404 Not Found
         *
         * @apiSuccessExample Success-Response:
         * HTTP/1.1 200 OK
         * {
         *     "response": {
         *         "data": {
         *             "type": "user",
         *             "id": "8c8d6582-851a-11e9-92e2-3035ada7b0f2",
         *             "attributes": {
         *                 "email": "admin@test.pl",
         *                 "modified": {
         *                     "date": "2019-06-02 09:41:08.000000",
         *                     "timezone_type": 3,
         *                     "timezone": "UTC"
         *                 }
         *             },
         *             "links": {
         *                 "self": "http://plain.ninja/user/8c8d6582-851a-11e9-92e2-3035ada7b0f2"
         *             }
         *         }
         *     }
         * }
         */
        $this->router->addRoute(
            'GET',
            "/context/users/" . static::UUID_PATTERN,
            'App\Context\Users\UI\Http\Controller\UserQueriesController@get'
        );
    }

    private function createUserRoute(): void
    {
        /**
         * @api {post} /context/users Create new user
         * @apiName CreateUser
         * @apiGroup ContextUsers
         *
         * @apiParam {String{..50}} email E-mail address
         * @apiParam {String{6..18}} password User password
         *
         * @apiErrorExample {json} Error-Response:
         * HTTP/1.1 400 Bad Request
         * {
         *     "response": {
         *         "password": {
         *             "LengthBetween::TOO_SHORT": "password must be 6 characters or longer"
         *         },
         *         "email": {
         *             "Email::INVALID_VALUE": "email must be a valid email address"
         *         }
         *     }
         * }
         *
         * @apiSuccessExample Success-Response:
         * HTTP/1.1 200 OK
         * {
         *   "response": "OK"
         * }
         */
        $this->router->addRoute(
            'POST',
            "/context/users",
            'App\Context\Users\UI\Http\Controller\UserCommandsController@create'
        );
    }

    private function updateUserRoute()
    {
        /**
         * @api {put} /context/users Update user
         * @apiName UpdateUser
         * @apiGroup ContextUsers
         *
         * @apiParam {String{..50}} email E-mail address
         * @apiParam {String} access_token Auth token
         *
         * @apiErrorExample {json} Error-Response:
         * HTTP/1.1 401 Unauthorized
         *
         * @apiErrorExample {json} Error-Response:
         * HTTP/1.1 400 Bad Request
         * {
         *     "response": {
         *         "email": {
         *             "Email::INVALID_VALUE": "email must be a valid email address"
         *         }
         *     }
         * }
         *
         * @apiSuccessExample Success-Response:
         * HTTP/1.1 200 OK
         * {
         *   "response": "OK"
         * }
         */
        $this->router->addRoute(
            'PUT',
            "/context/users",
            'App\Context\Users\UI\Http\Controller\UserCommandsController@update',
            [
                new OAuth2Middleware($this->container, $this->resource),
            ]
        );
    }

    private function deleteUserRoute(): void
    {
        /**
         * @api {delete} /context/users/:id Delete user
         * @apiName DeleteUser
         * @apiGroup ContextUsers
         *
         * @apiParam {Number} id User ID
         * @apiParam {String} access_token Auth token
         *
         * @apiErrorExample {json} Error-Response:
         * HTTP/1.1 401 Unauthorized
         *
         * @apiSuccessExample Success-Response:
         * HTTP/1.1 200 OK
         * {
         *   "response": "OK"
         * }
         */
        $this->router->addRoute(
            'DELETE',
            "/context/users",
            'App\Context\Users\UI\Http\Controller\UserCommandsController@delete',
            [
                new OAuth2Middleware($this->container, $this->resource),
            ]
        );
    }
}

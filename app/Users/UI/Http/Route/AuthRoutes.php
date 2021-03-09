<?php

declare(strict_types=1);

namespace App\Context\Users\UI\Http\Route;

use OAuth2\Request;
use Cordo\Core\Application\Service\Register\RoutesRegister;

class AuthRoutes extends RoutesRegister
{
    public function register(): void
    {
        /**
         * @api {post} /context/users/token Generate auth token
         * @apiName ContextUsersToken
         * @apiGroup ContextUsers
         *
         * @apiParam {String} [username] Username
         * @apiParam {String} [password] Password
         * @apiParam {String} [grant_type] Grant type (default value 'password')
         * @apiParam {String} [client_id] Client ID - default value is 'Cordo', can be changed in oauth_clients db table
         *
         * @apiSuccessExample Success-Response:
         * HTTP/1.1 200 OK
         * {
         *   "access_token": "f5dee6f234b6ac0333958643f6728736f812513a",
         *   "expires_in": 3600,
         *   "token_type": "Bearer",
         *   "scope": null,
         *   "refresh_token": "6edc70d399c9594c693429554ae9067d49735419",
         *   "login": "user@email.com"
         * }
         */
        $this->router->addRoute(
            'POST',
            '/context/users/token',
            function () {
                $request = Request::createFromGlobals();

                $response = $this->container->get('context\users_oauth_server')->handleTokenRequest($request);

                if ($response->getStatusText() === 'OK') {
                    $response->setParameter('login', $request->request('username'));
                }

                $response->send();
                die;
            }
        );

        /**
         * @api {post} /context/users/token-refresh Refresh auth token
         * @apiName ContextUsersRefreshToken
         * @apiGroup ContextUsers
         *
         * @apiParam {String} [access_token] Access token
         * @apiParam {String} [refresh_token] Refresh token
         *
         * @apiSuccessExample Success-Response:
         * HTTP/1.1 200 OK
         * {
         *   "access_token": "f5dee6f234b6ac0333958643f6728736f812513a",
         *   "expires_in": 3600,
         *   "token_type": "Bearer",
         *   "scope": null,
         *   "refresh_token": "6edc70d399c9594c693429554ae9067d49735419",
         *   "login": "user@email.com"
         * }
         */
        $this->router->addRoute(
            'POST',
            '/context/users/token-refresh',
            function () {
                $response = $this->container
                    ->get('context\users_oauth_server')
                    ->handleTokenRequest(Request::createFromGlobals());
                $response->send();
                die;
            }
        );
    }
}

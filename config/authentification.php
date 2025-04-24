<?php

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

return [
    'Authentication' => function (ServerRequestInterface $request) {
        $service = new AuthenticationService();

        // Load identifiers
        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'username',
                'password' => 'password',
            ],
        ]);

        // Load authenticators
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'username',
                'password' => 'password',
            ],
            'loginUrl' => '/users/login',
        ]);

        return $service;
    },
];
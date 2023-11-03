<?php

declare(strict_types=1);


namespace App\Tests\CommonFunctions;

use ApiPlatform\Symfony\Bundle\Test\Client;

class ApiTestService
{
    public static function getToken(Client $client, string $email, string $password): string
    {
        $response = $client
            ->request(
                'POST',
                '/authentication_token',
                [
                    'json' => [
                        'email' => $email,
                        'password' => $password,
                    ]
                ]
        );

        return $response->toArray()['token'];
    }
}
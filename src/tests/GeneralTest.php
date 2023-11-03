<?php

declare(strict_types=1);


namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class GeneralTest extends ApiTestCase
{
    public function testApi(): void
    {
        $response = static::createClient()
            ->request(
                'GET',
                '/api'
            );
        $this->assertResponseIsSuccessful();
    }

    public function testVerifyingToken(): void
    {
        $response = static::createClient()
            ->request(
                'POST',
                '/authentication_token',
                [
                    'json' => [
                        'email' => 'mateusz2003w@gmail.com',
                        'password' => 'Qwerty123',
                    ]
                ]
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }
}
<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UserApiTest extends ApiTestCase
{
    public function testUserGetCollection(): void
    {
        $response = static::createClient()
            ->request(
                'GET',
                '/api/users',
            );
    }
}

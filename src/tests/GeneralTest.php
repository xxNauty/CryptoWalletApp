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
}
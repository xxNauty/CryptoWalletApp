<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Infrastructure\User\ApiPlatform\Resource\UserResource;
use App\Tests\CommonFunctions\ApiTestService;

class UserApiTest extends ApiTestCase
{
    public function testUserGetCollection(): void
    {
        $token = ApiTestService::getToken(static::createClient(), 'mateusz2003w@gmail.com', 'Qwerty123');
        $response = static::createClient()
            ->request(
                'GET',
                '/api/users',
                [
                    'auth_bearer' => $token
                ]
            );
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(UserResource::class);
    }

    public function testUserGet(): void
    {
        $token = ApiTestService::getToken(static::createClient(), 'mateusz2003w@gmail.com', 'Qwerty123');
        $response = static::createClient()
            ->request(
                'GET',
                '/api/users/1',
                [
                    'auth_bearer' => $token
                ]
            );
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(UserResource::class);
    }

    public function testUserPost(): void
    {
        $response = static::createClient()
            ->request(
                'POST',
                '/api/users',
                [
                    'json' => [
                        'email' => 'user'.(new \DateTimeImmutable('now'))->format('YmdHis').'@test.com',
                        'firstName' => 'name',
                        'lastName' => 'lastName',
                        'password' => 'qwertyuiop'
                    ]
                ]
            );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/User',
            '@type' => 'User',
            'firstName' => 'name',
            'lastName' => 'lastName',
        ]);
        $this->assertMatchesRegularExpression('~^/api/users/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(UserResource::class);
    }
}

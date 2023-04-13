<?php

namespace App\Tests;

use PHPUnit\Framework\Attributes\Depends;


class ComposerTest extends AbstractApiTest
{
    private static $testComposer = [
        'firstName' => 'Wolfgang',
        'lastName' => 'Mozart',
        'country' => 'Switzerland',
        'dateOfBbirth' => '1756-01-27',
    ];

    public function testCreate(): void
    {
        $response = $this->post('/composer', static::$testComposer);
        $this->assertSame(201, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
        $this->assertNotEmpty($json['id']);
        static::$testComposer['id'] = $json['id'];
    }

    #[Depends('testCreate')]
    public function testIndex(): void
    {
        $response = $this->get('/composer');
        $this->assertSame(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
        $this->assertTrue(in_array(static::$testComposer, $json));
    }

    #[Depends('testCreate')]
    public function testShow(): void
    {
        $response = $this->get('/composer/' . static::$testComposer['id']);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
    }

    #[Depends('testCreate')]
    public function testUpdate(): void
    {
        static::$testComposer['firstName'] = 'Wolfgang Amadeus';
        $response = $this->put('/composer/' . static::$testComposer['id'], static::$testComposer);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
        $this->assertEquals(static::$testComposer, $json);
    }

    #[Depends('testCreate')]
    public function testDelete(): void
    {
        $response = $this->delete('/composer/' . static::$testComposer['id']);
        $this->assertSame(204, $response->getStatusCode());
    }
}

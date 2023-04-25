<?php

namespace App\Tests;

class SymphonyTest extends AbstractApiTest
{
    private static $testSymphony = [
        'name' => 'No 1',
        'description' => null,
        'finishedAt' => null,
    ];

    /**
     * @depends testCreate
     */
    public function testIndex(): void
    {
        $response = $this->get('/symphony');
        $this->assertSame(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
        $this->assertTrue(in_array(static::$testSymphony, $json));
    }

    public function testCreate(): void
    {
        $composer = [
            'firstName' => 'Foo',
            'lastName' => 'Bar',
            'dateOfBbirth' => date('Y-m-d'),
            'country' => 'DE',
        ];
        $response = $this->post('/composer', $composer);
        $this->assertSame(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $composerJson = json_decode($response->getContent(), true);

        static::$testSymphony['composerId'] = $composerJson['id'];
        $response = $this->post('/symphony', static::$testSymphony);
        $this->assertSame(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $json = json_decode($response->getContent(), true);
        $this->assertNotEmpty($json['id']);
        $this->assertNotEmpty($json['createdAt']);
        static::$testSymphony['id'] = $json['id'];
        static::$testSymphony['createdAt'] = $json['createdAt'];
    }

    /**
     * @depends testCreate
     */
    public function testShow(): void
    {
        $response = $this->get('/symphony/' . static::$testSymphony['id']);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
        $this->assertEquals(static::$testSymphony, $json);
    }

    /**
     * @depends testCreate
     */
    public function testUpdate(): void
    {
        static::$testSymphony['description'] = 'Foo bar long text description';
        $response = $this->put('/symphony/' . static::$testSymphony['id'], static::$testSymphony);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent(), true);
        $this->assertEquals(static::$testSymphony, $json);
    }

    /**
     * @depends testCreate
     */
    public function testDelete(): void
    {
        $response = $this->delete('/symphony/' . static::$testSymphony['id']);
        $this->assertSame(204, $response->getStatusCode());
    }
}

//
//namespace App\Tests;
//
//class SymphonyTest extends AbstractApiTest
//{
//
//    private static array $testSymphony = [
//        'name' => 'No1',
//        'description' => null,
//        'finishedAt' =>null,
//    ];
//
//    /**
//     * @depends testCreate
//     */
//    public function testIndex(): void
//    {
//        $response = $this->get('/symphony');
//        $this->assertSame(200, $response->getStatusCode());
//        $this->assertJson($response->getContent());
//
//        $json = json_decode($response->getContent(), true);
//        $this->assertTrue(in_array(static::$testSymphony, $json));
//    }
//
//    public function testCreate(): void
//    {
//        $composer = [
//            'firstName' => 'Foo',
//            'lastName' => 'Bar',
//            'country' => 'Switzerland',
//            'dateOfBbirth' => '1756-01-27',
//        ];
//
//        $response = $this->post('/composer', $composer);
//        $this->assertSame(201, $response->getStatusCode());
//        $this->assertJson($response->getContent());
//        $composerJson = json_decode($response->getContent(), true);
//        print_r($composerJson);
//
//        static::$testSymphony['composer'] = $composerJson['id'];
//        print_r(static::$testSymphony);
//        $response = $this->post('/symphony', static::$testSymphony);
//        $this->assertSame(201, $response->getStatusCode());
//        $this->assertJson($response->getContent());
//        $json = json_decode($response->getContent(), true);
//        $this->assertNotEmpty($json['id']);
//        $this->assertNotEmpty($json['createdAt']);
//        static::$testSymphony['id'] = $json['id'];
//        static::$testSymphony['createdAt'] = $json['createdAt'];
//    }
//
//    /**
//     * @depends testCreate
//     */
//    public function testShow(): void
//    {
//        $response = $this->get('/symphony/' . static::$testSymphony['id']);
//        $this->assertSame(200, $response->getStatusCode());
//        $this->assertJson($response->getContent());
//
//        $json = json_decode($response->getContent(), true);
//        $this->assertEquals(static::$testSymphony, $json);
//    }
//
//    /**
//     * @depends testCreate
//     */
//    public function testUpdate(): void
//    {
//        static::$testSymphony['description'] = 'foo new description';
//        $response = $this->put('/symphony/' . static::$testSymphony['id'], static::$testSymphony);
//        $this->assertSame(200, $response->getStatusCode());
//        $this->assertJson($response->getContent());
//
//        $json = json_decode($response->getContent(), true);
//        $this->assertEquals(static::$testSymphony, $json);
//    }
//
//    /**
//     * @depends testCreate
//     */
//    public function testDelete(): void
//    {
//        $response = $this->delete('/symphony/' . static::$testSymphony['id']);
//        $this->assertSame(204, $response->getStatusCode());
//    }
//}

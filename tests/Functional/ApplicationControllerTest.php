<?php
declare(strict_types=1);

namespace Tests\Functional;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ApplicationControllerTest extends TestCase
{
    /**
     * @var Client $http
     */
    private $http;

    public function setUp()
    {
        $this->http = new Client(['base_uri' => 'nginx']);
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testIfWeGetList()
    {
        $response = $this->http->request('GET', 'nginx/users');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals([
            [
             'id' => 1,
            'firstName' => 'Aman',
            'secondName' => 'Ramkumar'
            ],
            [
             'id' => 2,
            'firstName' => 'Leni',
            'secondName' => 'Martin'
            ],
             [
             'id' => 3,
            'firstName' => 'Louis',
            'secondName' => 'Dalbe'
            ],

        ], \json_decode($response->getBody()->getContents(), true));

        $this->assertEquals('application/json', $response->getHeaders()["Content-Type"][0]);

    }

    public function testIfWeCanGetOneUser()
    {
        $response = $this->http->request('GET', 'nginx/users/show/1');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            [
                'id' => 1,
                'firstName' => 'Aman',
                'secondName' => 'Ramkumar'
            ]
        , \json_decode($response->getBody()->getContents(), true));

        $this->assertEquals('application/json', $response->getHeaders()["Content-Type"][0]);
    }

      public function testIfWeCannotGetUser()
    {
        $response = $this->http->request('GET', 'nginx/users/show/13232323');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals([], \json_decode($response->getBody()->getContents(), true));

        $this->assertEquals('application/json', $response->getHeaders()["Content-Type"][0]);
    }
}

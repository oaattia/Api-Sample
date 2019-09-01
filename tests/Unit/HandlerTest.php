<?php
declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Refactor\Application\DataSource\Source;
use Refactor\Application\Handler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HandlerTest extends TestCase
{
    public function testIfRunReturnShowController()
    {
        $request = $this->createMock(Request::class);
        $request->method('getPathInfo')->willReturn('/users/show/2');

        $source = $this->createMock(Source::class);
        $source->method('getData')->willReturn([
            ['id'=> 1, 'firstName' => 'foo', 'secondName' => 'bar']
        ]);


        $handler = new Handler($request);
        $router = $handler->run($source);

        self::assertEquals('[{"id":1,"firstName":"foo","secondName":"bar"}]', $router->getContent());
        self::assertEquals(200, $router->getStatusCode());
    }

    public function testIfRunReturnIndexController()
    {
        $request = $this->createMock(Request::class);
        $request->method('getPathInfo')->willReturn('/users/');
        $source = $this->createMock(Source::class);
        $source->method('getData')->willReturn(
            ['id'=> 1, 'firstName' => 'foo', 'secondName' => 'bar']
        );

        $handler = new Handler($request);
        /** @var JsonResponse $router */
        $router = $handler->run($source);

        self::assertEquals('{"id":1,"firstName":"foo","secondName":"bar"}', $router->getContent());
        self::assertEquals(200, $router->getStatusCode());
    }


    public function testIfRunReturn404ForMissingController()
    {
        $request = $this->createMock(Request::class);
        $request->method('getPathInfo')->willReturn('/foo/bar');

        $handler = new Handler($request);
        $router = $handler->run($this->createMock(Source::class));


        self::assertEquals('no route found', $router->getContent());
        self::assertEquals(404, $router->getStatusCode());
    }
}

<?php
declare(strict_types=1);

namespace Refactor\Application;

use Refactor\Application\DataSource\Source;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function run(Source $source): Response
    {
        $path = $this->request->getPathInfo();

        $segments = array_filter(explode('/', $path));

        $controller = '\Refactor\Application\Controller\\'.ucfirst($segments[1])
            .'Controller';

        if (class_exists($controller)) {
            $method = isset($segments[2]) ? $segments[2] : 'index';
            if (method_exists($controller, $method)) {
                $repository = '\Refactor\Application\Repository\\'.ucfirst($segments[1]).'Repository';
                $controller = new $controller(new $repository($source));
                $parameters = isset($segments[3]) ? (int)$segments[3] : null;

                return $controller->$method($parameters);
            }
        }

        return new Response('no route found', 404);
    }
}
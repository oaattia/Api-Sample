<?php
declare(strict_types=1);

namespace Refactor\Common\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractRestfulController
 *
 * @package Refactor\Common\Controller
 */
abstract class AbstractRestfulController implements RestfulControllerInterface
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
<?php
declare(strict_types=1);

namespace Refactor\Common\Controller;

/**
 * Interface RestfulControllerInterface
 * @package Refactor\Common\Controller
 */
interface RestfulControllerInterface
{
    /**
     * Get a resource
     * @param $id
     * @return array
     */
    public function show(int $id);

    /**
     * Get a list of resources
     * @return mixed
     */
    public function index();

}
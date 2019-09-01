<?php
declare(strict_types=1);

namespace Refactor\Application\Controller;

use http\Env\Response;
use Refactor\Application\Repository\Repository;
use Refactor\Common\Controller\AbstractRestfulController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends AbstractRestfulController
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Route = '/users'
     *
     * Get a list of resources
     *
     * @return JsonResponse
     */
    public function index()
    {
        $items = $this->repository->all();

        return new JsonResponse($items);
    }

    /**
     * Route = 'users/show/{id}'
     *
     * Get a resource
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $user = $this->repository->get($id);

        return new JsonResponse($user);
    }
}
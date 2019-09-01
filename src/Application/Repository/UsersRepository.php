<?php
declare(strict_types=1);

namespace Refactor\Application\Repository;

use Refactor\Application\DataSource\Source;
use Refactor\Application\DTO\User;

class UsersRepository implements Repository
{
    /**
     * @var Source
     */
    private $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function get(int $id): array
    {
        return $this->source->getData($id);
    }

    public function all(): array
    {
        return $this->source->getData();
    }
}
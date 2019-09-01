<?php
declare(strict_types=1);

namespace Refactor\Application\Repository;

interface Repository
{
    public function get(int $id): array;

    public function all(): array;
}
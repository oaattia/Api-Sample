<?php
declare(strict_types=1);

namespace Refactor\Application\DataSource;

interface Source
{
    public function getData(int $id = null): array;
}
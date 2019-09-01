<?php
declare(strict_types=1);

namespace Refactor\Application\DataSource;

class Csv implements Source
{
    private $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }

    public function getData(int $id = null): array
    {
        $items = [];

        $rows = $this->getCsvFile();

        foreach ($rows as $row) {
            if ($row['id'] == $id) {
                return $row;
            }

            if(!$id) {
                $items[] = $row;
            } else {
                return [];
            }

        }

        return $items;
    }

    /**
     * @return \Generator
     */
    private function getCsvFile(): \Generator
    {
        if (($handle = fopen($this->source, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                yield [
                    'id'         => $data[0],
                    'firstName'  => $data[1],
                    'secondName' => $data[2],
                ];
            }
        }
    }
}
<?php

namespace Anso\Framework\Http\Resource;

use JsonSerializable;

class ResultResource implements JsonSerializable
{
    private array $results;

    public function __construct(array $results)
    {
        $this->results = $this->convert($results);
    }

    private function convert(array $results): array
    {
        $converted = [];

        foreach ($results as $key => $result) {
            $converted[$key]['name'] = $result->getName();
            $converted[$key]['input'] = $result->getInput();
            $converted[$key]['result'] = $result->getResult();
            $converted[$key]['created_at'] = $result->getCreatedAt();
        }

        return $converted;
    }

    public function jsonSerialize()
    {
        return $this->results;
    }

}
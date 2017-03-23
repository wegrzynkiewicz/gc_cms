<?php

declare(strict_types=1);

namespace GC;

class Breadcrumbs
{
    protected $links = array();

    public function getLinks(): array
    {
        return $this->links;
    }

    public function push(array $data): void
    {
        array_push($this->links, $data);
    }

    public function unshift(array $data): void
    {
        array_unshift($this->links, $data);
    }

    public function getBeforeLast(string $index): string
    {
        return getValueByKeys(
            $this->links,
            [count($this->links)-2, $index],
            '/'
        );
    }

    public function getLast(string $index): string
    {
        return getValueByKeys(
            $this->links,
            [count($this->links)-1, $index],
            '/'
        );
    }
}

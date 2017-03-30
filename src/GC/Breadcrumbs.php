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

    public function getBeforeLast(): string
    {
        return $this->links[count($this->links)-2] ?? null;
    }

    public function getLast(): string
    {
        return $this->links[count($this->links)-1] ?? null;
    }

    public function reverse(): void
    {
        $this->links = array_reverse($this->links, true);
    }
}

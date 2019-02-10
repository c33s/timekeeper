<?php

namespace Phpactor\Extension\Timekeeper\Domain;

class Entry
{
    /**
     * @var string
     */
    private $time;
    /**
     * @var string|null
     */
    private $comment;
    /**
     * @var string|null
     */
    private $category;
    /**
     * @var array
     */
    private $tags;

    public function __construct(string $time, ?string $comment, ?string $category, array $tags)
    {
        $this->time = $time;
        $this->comment = $comment;
        $this->category = $category;
        $this->tags = $tags;
    }

    public function time(): string
    {
        return $this->time;
    }

    public function comment(): ?string
    {
        return $this->comment;
    }

    public function category(): ?string
    {
        return $this->category;
    }

    public function tags(): array
    {
        return $this->tags;
    }
}

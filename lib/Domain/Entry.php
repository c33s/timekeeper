<?php

namespace Phpactor\Extension\Timekeeper\Domain;

class Entry
{
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

    /**
     * @var int
     */
    private $hour;

    /**
     * @var int
     */
    private $minutes;

    public function __construct(int $hours, int $minutes, ?string $comment, ?string $category, array $tags)
    {
        $this->comment = $comment;
        $this->category = $category;
        $this->tags = $tags;
        $this->hour = $hours;
        $this->minutes = $minutes;
    }

    public function time(): string
    {
        return sprintf('%02d:%02d', $this->hour, $this->minutes);
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

    public function hour(): int
    {
        return $this->hour;
    }

    public function minutes(): int
    {
        return $this->minutes;
    }
}

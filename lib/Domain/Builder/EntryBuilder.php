<?php

namespace Phpactor\Extension\Timekeeper\Domain\Builder;

use Phpactor\Extension\Timekeeper\Domain\Entry;

class EntryBuilder
{
    /**
     * @var string
     */
    private $time;
    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $category;

    /**
     * @var array
     */
    private $tags = [];

    /**
     * @var int
     */
    private $hour;

    /**
     * @var int
     */
    private $minutes;

    public function build(): Entry
    {
        return new Entry($this->hour, $this->minutes, $this->comment, $this->category, $this->tags);
    }

    public function time(int $hour, int $minutes): self
    {
        $this->hour = $hour;
        $this->minutes = $minutes;
        return $this;
    }

    public function comment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function category(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function addTag(string $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    public static function fromTime(string $string): self
    {
        [ $hour, $minutes] = explode(':', $string);
        $new = new self();
        $new->hour = $hour;
        $new->minutes = $minutes;
        return $new;
    }
}

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

    public function build(): Entry
    {
        return new Entry($this->time, $this->comment, $this->category, $this->tags);
    }

    public function time(string $time): self
    {
        $this->time = $time;

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
        $new = new self();
        $new->time = $string;
        return $new;
    }
}

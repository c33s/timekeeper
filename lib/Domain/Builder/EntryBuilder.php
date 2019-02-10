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
    private $tags;

    public function build(): Entry
    {
        return new Entry();
    }

    public function time(string $time)
    {
        $this->time = $time;
    }

    public function comment(string $comment)
    {
        $this->comment = $comment;
    }

    public function category(string $category)
    {
        $this->category = $category;
    }

    public function addTag(string $tag)
    {
        $this->tags[] = $tag;
    }
}

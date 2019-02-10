<?php

namespace Phpactor\Extension\Timekeeper\Domain;

class Entry
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

    public function __construct(string $time, ?string $comment, ?string $category, array $tags)
    {
        $this->time = $time;
        $this->comment = $comment;
        $this->category = $category;
        $this->tags = $tags;
    }
}

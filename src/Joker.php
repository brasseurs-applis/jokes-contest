<?php

namespace BrasseursApplis\JokesContest;

class Joker
{
    /** @var string */
    private $name;

    /**
     * Joker constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param Joker $joker
     *
     * @return bool
     */
    public function is(Joker $joker): bool
    {
        return $this->name === $joker->name;
    }
}

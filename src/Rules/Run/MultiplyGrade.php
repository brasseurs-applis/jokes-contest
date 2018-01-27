<?php

namespace BrasseursApplis\JokesContest\Rules\Run;

use BrasseursApplis\JokesContest\Grade;
use BrasseursApplis\JokesContest\JokeCollection;

class MultiplyGrade extends ComposableRunRule
{
    /** @var float */
    private $multiplier;

    /**
     * MultiplyGrade constructor.
     *
     * @param float $multiplier
     */
    public function __construct(float $multiplier)
    {
        $this->multiplier = $multiplier;
    }

    /**
     * @param JokeCollection $jokeCollection
     *
     * @return JokeCollection
     */
    public function onJokes(JokeCollection $jokeCollection): JokeCollection
    {
        return $jokeCollection;
    }

    /**
     * @param Grade $grade
     *
     * @return Grade
     */
    public function onGrade(Grade $grade): Grade
    {
        return $grade->multiply($this->multiplier);
    }
}

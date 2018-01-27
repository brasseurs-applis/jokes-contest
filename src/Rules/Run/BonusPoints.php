<?php

namespace BrasseursApplis\JokesContest\Rules\Run;

use BrasseursApplis\JokesContest\Grade;
use BrasseursApplis\JokesContest\JokeCollection;

class BonusPoints extends ComposableRunRule
{
    /** @var int */
    private $bonusPoints;

    /**
     * BonusPoints constructor.
     *
     * @param int $bonusPoints
     */
    public function __construct(int $bonusPoints)
    {
        $this->bonusPoints = $bonusPoints;
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
        return $grade->addPoint($this->bonusPoints);
    }
}

<?php

namespace BrasseursApplis\JokesContest\Rules\Run;

use BrasseursApplis\JokesContest\Grade;
use BrasseursApplis\JokesContest\JokeCollection;

class StandardDeviation extends ComposableRunRule
{
    /**
     * @param JokeCollection $jokeCollection
     *
     * @return JokeCollection
     */
    public function onJokes(JokeCollection $jokeCollection): JokeCollection
    {
        return $jokeCollection->sortByGrade()
                              ->removeFirst()
                              ->removeLast();
    }

    /**
     * @param Grade $grade
     *
     * @return Grade
     */
    public function onGrade(Grade $grade): Grade
    {
        return $grade;
    }
}

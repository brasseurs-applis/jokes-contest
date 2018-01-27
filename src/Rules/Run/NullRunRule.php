<?php

namespace BrasseursApplis\JokesContest\Rules\Run;

use BrasseursApplis\JokesContest\Grade;
use BrasseursApplis\JokesContest\JokeCollection;
use BrasseursApplis\JokesContest\Rules\RunRule;

class NullRunRule implements RunRule
{
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
        return $grade;
    }

    /**
     * @param RunRule $rule
     *
     * @return RunRule
     */
    public function combine(RunRule $rule): RunRule
    {
       return $rule;
    }
}

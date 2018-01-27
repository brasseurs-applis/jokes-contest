<?php

namespace BrasseursApplis\JokesContest\Rules;

use BrasseursApplis\JokesContest\Grade;
use BrasseursApplis\JokesContest\JokeCollection;

interface RunRule
{
    /**
     * @param JokeCollection $jokeCollection
     *
     * @return JokeCollection
     */
    public function onJokes(JokeCollection $jokeCollection): JokeCollection;

    /**
     * @param Grade $grade
     *
     * @return Grade
     */
    public function onGrade(Grade $grade): Grade;

    /**
     * @param RunRule $rule
     *
     * @return RunRule
     */
    public function combine(RunRule $rule): RunRule;
}

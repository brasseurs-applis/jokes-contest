<?php

namespace BrasseursApplis\JokesContest\Rules\Run;

use BrasseursApplis\JokesContest\Grade;
use BrasseursApplis\JokesContest\JokeCollection;
use BrasseursApplis\JokesContest\Rules\RunRule;

class CompositeRunRule implements RunRule
{
    /** @var RunRule[] */
    private $rules;

    /**
     * CompositeRunRule constructor.
     *
     * @param RunRule[] $rules
     */
    private function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * @param JokeCollection $jokeCollection
     *
     * @return JokeCollection
     */
    public function onJokes(JokeCollection $jokeCollection): JokeCollection
    {
        return array_reduce(
            $this->rules,
            function (JokeCollection $jokeCollection, RunRule $rule) {
                return $rule->onJokes($jokeCollection);
            },
            $jokeCollection
        );
    }

    /**
     * @param Grade $grade
     *
     * @return Grade
     */
    public function onGrade(Grade $grade): Grade
    {
        return array_reduce(
            $this->rules,
            function (Grade $grade, RunRule $rule) {
                return $rule->onGrade($grade);
            },
            $grade
        );
    }

    /**
     * @param RunRule $rule
     *
     * @return RunRule
     */
    public function combine(RunRule $rule): RunRule
    {
        return new self(
            array_merge(
                $this->rules,
                $rule instanceof CompositeRunRule ? $rule->rules : [ $rule ]
            )
        );
    }

    /**
     * @return RunRule
     */
    public static function create(): RunRule
    {
        return new self();
    }
}

<?php

namespace BrasseursApplis\JokesContest;

use BrasseursApplis\JokesContest\Rules\Run\NullRunRule;
use BrasseursApplis\JokesContest\Rules\RunRule;

class Run
{
    /** @var JokeCollection */
    private $jokes;

    /** @var RunRule */
    private $rule;

    /**
     * Run constructor.
     *
     * @param JokeCollection $jokes
     * @param RunRule        $rule
     */
    public function __construct(
        JokeCollection $jokes,
        RunRule $rule
    ) {
        $this->jokes = $jokes;
        $this->rule = $rule;
    }

    /**
     * @param Joke[] $jokes
     *
     * @return Run
     */
    public static function fromArray(array $jokes): Run
    {
        return new self(
            new JokeCollection($jokes),
            new NullRunRule()
        );
    }

    /**
     * @param RunRule $rule
     *
     * @return Run
     */
    public function addRule(RunRule $rule): Run
    {
        return new self(
            $this->jokes,
            $this->rule->combine($rule)
        );
    }

    /**
     * @param Joke $joke
     *
     * @return Run
     */
    public function add(Joke $joke): Run
    {
        return new self($this->jokes->add($joke), $this->rule);
    }

    /**
     * @return int
     */
    public function countJokes(): int
    {
        return $this->jokes->count();
    }

    /**
     * @return Joker[]
     */
    public function participants(): array
    {
        return $this->jokes->jokers();
    }

    /**
     * @return Grade
     */
    public function globalAverage(): Grade
    {
        return $this->rule->onGrade(
            Grade::average(
                $this->rule->onJokes(
                    $this->jokes
                )->grades()
            )
        );
    }

    /**
     * @param Joker $joker
     *
     * @return Grade
     */
    public function averageFor(Joker $joker): Grade
    {
        return $this
            ->runOf($joker)
            ->globalAverage();

    }

    /**
     * @param Joker $joker
     *
     * @return Run
     */
    private function runOf(Joker $joker): Run
    {
        return new self(
            $this->jokes->filter(
                function (Joke $joke) use ($joker) {
                    return $joke->isFrom($joker);
                }
            ),
            $this->rule
        );
    }
}

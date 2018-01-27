<?php

namespace BrasseursApplis\JokesContest;

use Assert\Assert;

class Run
{
    /** @var Joke[] */
    private $jokes;

    /**
     * Run constructor.
     *
     * @param Joke[] $jokes
     */
    public function __construct(array $jokes = [])
    {
        Assert::that($jokes)
            ->all()
            ->isInstanceOf(Joke::class);

        $this->jokes = array_values($jokes);
    }

    /**
     * @param Joke $joke
     *
     * @return Run
     */
    public function add(Joke $joke): Run
    {
        return new self(
            array_merge($this->jokes, [ $joke ])
        );
    }

    /**
     * @return int
     */
    public function countJokes(): int
    {
        return count($this->jokes);
    }

    /**
     * @return Joker[]
     */
    public function participants(): array
    {
        return array_map(
            function (Joke $joke) {
                return $joke->author();
            },
            $this->jokes
        );
    }

    /**
     * @return Grade
     */
    public function globalAverage(): Grade
    {
        return Grade::average(
            array_map(
                function(Joke $joke) {
                    return $joke->grade();
                },
                $this->jokes
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
        return array_reduce(
            $this->jokes,
            function (Run $run, Joke $joke) use ($joker){
                if ($joke->isFrom($joker)) {
                    return $run->add($joke);
                }

                return $run;
            },
            new self()
        );
    }
}

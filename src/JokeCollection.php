<?php

namespace BrasseursApplis\JokesContest;

use Assert\Assert;

class JokeCollection
{
    /** @var Joke[] */
    private $jokes;

    /**
     * JokeCollection constructor.
     *
     * @param Joke[] $jokes
     */
    public function __construct(array $jokes)
    {
        Assert::that($jokes)
              ->all()
              ->isInstanceOf(Joke::class);

        $this->jokes = array_values($jokes);
    }

    /**
     * @param Joke $joke
     *
     * @return JokeCollection
     */
    public function add(Joke $joke): JokeCollection
    {
        return new self(
            array_merge($this->jokes, [ $joke ])
        );
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->jokes);
    }

    /**
     * @return Joker[]
     */
    public function jokers(): array
    {
        return array_map(
            function (Joke $joke) {
                return $joke->author();
            },
            $this->jokes
        );
    }

    /**
     * @return Grade[]
     */
    public function grades(): array
    {
        return array_map(
            function (Joke $joke) {
                return $joke->grade();
            },
            $this->jokes
        );
    }

    /**
     * @param callable $filter
     *
     * @return JokeCollection
     */
    public function filter(callable $filter): JokeCollection
    {
        return new self(
            array_filter(
                $this->jokes,
                $filter
            )
        );
    }

    /**
     * @return JokeCollection
     */
    public function sortByGrade(): JokeCollection
    {
        $jokes = $this->jokes;

        usort(
            $jokes,
            function (Joke $joke, Joke $otherJoke) {
                return $joke->grade()->compare($otherJoke->grade());
            }
        );

        return new self($jokes);
    }

    /**
     * @return JokeCollection
     */
    public function removeFirst(): JokeCollection
    {
        return new self(
            array_slice(
                $this->jokes,
                1
            )
        );
    }

    /**
     * @return JokeCollection
     */
    public function removeLast(): JokeCollection
    {
        return new self(
            array_slice(
                $this->jokes,
                0,
                $this->count() -1
            )
        );
    }
}

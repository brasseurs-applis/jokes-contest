<?php

namespace BrasseursApplis\JokesContest;

use Assert\Assert;
use BrasseursApplis\JokesContest\Rules\RunRule;

class JokeCollection
{
    /** @var Joker */
    private $joker;

    /** @var Joke[] */
    private $jokes;

    /**
     * JokeCollection constructor.
     *
     * @param Joker  $joker
     * @param Joke[] $jokes
     */
    private function __construct(
        Joker $joker,
        array $jokes
    ) {
        Assert::that($jokes)
              ->all()
              ->isInstanceOf(Joke::class);

        $this->joker = $joker;
        $this->jokes = array_values($jokes);
    }

    /**
     * @param Joker $joker
     *
     * @return JokeCollection
     */
    public static function createNew(Joker $joker): JokeCollection
    {
        return new self($joker, []);
    }

    /**
     * @param Joke $joke
     *
     * @return JokeCollection
     */
    public static function fromJoke(Joke $joke): JokeCollection
    {
        return new self(
            $joke->author(),
            [ $joke ]
        );
    }

    /**
     * @param Joke $joke
     *
     * @return JokeCollection
     */
    public function add(Joke $joke): JokeCollection
    {
        if (! $joke->isFrom($this->joker)) {
            return $this;
        }

        return new self(
            $this->joker,
            array_merge($this->jokes, [ $joke ])
        );
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->jokes);
    }

    /**
     * @param RunRule $rule
     *
     * @return Grade
     */
    public function average(RunRule $rule): Grade
    {
        return $rule->onGrade(
            Grade::average(
                $rule->onJokes(
                    $this
                )->grades()
            )
        );
    }

    /**
     * @return Joker
     */
    public function author(): Joker
    {
        return $this->joker;
    }

    /**
     * @param Joker $joker
     *
     * @return bool
     */
    public function isFrom(Joker $joker): bool
    {
        return $this->joker->is($joker);
    }

    /**
     * @return JokeCollection
     */
    public function sortByGrade(): JokeCollection
    {
        $jokes = $this->filterCancelled()->jokes;

        usort(
            $jokes,
            function (Joke $joke, Joke $otherJoke) {
                return $joke->grade()->compare($otherJoke->grade());
            }
        );

        return new self($this->joker, $jokes);
    }

    /**
     * @return JokeCollection
     */
    public function removeFirst(): JokeCollection
    {
        return new self(
            $this->joker,
            \array_slice(
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
            $this->joker,
            \array_slice(
                $this->jokes,
                0,
                $this->count() -1
            )
        );
    }

    /**
     * @return Grade[]
     */
    private function grades(): array
    {
        return array_map(
            function (Joke $joke) {
                return $joke->grade();
            },
            $this->filterCancelled()->jokes
        );
    }

    /**
     * @return JokeCollection
     */
    private function filterCancelled(): JokeCollection
    {
        return array_reduce(
            $this->jokes,
            function (JokeCollection $jokes, Joke $joke) {
                if ($joke->isGraded()) {
                    return $jokes->add($joke);
                }

                return $jokes;
            },
            self::createNew($this->joker)
        );
    }
}

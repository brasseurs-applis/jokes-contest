<?php

namespace BrasseursApplis\JokesContest;

use Assert\Assert;
use BrasseursApplis\JokesContest\Rules\Run\NullRunRule;
use BrasseursApplis\JokesContest\Rules\RunRule;

class Run
{
    /** @var JokeCollection[] */
    private $jokes;

    /** @var RunRule */
    private $rule;

    /**
     * Run constructor.
     *
     * @param JokeCollection[] $jokes
     * @param RunRule          $rule
     */
    public function __construct(
        array $jokes,
        RunRule $rule
    ) {
        Assert::that($jokes)
            ->all()
            ->isInstanceOf(JokeCollection::class);

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
        Assert::that($jokes)
            ->all()
            ->isInstanceOf(Joke::class);

        return array_reduce(
            $jokes,
            function (Run $run, Joke $joke) {
                return $run->add($joke);
            },
            new self([], new NullRunRule())
        );
    }

    /**
     * @param Joke $joke
     *
     * @return Run
     */
    public function add(Joke $joke): Run
    {
        if (! $this->hasAlreadyMadeJokes($joke->author())) {
            return new self(
                \array_merge($this->jokes, [ JokeCollection::fromJoke($joke) ]),
                $this->rule
            );
        }

        return new self(
            array_map(
                function (JokeCollection $jokes) use ($joke) {
                    if ($jokes->isFrom($joke->author())) {
                        return $jokes->add($joke);
                    }

                    return $jokes;
                },
                $this->jokes
            ),
            $this->rule
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
     * @return int
     */
    public function countJokes(): int
    {
        return array_reduce(
            $this->jokes,
            function (int $sum, JokeCollection $jokes) {
                return $sum + $jokes->count();
            },
            0
        );
    }

    /**
     * @return Joker[]
     */
    public function participants(): array
    {
        return array_map(
            function (JokeCollection $jokes) {
                return $jokes->author();
            },
            $this->jokes
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
            ->jokesOf($joker)
            ->average($this->rule);

    }

    /**
     * @param Joker $author
     *
     * @return bool
     */
    private function hasAlreadyMadeJokes(Joker $author): bool
    {
        return array_reduce(
            $this->jokes,
            function (bool $found, JokeCollection $jokes) use ($author) {
                return $found || $jokes->isFrom($author);
            },
            false
        );
    }

    /**
     * @param Joker $joker
     *
     * @return JokeCollection
     */
    private function jokesOf(Joker $joker): JokeCollection
    {
        return array_reduce(
            $this->jokes,
            function (?JokeCollection $jokerJokes, JokeCollection $currentJokes) use ($joker)
            {
                if ($jokerJokes !== null && ! $currentJokes->isFrom($joker)) {
                    return $jokerJokes;
                }

                return $currentJokes;
            }
        ) ?: JokeCollection::createNew($joker);
    }
}

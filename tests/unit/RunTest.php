<?php

namespace BrasseursApplis\JokesContest;

use Assert\InvalidArgumentException;
use BrasseursApplis\JokesContest\Helper\FakerTrait;
use BrasseursApplis\JokesContest\Rules\Run\BonusPoints;
use BrasseursApplis\JokesContest\Rules\Run\MultiplyGrade;
use BrasseursApplis\JokesContest\Rules\Run\StandardDeviation;
use PHPUnit\Framework\TestCase;

class RunTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function it cannot accept elements other than jokes(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Run::fromArray(['test']);
    }

    /**
     * @test
     * @dataProvider joke
     *
     * @param Joke $joke
     */
    public function it is possible to add a joke to the run(Joke $joke): void
    {
        $run = Run::fromArray([]);

        $newRun = $run->add($joke);

        self::assertEquals(1, $newRun->countJokes());
    }

    /**
     * @test
     */
    public function it calculates the average of all grades for a joker(): void
    {
        $joker = new Joker($this->getFaker()->name());
        $otherJoker = new Joker($this->getFaker()->name());
        $jokes = $this->getJokes($joker, $otherJoker);

        $run = Run::fromArray($jokes);

        self::assertEquals(new Grade(4), $run->averageFor($joker));
    }

    /**
     * @test
     */
    public function it calculates the average of all grades for a joker using a standard deviation(): void
    {
        $joker = new Joker($this->getFaker()->name());
        $otherJoker = new Joker($this->getFaker()->name());
        $jokes = $this->getJokes($joker, $otherJoker);

        $run = Run::fromArray($jokes)->addRule(new StandardDeviation());

        self::assertEquals(new Grade(5), $run->averageFor($joker));
    }

    /**
     * @test
     */
    public function it calculates the average of all grades for a joker using a bonus point(): void
    {
        $joker = new Joker($this->getFaker()->name());
        $otherJoker = new Joker($this->getFaker()->name());
        $jokes = $this->getJokes($joker, $otherJoker);

        $run = Run::fromArray($jokes)->addRule(new BonusPoints(3));

        self::assertEquals(new Grade(7), $run->averageFor($joker));
    }

    /**
     * @test
     */
    public function it calculates the average of all grades for a joker using a multiplier(): void
    {
        $joker = new Joker($this->getFaker()->name());
        $otherJoker = new Joker($this->getFaker()->name());
        $jokes = $this->getJokes($joker, $otherJoker);

        $run = Run::fromArray($jokes)->addRule(new MultiplyGrade(1.5));

        self::assertEquals(new Grade(6), $run->averageFor($joker));
    }

    /**
     * @test
     */
    public function it calculates the average of all grades for a joker using standard deviation and a point bonus(): void
    {
        $joker = new Joker($this->getFaker()->name());
        $otherJoker = new Joker($this->getFaker()->name());
        $jokes = $this->getJokes($joker, $otherJoker);

        $run = Run::fromArray($jokes)
                  ->addRule(new StandardDeviation())
                  ->addRule(new BonusPoints(1));

        self::assertEquals(new Grade(6), $run->averageFor($joker));
    }

    /**
     * @test
     */
    public function it calculates the average of all grades for a joker using a multiplier and a bonus point(): void
    {
        $joker = new Joker($this->getFaker()->name());
        $otherJoker = new Joker($this->getFaker()->name());
        $jokes = $this->getJokes($joker, $otherJoker);

        $run = Run::fromArray($jokes)
                  ->addRule(new MultiplyGrade(1.5))
                  ->addRule(new BonusPoints(3));

        self::assertEquals(new Grade(9), $run->averageFor($joker));
    }

    /**
     * @test
     */
    public function it calculates the average of all grades for a joker using a bonus point and  a multiplier(): void
    {
        $joker = new Joker($this->getFaker()->name());
        $otherJoker = new Joker($this->getFaker()->name());
        $jokes = $this->getJokes($joker, $otherJoker);

        $run = Run::fromArray($jokes)
                  ->addRule(new BonusPoints(1))
                  ->addRule(new MultiplyGrade(2));

        self::assertEquals(new Grade(10), $run->averageFor($joker));
    }

    /**
     * @param Joker $joker
     * @param Joker $otherJoker
     *
     * @return Joke[]
     */
    private function getJokes(Joker $joker, Joker $otherJoker): array
    {
        return [
            Joke::createJoke($joker, new Grade(6), ''),
            Joke::createJoke($joker, new Grade(0), ''),
            Joke::createJoke($joker, new Grade(4), ''),
            Joke::createJoke($otherJoker, new Grade(0), ''),
            Joke::createJoke($joker, new Grade(8), ''),
            Joke::createJoke($joker, new Grade(6), '')
        ];
    }

    /**
     * @return Joke[]
     */
    public function joke(): array
    {
        return [
            [ Joke::createJoke(new Joker($this->getFaker()->name()), new Grade($this->getFaker()->numberBetween(0, 10)), '') ]
        ];
    }
}

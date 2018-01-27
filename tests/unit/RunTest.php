<?php

namespace BrasseursApplis\JokesContest;

use Assert\InvalidArgumentException;
use BrasseursApplis\JokesContest\Helper\FakerTrait;
use PHPUnit\Framework\TestCase;

class RunTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function it cannot accept elements other than jokes()
    {
        $this->expectException(InvalidArgumentException::class);

        new Run(['test']);
    }

    /**
     * @test
     * @dataProvider joke
     */
    public function it is possible to add a joke to the run(Joke $joke)
    {
        $run = new Run([]);

        $newRun = $run->add($joke);

        self::assertEquals(1, $newRun->countJokes());
    }

    /**
     * @test
     */
    public function it calculates the average of all grades for a joker()
    {
        $joker = new Joker($this->getFaker()->name());
        $otherJoker = new Joker($this->getFaker()->name());
        $jokes = [
            Joke::createJoke($joker, new Grade(3), ''),
            Joke::createJoke($joker, new Grade(4), ''),
            Joke::createJoke($joker, new Grade(5), ''),
            Joke::createJoke($otherJoker, new Grade(0), ''),
            Joke::createJoke($joker, new Grade(6), ''),
            Joke::createJoke($joker, new Grade(7), '')
        ];

        $run = new Run($jokes);

        self::assertEquals(new Grade(5), $run->averageFor($joker));
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

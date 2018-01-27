<?php

namespace BrasseursApplis\JokesContest;

use BrasseursApplis\JokesContest\Helper\FakerTrait;
use PHPUnit\Framework\TestCase;

class ContestTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function the contest winner is the one with the best average of run grades(): void
    {
        $jokerOne = new Joker($this->getFaker()->name());
        $jokerTwo = new Joker($this->getFaker()->name());

        $contest = new Contest($this->getRuns($jokerOne, $jokerTwo));

        $winner = $contest->getWinner();

        $this->assertTrue($jokerTwo->is($winner));
    }

    /**
     * @test
     */
    public function it is possible to add runs to the contest(): void
    {
        $contest = new Contest();

        $contest = $contest->addRun(new Run());

        self::assertEquals(1, $contest->numberOfRuns());
    }

    /**
     * @param $jokerOne
     * @param $jokerTwo
     *
     * @return array
     */
    private function getRuns($jokerOne, $jokerTwo): array
    {
        $jokeOneJokerOne = Joke::createJoke($jokerOne, new Grade(1), '');
        $jokeTwoJokerOne = Joke::createJoke($jokerOne, new Grade(2), '');
        $jokeThreeJokerOne = Joke::createJoke($jokerOne, new Grade(3), '');
        $jokeFourJokerOne = Joke::createJoke($jokerOne, new Grade(4), '');
        $jokeFiveJokerOne = Joke::createJoke($jokerOne, new Grade(5), '');
        $jokeSixJokerOne = Joke::createJoke($jokerOne, new Grade(6), '');

        $jokeOneJokerTwo = Joke::createJoke($jokerTwo, new Grade(5), '');
        $jokeTwoJokerTwo = Joke::createJoke($jokerTwo, new Grade(6), '');
        $jokeThreeJokerTwo = Joke::createJoke($jokerTwo, new Grade(7), '');
        $jokeFourJokerTwo = Joke::createJoke($jokerTwo, new Grade(8), '');
        $jokeFiveJokerTwo = Joke::createJoke($jokerTwo, new Grade(9), '');
        $jokeSixJokerTwo = Joke::createJoke($jokerTwo, new Grade(10), '');

        $runOne = new Run([
            $jokeOneJokerOne,
            $jokeOneJokerTwo,
            $jokeTwoJokerOne,
            $jokeTwoJokerTwo,
            $jokeThreeJokerOne,
            $jokeThreeJokerTwo
        ]);

        $runTwo = new Run([
            $jokeFourJokerOne,
            $jokeFourJokerTwo,
            $jokeFiveJokerOne,
            $jokeFiveJokerTwo,
            $jokeSixJokerOne,
            $jokeSixJokerTwo
        ]);

        return [$runOne, $runTwo];
    }
}

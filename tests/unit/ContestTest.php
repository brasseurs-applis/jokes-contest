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

        $ranking = $contest->ranking();

        self::assertEquals(15, $ranking->getScoreOf(1)->grade()->toFloat());
    }

    /**
     * @test
     */
    public function it is possible to add runs to the contest(): void
    {
        $contest = new Contest();

        $contest = $contest->addRun(Run::fromArray([]));

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
        $jokeOneJokerOne = Joke::graded($jokerOne, Grade::fromNumber(1), '');
        $jokeTwoJokerOne = Joke::graded($jokerOne, Grade::fromNumber(2), '');
        $jokeThreeJokerOne = Joke::graded($jokerOne, Grade::fromNumber(3), '');
        $jokeFourJokerOne = Joke::graded($jokerOne, Grade::fromNumber(4), '');
        $jokeFiveJokerOne = Joke::graded($jokerOne, Grade::fromNumber(5), '');
        $jokeSixJokerOne = Joke::graded($jokerOne, Grade::fromNumber(6), '');

        $jokeOneJokerTwo = Joke::graded($jokerTwo, Grade::fromNumber(5), '');
        $jokeTwoJokerTwo = Joke::graded($jokerTwo, Grade::fromNumber(6), '');
        $jokeThreeJokerTwo = Joke::graded($jokerTwo, Grade::fromNumber(7), '');
        $jokeFourJokerTwo = Joke::graded($jokerTwo, Grade::fromNumber(8), '');
        $jokeFiveJokerTwo = Joke::graded($jokerTwo, Grade::fromNumber(9), '');
        $jokeSixJokerTwo = Joke::graded($jokerTwo, Grade::fromNumber(10), '');

        $runOne = Run::fromArray([
            $jokeOneJokerOne,
            $jokeOneJokerTwo,
            $jokeTwoJokerOne,
            $jokeTwoJokerTwo,
            $jokeThreeJokerOne,
            $jokeThreeJokerTwo
        ]);

        $runTwo = Run::fromArray([
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

<?php

namespace BrasseursApplis\JokesContest;

class Contest
{
    /** @var Run[] */
    private $runs;

    /**
     * Contest constructor.
     *
     * @param Run[] $runs
     */
    public function __construct(array $runs = [])
    {
        $this->runs = array_values($runs);
    }

    /**
     * @return Joker
     */
    public function getWinner(): Joker
    {
        return $this->ranking()->getFirst();
    }

    /**
     * @return Ranking
     */
    public function ranking(): Ranking
    {
        return new Ranking(
            array_map(
                function (Joker $joker) {
                    return $this->scoreOf($joker);
                },
                $this->participants()
            )
        );
    }

    /**
     * @param Run $run
     *
     * @return Contest
     */
    public function addRun(Run $run): Contest
    {
        return new self(array_merge($this->runs, [ $run ]));
    }

    /**
     * @return int
     */
    public function numberOfRuns(): int
    {
        return count($this->runs);
    }

    /**
     * @return Joker[]
     */
    private function participants(): array
    {
        return array_unique(
            array_merge(
                ...array_map(
                    function (Run $run) {
                        return $run->participants();
                    },
                    $this->runs
                )
            ),
            SORT_REGULAR
        );
    }

    /**
     * @param Joker $joker
     *
     * @return Score
     */
    private function scoreOf(Joker $joker): Score
    {
        return new Score(
            $joker,
            Grade::sum(
                array_map(
                    function (Run $run) use ($joker) {
                        return $run->averageFor($joker);
                    },
                    $this->runs
                )
            )
        );
    }
}

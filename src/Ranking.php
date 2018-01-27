<?php

namespace BrasseursApplis\JokesContest;

class Ranking
{
    /** @var Score[] */
    private $scores;

    /**
     * Ranking constructor.
     *
     * @param Score[] $scores
     */
    public function __construct(array $scores)
    {
        $this->scores = array_values($scores);

        usort(
            $this->scores,
            function (Score $one, Score $two) {
                return $one->compare($two);
            }
        );

    }

    /**
     * @return Joker
     */
    public function getFirst(): Joker
    {
        return $this->getScoreOf(1)->participant();
    }

    /**
     * @param int $position
     *
     * @return Score
     */
    public function getScoreOf(int $position): Score
    {
        if (isset($this->scores[$position - 1])) {
            return $this->scores[$position - 1];
        }

        throw new \InvalidArgumentException('Position is not valid');
    }
}

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
        return $this->scores[0]->participant();
    }
}

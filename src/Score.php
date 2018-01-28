<?php

namespace BrasseursApplis\JokesContest;

class Score implements Comparable
{
    /** @var Joker */
    private $joker;

    /** @var Grade */
    private $grade;

    /**
     * Score constructor.
     *
     * @param Joker $joker
     * @param Grade $grade
     */
    public function __construct(
        Joker $joker,
        Grade $grade
    ) {
        $this->joker = $joker;
        $this->grade = $grade;
    }

    /**
     * @return Joker
     */
    public function participant(): Joker
    {
        return $this->joker;
    }

    /**
     * @return Grade
     */
    public function grade(): Grade
    {
        return $this->grade;
    }

    /**
     * Order is reversed here so that scores are sorted by greater score first
     *
     * @param Comparable $other
     *
     * @return int
     *
     * @throws \InvalidArgumentException
     */
    public function compare(Comparable $other): int
    {
        if (! $other instanceof Score) {
            throw new \InvalidArgumentException('You can only compare two grades');
        }

        return - $this->grade->compare($other->grade);
    }
}

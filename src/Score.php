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
     * It must return a negative value if the current object is less than the other,
     * a positive value if the current object is greater than the other, and zero
     * if they are equal.
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

        return - $this->grade->compare($other->grade); // scores are sorted by greater score first
    }
}

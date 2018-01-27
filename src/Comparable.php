<?php

namespace BrasseursApplis\JokesContest;

interface Comparable
{
    /**
     * It must return a negative value if the current object is less than the other,
     * a positive value if the current object is greater than the other, and zero
     * if they are equal.
     *
     * @param Comparable $other
     *
     * @return int
     */
    public function compare(Comparable $other): int;
}

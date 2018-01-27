<?php

namespace BrasseursApplis\JokesContest;

use Assert\Assert;

class Grade implements Comparable
{
    /** @var int */
    private $grade;

    /**
     * Grade constructor.
     *
     * @param int $grade
     */
    public function __construct(int $grade)
    {
        Assert::that($grade)
            ->greaterOrEqualThan(0)
            ->lessOrEqualThan(10);

        $this->grade = $grade;
    }

    /**
     * @param Grade $grade
     *
     * @return bool
     */
    public function equals(Grade $grade): bool
    {
        return $this->grade === $grade->grade;
    }

    /**
     * @param Grade[] $grades
     *
     * @return Grade
     */
    public static function average(array $grades): Grade
    {
        Assert::that($grades)
            ->all()
            ->isInstanceOf(Grade::class);

        $numberOfGrades = count($grades);

        if ($numberOfGrades === 0) {
            return new self(0);
        }

        return new self(
            array_reduce(
                $grades,
                function ($sum, Grade $grade) {
                    return $sum + $grade->grade;
                },
                0
            ) / $numberOfGrades
        );
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
        if (! $other instanceof Grade) {
            throw new \InvalidArgumentException('You can only compare two grades');
        }

        return $this->grade - $other->grade;
    }
}

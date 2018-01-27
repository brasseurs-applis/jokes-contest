<?php

namespace BrasseursApplis\JokesContest;

use Assert\Assert;

class Grade
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
}

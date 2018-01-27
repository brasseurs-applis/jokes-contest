<?php

namespace BrasseursApplis\JokesContest;

use Assert\Assert;
use BrasseursApplis\JokesContest\Util\BigDecimalUtil;
use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;

class Grade implements Comparable
{
    const PRECISION = 2;

    /** @var BigDecimal */
    private $grade;

    /**
     * Grade constructor.
     *
     * @param BigDecimal $grade
     */
    private function __construct(BigDecimal $grade)
    {
        $this->grade = $grade;
    }

    /**
     * @param float $grade
     *
     * @return Grade
     *
     * @throws \InvalidArgumentException
     */
    public static function fromNumber(float $grade): Grade
    {
        Assert::that($grade)
              ->greaterOrEqualThan(0)
              ->lessOrEqualThan(10);

        return new self(BigDecimalUtil::fromNumber($grade, Grade::PRECISION));
    }

    /**
     * @param BigDecimal $points
     *
     * @return Grade
     */
    public function addPoint(BigDecimal $points): Grade
    {
        return new self(
            $this->grade
                ->plus($points)
                ->toScale(Grade::PRECISION, RoundingMode::HALF_EVEN)
        );
    }

    /**
     * @param BigDecimal $multiplier
     *
     * @return Grade
     */
    public function multiply(BigDecimal $multiplier): Grade
    {
        return new self(
            $this->grade
                ->multipliedBy($multiplier)
                ->toScale(Grade::PRECISION, RoundingMode::HALF_EVEN)
        );
    }

    /**
     * @param Grade $grade
     *
     * @return bool
     */
    public function equals(Grade $grade): bool
    {
        return $this->grade->isEqualTo($grade->grade);
    }

    /**
     * @param Grade[] $grades
     *
     * @return Grade
     */
    public static function average(array $grades): Grade
    {
        $numberOfGrades = count($grades);

        if ($numberOfGrades === 0) {
            return self::fromNumber(0);
        }

        return new self(
            self::sum($grades)->grade->dividedBy(
                BigInteger::of($numberOfGrades),
                self::PRECISION,
                RoundingMode::HALF_EVEN
            )->toScale(Grade::PRECISION, RoundingMode::HALF_EVEN)
        );
    }

    /**
     * @param Grade[] $grades
     *
     * @return Grade
     */
    public static function sum(array $grades): Grade
    {
        Assert::that($grades)
              ->all()
              ->isInstanceOf(Grade::class);

        $numberOfGrades = count($grades);

        if ($numberOfGrades === 0) {
            return self::fromNumber(0);
        }

        return new Grade(
            array_reduce(
                $grades,
                function (BigDecimal $sum, Grade $grade) {
                    return $sum->plus($grade->grade)
                               ->toScale(Grade::PRECISION, RoundingMode::HALF_EVEN);
                },
                BigDecimal::ofUnscaledValue(0, self::PRECISION)
            )
        );
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        return $this->grade->toFloat();
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

        return $this->grade->compareTo($other->grade);
    }
}

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

    const MIN = 0;
    const MAX = 10;

    /** @var BigDecimal */
    private $grade;

    /**
     * Grade constructor.
     *
     * @param BigDecimal $grade
     */
    private function __construct(BigDecimal $grade)
    {
        $this->grade = $grade->toScale(Grade::PRECISION);
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
        // The grade constraints are only put here because the constraints only exist for the outside world
        Assert::that($grade)
              ->greaterOrEqualThan(self::MIN)
              ->lessOrEqualThan(self::MAX);

        return new self(BigDecimalUtil::fromNumber($grade, Grade::PRECISION));
    }

    /**
     * @param BigDecimal $points
     *
     * @return Grade
     */
    public function addPoint(BigDecimal $points): Grade
    {
        return new self($this->grade->plus($points));
    }

    /**
     * @param BigDecimal $multiplier
     *
     * @return Grade
     */
    public function multiply(BigDecimal $multiplier): Grade
    {
        return new self($this->grade->multipliedBy($multiplier));
    }

    /**
     * @param Grade $grade
     *
     * @return bool
     */
    public function equals(Grade $grade): bool
    {
        return $this->compare($grade) === 0;
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

    /**
     * @return float
     */
    public function toFloat(): float
    {
        return $this->grade->toFloat();
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

        return new Grade(
            array_reduce(
                $grades,
                function (BigDecimal $sum, Grade $grade) {
                    return $sum->plus($grade->grade);
                },
                BigDecimalUtil::fromNumber(0, self::PRECISION)
            )
        );
    }

    /**
     * @param Grade[] $grades
     *
     * @return Grade
     */
    public static function average(array $grades): Grade
    {
        if (empty($grades)) {
            return self::fromNumber(0);
        }

        return new self(
            self::sum($grades)->grade->dividedBy(BigInteger::of(count($grades)),self::PRECISION,RoundingMode::HALF_EVEN)
        );
    }
}

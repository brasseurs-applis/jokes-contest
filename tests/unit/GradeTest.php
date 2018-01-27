<?php

namespace BrasseursApplis\JokesContest;

use BrasseursApplis\JokesContest\Helper\FakerTrait;
use PHPUnit\Framework\TestCase;

class GradeTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function a grade cannot be lower than zero(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Grade::fromNumber($this->getFaker()->numberBetween(PHP_INT_MIN, -1));
    }

    /**
     * @test
     */
    public function a grade cannot be greater than ten(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Grade::fromNumber($this->getFaker()->numberBetween(10, PHP_INT_MAX));
    }

    /**
     * @test
     */
    public function a grade between zero and ten is acceptable(): void
    {
        $number = $this->getFaker()->numberBetween(0, 10);

        $grade = Grade::fromNumber($number);
        
        self::assertTrue($grade->equals(Grade::fromNumber($number)));
    }

    /**
     * @test
     */
    public function the average of no grades is an average of zero(): void
    {
        $zero = Grade::fromNumber(0);

        self::assertTrue($zero->equals(Grade::average([])));
    }
}

<?php

namespace BrasseursApplis\JokesContest\Rules\Run;

use BrasseursApplis\JokesContest\Grade;
use BrasseursApplis\JokesContest\JokeCollection;
use BrasseursApplis\JokesContest\Util\BigDecimalUtil;
use Brick\Math\BigDecimal;

class MultiplyGrade extends ComposableRunRule
{
    /** @var BigDecimal */
    private $multiplier;

    /**
     * MultiplyGrade constructor.
     *
     * @param BigDecimal $multiplier
     */
    private function __construct(BigDecimal $multiplier)
    {
        $this->multiplier = $multiplier;
    }

    /**
     * @param float $number
     *
     * @return MultiplyGrade
     */
    public static function fromNumber(float $number): MultiplyGrade
    {
        return new self(BigDecimalUtil::fromNumber($number, Grade::PRECISION));
    }

    /**
     * @param JokeCollection $jokeCollection
     *
     * @return JokeCollection
     */
    public function onJokes(JokeCollection $jokeCollection): JokeCollection
    {
        return $jokeCollection;
    }

    /**
     * @param Grade $grade
     *
     * @return Grade
     */
    public function onGrade(Grade $grade): Grade
    {
        return $grade->multiply($this->multiplier);
    }
}

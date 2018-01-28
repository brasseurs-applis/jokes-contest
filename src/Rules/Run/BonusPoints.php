<?php

namespace BrasseursApplis\JokesContest\Rules\Run;

use BrasseursApplis\JokesContest\Grade;
use BrasseursApplis\JokesContest\JokeCollection;
use BrasseursApplis\JokesContest\Util\BigDecimalUtil;
use Brick\Math\BigDecimal;

class BonusPoints extends ComposableRunRule
{
    /** @var BigDecimal */
    private $bonusPoints;

    /**
     * BonusPoints constructor.
     *
     * @param BigDecimal $bonusPoints
     */
    private function __construct(BigDecimal $bonusPoints)
    {
        $this->bonusPoints = $bonusPoints;
    }

    /**
     * @param float $number
     *
     * @return BonusPoints
     */
    public static function fromNumber(float $number): BonusPoints
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
        return $grade->addPoints($this->bonusPoints);
    }
}

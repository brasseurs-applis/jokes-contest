<?php

namespace BrasseursApplis\JokesContest\Util;

use Brick\Math\BigDecimal;

class BigDecimalUtil
{
    /**
     * @param float $number
     * @param int   $precision
     *
     * @return BigDecimal
     */
    public static function fromNumber(float $number, int $precision): BigDecimal
    {
        return BigDecimal::ofUnscaledValue($number * pow(10, $precision), $precision);
    }
}

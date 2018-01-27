<?php

namespace BrasseursApplis\JokesContest;

use BrasseursApplis\JokesContest\Helper\FakerTrait;
use PHPUnit\Framework\TestCase;

class JokeTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function a joke has an author and a grade(): void
    {
        $joker = new Joker($this->getFaker()->name);
        $grade = Grade::fromNumber($this->getFaker()->numberBetween(0, 10));

        $joke = Joke::createJoke($joker, $grade, '');

        self::assertTrue($joke->isFrom($joker));
        self::assertSame($grade, $joke->grade());
    }
}

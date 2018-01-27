<?php

namespace BrasseursApplis\JokesContest;

use BrasseursApplis\JokesContest\Helper\FakerTrait;
use PHPUnit\Framework\TestCase;

class JokerTest extends TestCase
{
    use FakerTrait;

    /** @var Joker */
    private $sut;

    /** @var string */
    private $name;

    /**
     * Setup
     */
    protected function setUp()
    {
        $this->name = $this->getFaker()->name();

        $this->sut = new Joker($this->name);
    }

    /**
     * Teardown
     */
    protected function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function a joker has a name()
    {
        self::assertEquals($this->name, $this->sut->name());
    }

    /**
     * @test
     */
    public function two jokers can be different()
    {
        $otherJoker = new Joker($this->getFaker()->name());

        self::assertFalse($this->sut->is($otherJoker));
    }

    /**
     * @test
     */
    public function two jokers can be the same()
    {
        $otherJoker = new Joker($this->name);

        self::assertTrue($this->sut->is($otherJoker));
    }
}

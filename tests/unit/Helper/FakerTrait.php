<?php

namespace BrasseursApplis\JokesContest\Helper;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    /** @var Generator */
    private $faker;

    /**
     * @return Generator
     */
    public function getFaker()
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }
}

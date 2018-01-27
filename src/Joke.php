<?php

namespace BrasseursApplis\JokesContest;

class Joke
{
    /** @var Joker */
    private $joker;

    /** @var Grade */
    private $grade;

    /**
     * Joke constructor.
     *
     * @param Joker              $joker
     * @param Grade              $grade
     * @param string             $content
     * @param \DateTimeInterface $date
     */
    public function __construct(
        Joker $joker,
        Grade $grade,
        string $content,
        \DateTimeInterface $date
    ) {
        $this->joker = $joker;
        $this->grade = $grade;
    }

    /**
     * @param Joker  $joker
     * @param Grade  $grade
     * @param string $content
     *
     * @return Joke
     */
    public static function createJoke(
        Joker $joker,
        Grade $grade,
        string $content
    ): Joke {
        return new self(
            $joker,
            $grade,
            $content,
            new \DateTimeImmutable()
        );
    }

    /**
     * @param Joker $joker
     *
     * @return bool
     */
    public function isFrom(Joker $joker): bool
    {
        return $joker->is($this->joker);
    }

    /**
     * @return Joker
     */
    public function author(): Joker
    {
        return $this->joker;
    }

    /**
     * @return Grade
     */
    public function grade(): Grade
    {
        return $this->grade;
    }
}

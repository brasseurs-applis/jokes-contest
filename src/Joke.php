<?php

namespace BrasseursApplis\JokesContest;

class Joke
{
    const TYPE_GRADED = 'graded';
    const TYPE_WILDCARD = 'wildcard';
    const TYPE_CANCELLED = 'cancelled';

    /** @var Joker */
    private $joker;

    /** @var Grade */
    private $grade;

    /** @var string */
    private $content;

    /** @var \DateTimeInterface */
    private $date;

    /** @var string */
    private $type;

    /**
     * Joke constructor.
     *
     * @param Joker              $joker
     * @param Grade              $grade
     * @param string             $content
     * @param string             $type
     * @param \DateTimeInterface $date
     */
    private function __construct(
        Joker $joker,
        Grade $grade,
        string $content,
        string $type,
        \DateTimeInterface $date
    ) {
        $this->joker = $joker;
        $this->grade = $grade;
        $this->content = $content;
        $this->type = $type;
        $this->date = $date;
    }

    /**
     * @param Joker  $joker
     * @param Grade  $grade
     * @param string $content
     * @param string $type
     *
     * @return Joke
     */
    private static function create(
        Joker $joker,
        Grade $grade,
        string $content,
        string $type
    ): Joke {
        return new self(
            $joker,
            $grade,
            $content,
            $type,
            new \DateTimeImmutable()
        );
    }

    /**
     * @param Joker  $joker
     * @param Grade  $grade
     * @param string $content
     *
     * @return Joke
     */
    public static function graded(
        Joker $joker,
        Grade $grade,
        string $content = ''
    ): Joke {
        return self::create(
            $joker,
            $grade,
            $content,
            self::TYPE_GRADED
        );
    }

    /**
     * @param Joker  $joker
     * @param string $content
     *
     * @return Joke
     */
    public static function wildcard(
        Joker $joker,
        string $content = ''
    ): Joke {
        return self::create(
            $joker,
            Grade::fromNumber(0),
            $content,
            self::TYPE_WILDCARD
        );
    }

    /**
     * @return Joke
     */
    public function cancel(): Joke
    {
        return new self(
            $this->joker,
            $this->grade,
            $this->content,
            self::TYPE_CANCELLED,
            $this->date
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
        return $this->isGraded() ? $this->grade : null;
    }

    /**
     * @return bool
     */
    public function isWildcard(): bool
    {
        return $this->type === self::TYPE_WILDCARD;
    }

    /**
     * @return bool
     */
    public function isGraded():bool
    {
        return $this->type === self::TYPE_GRADED;
    }
}

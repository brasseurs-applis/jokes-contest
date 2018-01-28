<?php

namespace BrasseursApplis\JokesContest\Exception;

use BrasseursApplis\JokesContest\Joke;

class TooManyWildcardsException extends \InvalidArgumentException
{
    /** @var Joke */
    private $wildcard;

    /**
     * TooManyWildcardsException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     * @param Joke            $wildcard
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        \Throwable $previous = null,
        ?Joke $wildcard = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->wildcard = $wildcard;
    }

    /**
     * @param Joke            $wildCard
     * @param \Throwable|null $previous
     * @param int             $code
     *
     * @return TooManyWildcardsException
     */
    public static function create(
        Joke $wildCard,
        \Throwable $previous = null,
        $code = 0
    ): TooManyWildcardsException {
        return new self(
            sprintf('The wildcard has already been used for %s', $wildCard->author()->name()),
            $code,
            $previous,
            $wildCard
        );
    }

    /**
     * @return Joke
     */
    public function getWildcard(): Joke
    {
        return $this->wildcard;
    }
}

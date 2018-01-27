<?php

namespace BrasseursApplis\JokesContest\Rules\Run;

use BrasseursApplis\JokesContest\Rules\RunRule;

abstract class ComposableRunRule implements RunRule
{
    /**
     * @param RunRule $rule
     *
     * @return RunRule
     */
    public function combine(RunRule $rule): RunRule
    {
        return CompositeRunRule::create()
                               ->combine($this)
                               ->combine($rule);
    }
}

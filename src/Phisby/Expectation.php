<?php

namespace Phisby;

/**
 * Phisby Expectation
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class Expectation
{
    /**
     * @var \Phisby\Constraint Expectation constraints
     */
    private $constraints = [];

    /**
     * Clear all expectations
     */
    public function clear()
    {
        $this->constraints = [];
    }

    /**
     * Add a constraint
     *
     * @param \Phisby\Constraint $constraint
     */
    public function add(Constraint $constraint)
    {
        $this->constraints[] = $constraint;
    }

    /**
     * Assert response
     *
     * @param \Phisby\Response $response
     */
    public function assert(Response $response)
    {
        foreach ($this->constraints as $constraint) {
            $constraint->evaluate($response);
        }
    }
}

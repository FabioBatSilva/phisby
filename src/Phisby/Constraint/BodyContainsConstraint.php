<?php

namespace Phisby\Constraint;

use Phisby\Response;

/**
 * Phisby request body constraint
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class BodyContainsConstraint extends BaseConstraint
{
    /**
     * @var array Expected body
     */
    private $expectedBody;

    /**
     * @param string $expectedBody
     */
    public function __construct($expectedBody)
    {
        $this->expectedBody = $expectedBody;
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate(Response $response)
    {
        $actual  = (string)$response->getBody();
        $context = "Expected body contains";

        $this->assertContains($this->expectedBody, $actual, $context);
    }
}

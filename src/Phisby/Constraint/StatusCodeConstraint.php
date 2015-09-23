<?php

namespace Phisby\Constraint;

use Phisby\Response;

/**
 * Phisby status code constraint
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class StatusCodeConstraint extends BaseConstraint
{
    /**
     * @var integer Expected status code
     */
    private $expectedStatus;

    /**
     * @param integer $expectedStatus
     */
    public function __construct($expectedStatus)
    {
        $this->expectedStatus = $expectedStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate(Response $response)
    {
        $this->assertEquals($this->expectedStatus, $response->getStatusCode(), "Expected status code");
    }
}

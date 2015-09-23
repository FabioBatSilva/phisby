<?php

namespace Phisby;

use Phisby\Response;

/**
 * Phisby constraint
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
interface Constraint
{
    /**
     * Evaluate the response
     *
     * @param \Phisby\Response $response
     */
    public function evaluate(Response $response);
}

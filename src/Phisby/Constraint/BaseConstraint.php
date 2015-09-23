<?php

namespace Phisby\Constraint;

use PHPUnit_Framework_Assert;
use Phisby\Constraint;
use Phisby\DataAccess;
use Phisby\Response;

/**
 * Phisby base constraint
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
abstract class BaseConstraint extends PHPUnit_Framework_Assert implements Constraint
{
    /**
     * Extract JSON data
     *
     * @param \Phisby\Response $response
     * @param string           $path
     *
     * @return array
     */
    protected function extractJson(Response $response, $path)
    {
        $json   = $response->json();
        $access = new DataAccess($json);

        return $access->get($path);
    }
}

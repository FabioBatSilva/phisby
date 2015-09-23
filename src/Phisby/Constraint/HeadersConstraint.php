<?php

namespace Phisby\Constraint;

use Phisby\Response;

/**
 * Phisby headers constraint
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class HeadersConstraint extends BaseConstraint
{
    /**
     * @var array Expected header
     */
    private $expectedHeaders = [];

    /**
     * @param array $expectedHeaders
     */
    public function __construct(array $expectedHeaders)
    {
        $this->expectedHeaders = array_map(function($value){
            return is_array($value) ? $value : [$value];
        }, $expectedHeaders);
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate(Response $response)
    {
        foreach ($this->expectedHeaders as $name => $values) {
            $context = "Expected header : $name";
            $headers = $response->getHeaders();

            $this->assertArrayHasKey($name, $headers, $context);
            $this->assertEquals($values, $headers[$name], $context);
        }
    }
}

<?php

namespace Phisby\Constraint;

use Phisby\Response;

/**
 * Phisby json types constraint
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class JSONTypesConstraint extends BaseConstraint
{
    /**
     * @var array Expected JSON types
     */
    private $expectedJSONTypes = [];

    /**
     * @var string Path to JSON data
     */
    private $path;

    /**
     * @param string $path
     * @param array  $expectedJSONTypes
     */
    public function __construct($path, array $expectedJSONTypes)
    {
        $this->path              = $path;
        $this->expectedJSONTypes = $expectedJSONTypes;
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate(Response $response)
    {
        foreach ($this->expectedJSONTypes as $name => $expected) {
            $actual  = $this->extractJson($response, $this->path);
            $context = "Expected JSON Type (path:{$this->path}[$name])";

            $this->assertArrayHasKey($name, $actual, $context);
            $this->assertInternalType($expected, $actual[$name], $context);
        }
    }
}

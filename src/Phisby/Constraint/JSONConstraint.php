<?php

namespace Phisby\Constraint;

use Phisby\Response;

/**
 * Phisby json data constraint
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class JSONConstraint extends BaseConstraint
{
    /**
     * @var array Expected JSON types
     */
    private $expectedJSON = [];

    /**
     * @var string Path to JSON data
     */
    private $path;

    /**
     * @param string $path
     * @param array  $expectedJSON
     */
    public function __construct($path, array $expectedJSON)
    {
        $this->path         = $path;
        $this->expectedJSON = $expectedJSON;
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate(Response $response)
    {
        foreach ($this->expectedJSON as $name => $expected) {
            $actual  = $this->extractJson($response, $this->path);
            $context = "Expected JSON (path:{$this->path}[$name])";

            $this->assertArrayHasKey($name, $actual, $context);
            $this->assertEquals($expected, $actual[$name], $context);
        }
    }
}

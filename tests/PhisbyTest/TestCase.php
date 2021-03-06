<?php

namespace PhisbyTest;

use PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @param object $object
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    protected function invokeMethod($object, $method, array $args= [])
    {
        $reflection = new \ReflectionMethod($object, $method);

        $reflection->setAccessible(true);

        return $reflection->invokeArgs($object, $args);
    }

    /**
     * @param object $object
     * @param string $property
     *
     * @return mixed
     */
    protected function getPropertyValue($object, $property)
    {
        $reflection = new \ReflectionProperty($object, $property);

        $reflection->setAccessible(true);

        return $reflection->getValue($object);
    }

    /**
     * @param object $object
     * @param string $property
     * @param mixed  $value
     */
    protected function setPropertyValue($object, $property, $value)
    {
        $reflection = new \ReflectionProperty($object, $property);

        $reflection->setAccessible(true);
        $reflection->setValue($object, $value);
    }
}

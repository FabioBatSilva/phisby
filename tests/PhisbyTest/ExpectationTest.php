<?php

namespace PhisbyTest;

use Phisby\Expectation;
use Phisby\Response;

class ExpectationTest extends TestCase
{
    public function testAddAndClearConstraint()
    {
        $expectation = new Expectation();
        $constraint  = $this->getMock('Phisby\Constraint');

        $this->assertEquals([], $this->getPropertyValue($expectation, 'constraints'));

        $expectation->add($constraint);

        $this->assertEquals([$constraint], $this->getPropertyValue($expectation, 'constraints'));

        $expectation->clear();

        $this->assertEquals([], $this->getPropertyValue($expectation, 'constraints'));
    }

    public function testAssertConstraints()
    {
        $expectation = new Expectation();
        $request     = new Response(200, []);
        $constraint1 = $this->getMock('Phisby\Constraint');
        $constraint2 = $this->getMock('Phisby\Constraint');

        $expectation->add($constraint1);
        $expectation->add($constraint2);

        $constraint1
            ->expects($this->once())
            ->method('evaluate')
            ->with($this->equalTo($request));

        $constraint2
            ->expects($this->once())
            ->method('evaluate')
            ->with($this->equalTo($request));

        $expectation->assert($request);
    }
}

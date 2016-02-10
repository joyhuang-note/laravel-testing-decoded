<?php

class CalculatorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->calc = new Calculator;
    }

    public function testResultDefaultToZero()
    {
        $this->assertSame(0, $this->calc->getResult());
    }

    public function testAddsNumber()
    {
        $this->calc->setOperands(5);
        $this->calc->setOperation(new Addition);
        $result = $this->calc->calculate();

        $this->assertEquals(5, $result);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRequiresNumericValue()
    {
        $this->calc->setOperands('five');
        $this->calc->setOperation(new Addition);
        $result = $this->calc->calculate();
    }

    public function testAcceptsMultipleArgs()
    {
        $this->calc->setOperands(1, 2, 3, 4);
        $this->calc->setOperation(new Addition);
        $result = $this->calc->calculate();

        $this->assertEquals(10, $result);
    }

    public function testSubtractsNumbers()
    {
        $this->calc->setOperands(4);
        $this->calc->setOperation(new Subtraction);
        $result = $this->calc->calculate();

        $this->assertEquals(-4, $result);
    }

    public function testMultipliesNumbers()
    {
        $this->calc->setOperands(3, 3, 3);
        $this->calc->setOperation(new Multiplication);
        $result = $this->calc->calculate();

        $this->assertEquals(27, $result);
    }

}

?>
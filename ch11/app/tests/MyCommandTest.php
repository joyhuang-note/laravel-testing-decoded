<?php

class MyCommandTest extends TestCase {

    public function testFire()
    {
        $gen = Mockery::mock('ModelGenerator');
        $gen->shouldReceive('make')->once()->andReturn(true);

        $command = new MyCommand($gen);

        $this->assertEquals('foo', $command->fire());
    }

}
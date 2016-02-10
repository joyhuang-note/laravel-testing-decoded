<?php

class FooTest extends TestCase {

    public function tearDown()
    {
        Mockery::close();
    }

	public function testCreatesFile()
	{
		File::shouldReceive('put')->once();

		$this->call('GET', 'foo');
	}

}

<?php

class CustomGeneratorTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        Mockery::close();
    }

    public function testItWorks()
    {
        $mockedFile = Mockery::mock('File');

        $mockedFile->shouldReceive('exists')
                   ->once()
                   ->andReturn(false);

        $mockedFile->shouldReceive('put')
                   ->with('foo.txt', 'foo bar')
                   ->once();

        $generator = new CustomGenerator($mockedFile);
        $generator->fire();
    }

    public function testDoesNotOverwriteFile()
    {
        $mockedFile = Mockery::mock('File');

        $mockedFile->shouldReceive('exists')
                   ->once()
                   ->andReturn(true);

        $mockedFile->shouldReceive('put')
                   ->never();

        $generator = new CustomGenerator($mockedFile);
        $generator->fire();
    }

}

?>
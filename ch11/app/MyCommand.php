<?php

class MyCommand {
    protected $generator;

    public function __construct(ModelGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function fire()
    {
        return $this->generator->make() ? 'foo' : 'bar';
    }

}

<?php

class UserControllerTest extends TestCase {

    public function testIndex()
    {
        App::instance('User', Mockery::mock(['all' => 'foo1']));

        $this->call('GET', 'users');
    }

}
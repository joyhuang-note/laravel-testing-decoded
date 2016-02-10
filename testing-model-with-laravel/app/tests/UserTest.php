<?php

use Way\Tests\Factory;

class UserTest extends TestCase {
    use Way\Tests\ModelHelpers;

    public function testHashesPasswordWhenSet()
    {
        Hash::shouldReceive('make')->once()->andReturn('hashed');

        $author = new User;
        $author->password = 'foo';

        $this->assertEquals('hashed', $author->password);
    }

    public function testHasManyPosts()
    {
        $this->assertHasMany('posts', 'User');
    }

}

?>
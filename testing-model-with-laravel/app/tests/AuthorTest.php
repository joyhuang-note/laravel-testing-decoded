<?php

use Way\Tests\Factory;

class AuthorTest extends TestCase {
    //use ModelHelpers;
    use Way\Tests\ModelHelpers;

    public function testIsInvalidWithoutAName()
    {
        $author = Factory::author(['name' => null]);

        $this->assertNotValid($author);
    }

    public function testIsInValidWithoutAValidEmail()
    {
        $author = Factory::author(['name' => 'Joy', 'email' => 'foo']);

        $this->assertNotValid($author);
    }

    public function testIsInvalidWithoutUniqueEmail()
    {
        Factory::create('author', ['name' => 'Joy', 'email' => 'joy@example.com']);

        $author = Factory::author(['name' => 'Frank', 'email' => 'joy@example.com']);

        $this->assertNotValid($author);
    }

}

?>
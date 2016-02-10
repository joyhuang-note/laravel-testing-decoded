<?php

class PostsControllerTest extends TestCase {

    public function tearDown()
    {
        Mockery::close();
    }

    public function testIndex()
    {
        Post::shouldReceive('all')->once();

        $this->call('GET', 'posts');

        $this->assertViewHas('posts');
    }

    public function testStoreFails()
    {
        $input = ['title' => ''];

        $this->call('POST', 'posts', $input);

        $this->assertRedirectedToRoute('posts.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $input = ['title' => 'Foo Title'];

        Post::shouldReceive('create')->once();

        $this->call('POST', 'posts', $input);

        $this->assertRedirectedToRoute('posts.index', [], ['flash']);
    }

}

?>
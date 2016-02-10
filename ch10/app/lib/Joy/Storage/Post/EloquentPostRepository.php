<?php namespace Joy\Storage\Post;

use Post;

class EloquentPostRepository implements PostRepositoryInterface {

    public function all()
    {
        return Post::all();
    }

    public function find($id)
    {
        return Post::find($id);
    }

    public function create($input)
    {
        return Post::create($input);
    }

}
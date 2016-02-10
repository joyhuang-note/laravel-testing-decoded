<?php namespace Joy\Storage\Post;

interface PostRepositoryInterface {

    public function all();

    public function find($id);

    public function create($input);

}
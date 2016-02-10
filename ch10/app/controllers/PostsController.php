<?php

use Joy\Storage\Post\PostRepositoryInterface as Post;

class PostsController extends \BaseController {

    protected $post;

    public function __construct(Post $post)
    {
    	$this->post = $post;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = $this->post->all();

		return View::make('posts.index', ['posts' => $posts]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$v = Validator::make($input, ['title' => 'required']);

		if ($v->fails())
		{
			return Redirect::route('posts.create')
				->withInput()
				->withErrors($v->messages());
		}

		$post = $this->post->create($input);

		return Redirect::route('posts.index')
			->with('flash', 'Your post has been created!');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}

<?php namespace Joy\Storage;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(
            'Joy\Storage\Post\PostRepositoryInterface',
            'Joy\Storage\Post\EloquentPostRepository'
        );
    }

}

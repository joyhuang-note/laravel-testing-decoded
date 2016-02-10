# Testing APIs #

## Three Components to Writing an API in Laravel ##

### 1.Authentication ###

    //app/routes.php

    Route::resource('photos','PhotosApiController');

    //app/controllers/PhotosApiController.php

    class PhotosApiController {
        public function __construct()
        {
            $this->beforeFilter('auth.basic');
        }
    }

### 2.Route Prefixing ###

> By adopting a consistent pattern, such as api/v1 or api/v2, we’re able to extend the API’s functionality in the future

    Route::group(['prefix' => 'api/v1'], function() {
        Route::resource('photos', 'PhotosApiController');
    });

### 3.Return JSON ###

> By default, when a collection is returned from a controller method, that data will be translated into JSON.

    public function show($id)
    {
        return User::find($id); // return JSON
    }

> To manually return a JSON response from a route, use the `json` method on the `Response` class.

    class PhotosApiController extends \BaseController {
        public function index()
        {
            return Response::json([
                'error' => false,
                'photos' => Auth::user()->photos->toArray()
            ], 200);
        }
    }

## Use a Database in Memory ##

> Assuming that your API is mostly CRUD-based, chances are high that you can opt for a Sqlite database in memory, which should provide a performance boost

    <?php // app/config/testing/database.php

    return array(
        'default' => 'sqlite',

        'connections' => array(
            'sqlite' => array(
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => ''
            )
        )
    );

> Pay close attention to the fact that, rather than setting the database key to a .sqlite file, instead, a database in memory is specified.

> when testing, Laravel will automatically set the environment to testing and reference the in-memory DB.

## Migrate the Database for Each Test ##

> As we plan to reference a database in memory, it’s important to migrate and seed the database before each test

    class PhotosApiTest extends TestCase {
        public function setUp()
        {
            parent::setUp();

            Artisan::call('migrate');
            Artisan::call('db:seed');
        }
    }

> when Laravel seemingly ignores route filters when unit testing.

> To compensate for this, before each test, always activate the filters.

    public function setUp()
    {
        parent::setUp();

        Route::enableFilters();
    }

## Test Examples ##


### User Must Be Authenticated ###

    //app/tests/api/PhotoApiTest.php

    class PhotoApiTest extends TestCase {
        
        public function setUp()
        {
            parent::setUp();

            Route::enableFilters();

            Artisan::call('migrate');
            $this->seed();

            Auth::loginUsingId(1);
        }

        public function testMustBeAuthenticated()
        {
            Auth::logout();

            $response = $this->call('GET', 'api/v1/photos');

            $this->assertEquals('Invalid credentials.', $response->getContent());
        }

    }

### Check For Error ###

> verifies whether an error property exists on the returned object

    public function testProvidesErrorFeedback()
    {
        $response = $this->call('GET', 'api/v1/photos');
        $data = json_decode($response->getContent());

        $this->assertEquals(false, $data->error);
    }


### Fetch All Photos For the Authenticated User ###

(Need to Refactor the test !)

    public function testFetchesAllPhotosForUser()
    {
        $response = $this->call('GET', 'api/v1/photos');
        $content = $response->getContent();
        $data = json_decode($content);

        // Did we receive valid JSON?
        $this->assertJson($content);

        // Decoded JSON should offer a photos array
        $this->assertInternalType('array', $data->photos);
    }

### Refactoring ###

    public function testReturnsValidJson()
    {
        $response = $this->call('GET', 'api/v1/photos');
        $this->assertJson($response->getContent());
    }

    public function testFetchesPhotos()
    {
        $response = $this->call('GET', 'api/v1/photos');
        $data = json_decode($response->getContent());

        $this->assertInternalType('array', $data->photos);
    }

### Updating a Photo ###

> The following example will set a factory for a Photo and save it to the DB, and then call the necessary API route to update the record.

    public function testUpdatesExistingPhoto()
    {
        // Poor man's factory (Need to refactoring!)
        $photo = new Photo;
        $photo->caption = 'Some Photo';
        $photo->path = 'foo.jpg';
        $photo->user_id = 1;
        $photo->save();
 
        $updatedPhotoFields = ['caption' => 'Updated Photo Caption'];

        $response = $this->call('PATCH', 'api/v1/photos/1', $updatedPhotoFields);

        $data = json_decode($response->getContent());
        $this->assertEquals('Photo has been updated', $data->message);
        $this->assertEquals('Updated Photo Caption', Photo::find(1)->caption);
    }

### Factories ###

> You can pull it into your project by either installing `Laravel 4 Generators` (which includes the package) or `Laravel Test Helpers`.

    use Way\Tests\Factory;
    //...
    Factory::create('Photo');

    Factory::create('Photo', ['caption' => 'Somecaption']);

> With this modification, the `testUpdatesExistingPhoto` spec may be updated to:

    public function testUpdatesExistingPhoto()
    {
        Factory::create('Photo');
        $updatedPhotoField = ['caption' => 'Updated Photo Caption'];

        $response = $this->call('PUT', 'api/v1/photos/1', $updatedPhotoFields);
        $data = json_decode($response->getContent());

        $this->assertEquals('Photo has been updated', $data->message);
        $this->assertEquals('Updated Photo Caption', Photo::find(1)->caption);
    }

### Specifying Options ###

> Try not to use verbs within your URIs. As such:

    api/v1/photos?color=green

> is clearly a smarter choice than:

    api/v1/getGreenPhotos

> Let’s write a test that specifies a limit for the number of photos that should be returned.

    public function testCanSetALimit()
    {
        // Give a new user two photos
        Factory::create('User');
        Factory::create('Photo', ['user_id' => '1']);
        Factory::create('Photo', ['user_id' => '1']);

        // Declare a limit of 1
        $response = $this->call('GET', 'api/v1/photos?limit=1');
        $data = json_decode($response->getContent());

        // Verify that the photos array count is 1, not 2
        $this->assertCount(1, $data->photos);
    }

> To implement this type of functionality, we might write:

    //app/controller/PhotosApiController.php

    public function index()
    {
        $photos = Auth::user()->photos();
        $photos = $this->applyOptions($photos);

        return Response::json([
            'error' => false,
            'photos' => $photos->get()->toArray()
        ]);
    }

    protected function applyOptions($photos)
    {
        if ($limit = Request::get('limit'))
            $photos->take($limit);

        return $photos;
    }







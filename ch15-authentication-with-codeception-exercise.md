# Authentication With Codeception Exercise #

> acceptance tests: define the end goal for the customer

> unit tests: ensure that each component works correctly

> integration tests: verify the integration of two or more classes

## The Feature ##

> Let’s imagine that our fictional customer would like to have a new private (password-protected) administration area for their website

> user story might be:

    In order to perform administrative tasks
    As the site owner
    I want to login to a password-protected private area

## Translating the Feature for Codeception ##

> the above user story may be translated to:

    $I->am('Site Owner');
    $I->wantTo('login to a password-protected area');
    $I->lookForwardTo('perform administrative tasks');

> Below is our first test for logging in with proper credentials.

    // app/tests/acceptance/LoginCest.php
    class LoginCest {

        public function logsInUserWithProperCredentials(AcceptanceTester)
        {
            $I->am('Site Owner');
            $I->wantTo('login to a password-protected area');
            $I->lookForwardTo('perform administrative tasks');

            $I->amOnPage('/admin');
            $I->seeCurrentUrlEquals('/login');

            $I->fillField('email', 'jeffrey@envato.com');
            $I->fillField('password', '1324');
            $I->click('Login');

            $I->seeCurrentUrlEquals('/admin');
            $I->see('Admin Area', 'h1');
        }

> you could probably figure out what this code does.

1. Vist the admin page, but expect to be redirected to the login page, as it should be protected.
2. Fill out the username and password, and click the Login button
3. Expect to be redirected to ‘/admin’, and see the text, Admin Area

> Running the tests at this point:

    ---------
    1) Failed to login to a password-protected area in LoginCest::logsInUserWithProperCredentials (app/tests/acceptance/LoginCest.php)

     Step  I see current url equals "/login"
     Fail  Failed asserting that two strings are equal.--- Expected
    +++ Actual
    @@ @@
    -'/login'
    +'/admin'

    Scenario Steps:

     4. $I->seeCurrentUrlEquals("/login")
     3. $I->amOnPage("/admin")
     2. // So that I perform administrative tasks
     1. // As a Site Owner

## Register Routes ##

> According to the tests, we require two routes:

1./admin - Should be auth protected
2./login - For creating a new user session

    Route::get('admin', ['before' => 'auth', function()
    {
        // Temporary
        return '<h1>Admin Area</h1>';
    }]);

    Route::get('login', function()
    {
        return View::make('sessions.new');
    });

> run the tests again:

    ---------
    1) Failed to login to a password-protected area in LoginCest::logsInUserWithProperCredentials (app/tests/acceptance/LoginCest.php)

     Step  I fill field "email","jeffrey@envato.com"
     Fail  Form field by Label or CSS element with 'email' was not found.

    Scenario Steps:

     5. $I->fillField("email","jeffrey@envato.com")
     4. $I->seeCurrentUrlEquals("/login")
     3. $I->amOnPage("/admin")
     2. // So that I perform administrative tasks
     1. // As a Site Owner

## Building the Form ##

    <!--app/views/sessions/new.blade.php-->
    <!doctype html>

    <html>
        <head>
            <meta charset="utf-8">
            <title>Login</title>
        </head>

        <body>
            <h1>Login</h1>

            {{ Form::open() }}
                <div>
                    {{ Form::label('email', 'Email') }}
                    {{ Form::text('email') }}
                </div>

                <div>
                    {{ Form::label('password', 'Password') }}
                    {{ Form::password('password') }}
                </div>

                <div>
                    {{ Form::submit('Login') }}
                </div>
            {{ Form::close() }}
        </body>
    </html>

> run the tests again:

    ---------
    1) Failed to login to a password-protected area in LoginCest::logsInUserWithProperCredentials (app/tests/acceptance/LoginCest.php)

     Step  I see current url equals "/admin"

     Fail  Failed asserting that two strings are equal.--- Expected
    +++ Actual
    @@ @@
    -'/admin'
    +'/login'

    Scenario Steps:

     8. $I->seeCurrentUrlEquals("/admin")
     7. $I->click("Login")
     6. $I->fillField("password","1324")
     5. $I->fillField("email","jeffrey@envato.com")
     4. $I->seeCurrentUrlEquals("/login")
     3. $I->amOnPage("/admin")

## Resources ##

    php artisan controller:make SessionsController

    // app/routes.php
    Route::resource('sessions', 'SessionsController');
    
    // app/views/sessions/new.blade.php
    {{ Form::open(['method' => 'post', 'route' => 'sessions.store']) }}

## Authenticating the User ##

    php artisan migrate:make create_users_table

    // app/databases/migrations/xxxx_create_users_table.php
    class CreateUsersTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('users', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('email')->unique();
                $table->string('password');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::drop('users');
        }
    }

    // app/database/seeds/UserTableSeeder.php
    class UserTableSeeder extends Seeder {

        public function run()
        {
            $user = new User;
            $user->email = 'jeffrey@envato.com';
            $user->password = Hash::make('1234');
            $user->save();
        }

    }

## Adding a Test Database ##

Note:

[Are acceptance tests in Codeception supposed to run in testing environment? (Laravel4 + Codeception)](https://stackoverflow.com/questions/21869304/are-acceptance-tests-in-codeception-supposed-to-run-in-testing-environment-lar)

> "Acceptance" tests are not run in the testing environment. The reason is when Laravel is in the testing environment, it disables filters by default.

> testing environment is only for unit and functional tests.

So I use the "codeception" environment

    // bootstrap/start.php
    $env = $app->detectEnvironment(array(

        'codeception' => array('your-machine-hostname')

    ));

--End Note--

    // (old version)app/config/testing/database.php
    // app/config/codeception/database.php
    <?php
    return [
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'my-test-db',
                'username' => 'root',
                'password' => '1234',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => ''
            ]
        ]
    ];

    // app/codeception.yml
    modules:
        config:
            Db:
                dsn: 'mysql:host=localhost;dbname=my-test-db'
                user: 'root'
                password: '1234'
                dump: tests/_data/dump.sql

> migrate and seed this new users table:

    (old version)php artisan migrate --env="testing"
    (old version)php artisan db:seed --class=UserTableSeeder --env="testing" 

    php artisan migrate --env="codeception"
    php artisan db:seed --class=UserTableSeeder --env="codeception" 

> authenticate the user within SessionsController.

    // app/controllers/SessionsController
    public function store()
    {
        $creds = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        if (Auth::attempt($creds)) return Redirect::to('admin');
    }

> Run the tests again, and we get green!

## Invalid Credentials ##

> if incorrect credentials are specified, then the login page is reloaded, along with an Invalid Credentials error message.

    //app/tests/acceptance/LoginCest.php
    public function loginWithInvalidCredentials(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->click('Login');

        $I->seeCurrentUrlEquals('/login');
        $I->see('Invalid Credentials', '.flash');
    }

> Run the tests:

    ---------
    1) Failed to login with invalid credentials in LoginCest::loginWithInvalidCredentials (app/tests/acceptance/LoginCest.php)

     Step  I see current url equals "/login"
     Fail  Failed asserting that two strings are equal.--- Expected
    +++ Actual
    @@ @@
    -'/login'
    +'/sessions'

    Scenario Steps:

     3. $I->seeCurrentUrlEquals("/login")
     2. $I->click("Login")
     1. $I->amOnPage("/login")

> update the controller’s store method to redirect back to the login page if authentication fails.

    // app/controllers/SessionController.php
    public function store()
    {
        $creds = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        if (Auth::attempt($creds)) return Redirect::to('admin');

        return Redirect::to('login')->withInput();
    }

> Run the tests:

    ---------
    1) Failed to login with invalid credentials in LoginCest::loginWithInvalidCredentials (app/tests/acceptance/LoginCest.php)

     Step  I see "Invalid Credentials",".flash"
     Fail  Element located either by name, CSS or XPath element with '.flash' was not found.

    Scenario Steps:

     4. $I->see("Invalid Credentials",".flash")
     3. $I->seeCurrentUrlEquals("/login")
     2. $I->click("Login")
     1. $I->amOnPage("/login")

> we can flash messages when redirecting by passing a session key and value pair to the with method.

    // app/controllers/SessionController.php
    public function store()
    {
        $creds = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        if (Auth::attempt($creds)) return Redirect::to('admin');

        return Redirect::to('login')
            ->withInput()
            ->with('message', 'Invalid Credentials');;
    }

    //app/views/sessions/new.blade.php

    @if(Session::has('message'))
        <div class="flash">
            {{ Session::get('message') }}
        </div>
    @endif

> And that should do it!

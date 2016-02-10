# Ch10: Testing Controllers #

NOTE: **super important**

## Testing Controllers ##

> Controller tests should verify responses, ensure that the correct database access methods are triggered, and assert that the appropriate instance variables are sent to the view.

## What Does a Controller Do? ##

1. Direct traffic, by serving as the application’s HTTP interface.
2. Send its own messages to the domain object. As they say, controllers should tell, rather than ask (Fat Model -> Skinny Controller).

## The Hello World of Controller Testing ##

> that’s only partially true. Even though $this->call() and $this->client->request() will both call a particular route, the returned values will differ.

$crawler = $this->client->request('GET', '/'); // Symfony\Component\DomCrawler\Crawler

$response = $this->call('GET', '/'); // Illuminate\Http\Response

## Laravel’s Helper Assertions ##

- assertViewHas
- assertResponseOk
- assertRedirectedTo
- assertRedirectedToRoute
- assertRedirectedToAction
- assertSessionHas
- assertSessionHasErrors

> The following examples calls GET /posts and verifies that its views receives the variable, $posts.

public function testIndex()
{
    $this->call('GET', 'posts');

    $this->assertViewHas('posts');
}

Note: typo in p.134 in line 5 of Route::get('posts',function()

=> replace ['posts', $posts] to ['posts' => $posts]


## Mocking the Database ##

> The solution is to inject the database layer into the controller through the constructor.

Note: 

[issue "Class 'Eloquent' not found when using Mockery::mock('Eloquent', 'Post')"](https://github.com/JeffreyWay/Laravel-Testing-Decoded/issues/106)

## The IoC Container ##

> Laravel’s IoC container drastically eases the process of injecting dependencies into your classes. Each time a controller is requested, it is resolved out of the IoC container. 

    $this->app->instance('Post', $this->mock);

> Think of this code as saying, “Hey Laravel, when you need an instance of Post, I want you to use my mocked version.”

## Path ##

Note:

[issue "Input::replace not working with $this->call"](https://github.com/JeffreyWay/Laravel-Testing-Decoded/issues/112)

## Repositories ##

> To allow for optimal flexibility, rather than creating a direct link between your controller and an ORM, like Eloquent, it’s better to code to an interface.

> The considerable advantage to this approach is that, should you perhaps need to swap out Eloquent for, say, Mongo or Redis, doing so literally requires the modification of a single line. Even better, the controller doesn’t ever need to be touched.

> Repositories represent the data access layer of your application.

## Structure ##

> PSR-0 defines the mandatory requirements that must be adhered to for autoloader interoperability.

> Service providers are nothing more than bootstrap classes that can be used to do anything you wish: register a binding, hook into an event, import a routes file, etc.

## Crawling the DOM ##

> When requesting a URI with `$this->client->request()`, a Crawler object will be returned, which can then be used to filter the DOM and perform assertions.

### Ensure View Contains Text ###

    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/login');
        $h1 = $crawler->filter('h1');

        $this->assertEquals('Please Login', $h1->text());
    }

> In the example above, the assertion will only pass if the first occurrence of an <h1> tag contains Please Login.

> the assertion could be rewritten, like so:

    $h1 = $crawler->filter('h1:contains("HelloWorld!")');
    $this->assertCount(1, $h1);

### Fetch By Position ###

    $crawler->filter('h2')->eq(2);

### Fetch First or Last ###

    $crawler->filter('ul.tasks li')->first();
    $crawler->filter('ul.tasks li')->last();

### Fetch Siblings ###

    $crawler->filter('.question')->siblings();

### Fetch Children ###

    $crawler->filter('ul.tasks')->children();

### Capture Text Content ###

html example:

    <ulclass="tasks">
        <li>Go to store</li>
        <li>Finish book</li>
        <li>Eat dinner</li>
    </ul>

> extract the text content for each.

    //Call route
    $crawler=$this->client->request('GET', '/tasks');

    //Filter down to the desired list
    $items=$crawler->filter('ul.tasks li');

    //Map over of the list,and return
    //the text content for each.
    $tasks=$items->each(function($node, $i)
    {
        return $node->text();
    });

>  if we var_dump($tasks):

    array(3) {
        [0] => string(11) "Go to store",
        [1] => string(11) "Finish book",
        [2] => string(10) "Eat dinner"
    }

> rather than mapping over the list items with each(), we can instead clean things up a bit, like so:

    $items=$crawler->filter('ul.tasks li');
    $tasks=$items->extract('_text');

> If you need to grab a different attribute value from a node, simply substitute _text with its name

    $className=$node->extract('class');
    $id=$node->extract('id');
    $idAndClass=$node->extract(['id','class']);

## Forms ##

> (DomCrawler) the ability to fill out and submit forms.


    public function testRegister()
    {
        $crawler = $this->client->request('GET', '/register');

        // Find the form associated with the submit button
        // that has a value of 'Submit'
        $form = $crawler->selectButton('Submit')->form();

        // Fill out the form
        $form['first'] = 'Jeffrey';
        $form['last'] = 'Way';

        // Submit the form
        $r = $this->client->submit($form);
    }

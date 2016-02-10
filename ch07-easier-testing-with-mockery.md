# Ch07: Easier Testing With Mockery #

## Mocking Decoded ##

> A mock object: simulating the behavior of real objects.

## Mocks vs Stubs

mock: refers to the process of defining expectations and ensuring desired
behavior. mock can potentially lead to a failed test.

stub: is simply a dummy set of data that can be passed around to meet certain criteria.

## Dependency Injection ##

> injecting a class’s dependencies through its constructor method, rather than hard-coding them.

> if its instantiation is hard-coded into the class that we’re testing, there’s no easy way to replace that instance with the mocked version.

public function __construct()
{
    // anti-pttern
    $this->file = new File;
}

> allow for dependency injection:

class Generator {
    public function __construct(File $file = null)
    {
        $this->file = $file ?: new File;
    }
} 

(testing-with-mockery)

Note:

(error message)

1) GeneratorTest::testItWorks
The "Generator" class is reserved for internal use and cannot be manually instantiated

sol: replace "Generator" to another name => CustomGenerator
-------

the Mockery::close() reference within the tearDown method

> This static call cleans up the Mockery container used by the current test, and run any verification tasks needed for your expectations.

## Simple Mock Objects ##

> Mock objects needn’t always reference a class.

## Expectations ##

$mock->shouldReceive('method')->once();
$mock->shouldReceive('method')->times(1);
$mock->shouldReceive('method')->atLeast()->times(1);

$mock->shouldReceive('get')->withAnyArgs()->once();//thedefault
$mock->shouldReceive('get')->with('foo.txt')->once();
$mock->shouldReceive('put')->with('foo.txt', 'foobar')->once();

> This can be extended even further to allow for the argument values to be dynamic in nature, as long as they meet a certain.

$mock->shouldReceive('get')->with(Mockery::type('string'))->once();

> regular expression

$mockedFile->shouldReceive('put')
           ->with('/\.txt$/', Mockery::any())
           ->once();

> With this code, the expectation will only apply if the first argument to the get method is log.txt or cache.txt.

$mockedFile->shouldReceive('get')
           ->with(Mockery::anyOf('log.txt', 'cache.txt'))
           ->once();

## Partial Mocks ##

> You may find that there are situations when you only need to mock a single method, rather than the entire object.

> In this example, all methods on MyClass will behave as they normally would, excluding getOption

class MyClass {

    public function getOption($option)
    {
        return config($option);
    }

    public function fire()
    {
        $timeout = $this->getOption('timeout');
    }

}

public function testPartialMockExample()
{
    $mock = Mockery::mock('MyClass[getOption]');
    $mock->shouldReceive('getOption')
         ->once()
         ->andReturn(10000);

    $mock->fire();
}

> The previous code snippet may be rewritten as: (passive partial mocks)

public function testPassiveMockExample()
{
    $mock = Mockery::mock('MyClass')->makePartial();
    $mock->shouldReceive('getOption')
         ->once()
         ->andReturn(10000);

    $mock->fire();
}

> Should you have multiple methods, simply separate them by a comma, like so:

$mock = Mockery::mock('MyClass[method1, method2]');

## Hamcrest ##

> install davedevelopment/hamcrest-php

> you may use a more human-readable notation to define your tests.

assertThat($name, is('Jeffrey'));
assertThat($name, is(not('Joe')));

assertThat($age, is(greaterThan(20)));
assertThat($age, greaterThan(20));

assertThat($age, is(integerValue()));

assertThat(new Foo, is(anInstanceOf('Foo')));

assertThat($hobbies, is(arrayValue()));
assertThat($hobbies, is(arrayValue()));

assertThat($hobbies, hasKey('coding'));

> The use of the is() function is nothing more than syntactic sugar to aid in readability.





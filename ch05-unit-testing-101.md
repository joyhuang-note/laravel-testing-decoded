# Ch05: Unit Testing 101 #

## Unit Testing ##

### Arrange, Act, Assert (in TDD) ###

1. Arrange: Set the stage, instantiate objects, pass in mocks.
2. Act: Execute the thing that you wish to test.
3. Assert: Compare your expected output to what was returned.

```
public function testFetchesItemsInArrayUntilKey()
{
    // Arrange
    $names = ['Taylor', 'Dayle', 'Matthew', 'Shawn', 'Neil'];

    // Act
    $result = array_until('Matthew', $names);

    // Assert
    $expected = ['Taylor', 'Dayle'];
    $this->assertEquals($expected, $result);
}
```

### Given, When, Then (in BDD) ###

`Given` this set of data, `when` I perform this action, `then` I expect that response.

```
/**
 * @expectedException InvalidArgumentException
 */
public function testThrowsExceptionIfKeyDoesNotExist()
{
    // Given this set of data
    $names = ['Taylor', 'Dayle', 'Matthew', 'Shawn', 'Neil'];

    // When I call the until function and
    // specify a different key
    $result = array_until('Bob', $names);

    // Then an exception should be thrown (see doc-block)
}
```

## Testing in Isolation ##

> This means that all outside dependencies which aren’t directly related to the thing that you’re attempting to test should be stubbed or mocked

> For example, when unit testing a model, you shouldn’t, in the process, be hitting the database. You shouldn’t hit a web service. You shouldn’t even reference one of your other classes.

## Tests Should Not Be Order-Dependent ##

> For example, beginning developers will often set state in one test, and then continue to depend upon that same state for assertions in future tests.

## Test-Driven Development ##

> Test-Driven Development is an agile software pattern in which a developer prepares a test before a single line of production code is written.

1. Write a Failing Test: You may not write a single line of production code unless a failing test is present.
2. Make it Pass: Once a test has been defined, you may only write the minimum amount of code to make the test pass - even if this means faking a method’s return value. Approach each failing test from the perspective of, “what is the simplest way to make this test pass?”
3. Refactor: Only when the tests have passed (they return green) may you refactor your code.

## Behavior-Driven Development ##

> With this style of coding, you describe how the SUT (system under test) should behave.


## Test Functions ##

(see app/tests/PracticeTest.php)

## Slime vs. Generalize

Slime: returning a dummy value for the sole purpose of making a test pass. (faking it.)

sliming is temporary.

## Making the Test Pass ##

p.59

issus: [link_to test (Chapter 5)](https://github.com/JeffreyWay/Laravel-Testing-Decoded/issues/24)

p.60

Notice: extends TestCase.

```
class PracticeTest extends TestCase {
```

Error message:

```
PHP Fatal error:  Call to a member function make() on null in {/path/}vendor/laravel/framework/src/Illuminate/Support/helpers.php on line 31
```

=> (use Laravel TestCase)
=> create laravel project

$ composer create-project laravel/laravel laravel-test 4.2 --prefer-dist

## Testing Classes ##

(framework-agnostic)

(see Calculator.php)

p.69

> Tip: When you find yourself copying and pasting code from one method to another, this is a tell-tale sign that refactoring is required.


## Refactoring the Tests ##

Same things are better extracted to the setUp method, which will fire before each test runs.

## Refactoring the Production Code ##

## Polymorphism ##

> It would be better if the class could call a method that performs the arithmetic, without having to be concerned over how that operation is performed. This is where polymorphism comes into play.

## Mocks ##

> Tip: An added bonus to using mocks in situations such as this is that they allow you to drastically reduce the number of tests. When mocking the operation class, we no longer need tests in CalculatorTest for verifying addition, subtraction, multiplication, etc. Each of those implementations will have its own tests.

    public function testAddsNumber()
    {
        $mock = Mockery::mock('Addition');

        $mock->shouldReceive('run')
             ->once()
             ->with(5, 0)
             ->andReturn(5);

        $this->calc->setOperands(5);
        $this->calc->setOperation($moc);

        $result = $this->calc->calculate();

        $this->assertEquals(5, $result);
    }

## Project Complete ##

> When building testable applications, I want you to break each class down to its core responsibility.

> Not only does this approach allow for cleaner and more extensible code, but it also makes the process of testing significantly easier.

> The smaller the class, the easier it is to test.



# Ch02: Introducing PHPUnit #

p.18
—-----
phpunit tests
phpunit --colors tests

p.28
—-----
## assertTrue ##

$greeting = 'Hello, World.';
$this->assertTrue($greeting == 'Hello, World.', $greeting);

> $this->assertTrue(ACTUAL, OPTIONAL MESSAGE);

## assertEquals ##

$greeting = 'Hello, World.';
$this->assertEquals('Hello, World.', $greeting);

> $this->assertEquals(EXPECTED, ACTUAL, OPTIONAL MESSAGE);

## assertSame ##

> compare with strict equality

ex.
$val = null;
$this->assertEquals(0, $val); //true

$val = null;
$this->assertSame(0, $val); //false

$val = 0;
$this->assertSame(0, $val); //true

## assertContains ##

> prove that the array contains a specific value.

$names = ['Taylor', 'Shawn', 'Dayle'];
$this->assertContains('Dayle', $names); // true

> $this->assertContains(NEEDLE, HAYSTACK, OPTIONAL MESSAGE);

## assertArrayHasKey ##

$family = [
    'parents' => 'Joe',
    'children' => ['Timmy', 'Suzy']
];

$this->assertContains('parents', $family); // Failed asserting that an array contains 'parents'.

$this->assertArrayHasKey('parents', $family); // true

## assertInternalType ##

$family = [
    'parents' => 'Joe',
    'children' => ['Timmy', 'Suzy']
];

$this->assertInternalType('array', $family['parents']); // false

$this->assertInternalType('string', $family['parents']); // true

## assertInstanceOf ##

> ensure that a variable is an instance of some class.

class DateFormatter {
    protected $stamp;

    public function __construct(DateTime $stamp)
    {
        $this->stamp = $stamp;
    }

    public function getStamp() {
        return $this->stamp;
    }
}

public function testStampMustBeInstanceOfDateTime() {
    $date = new DateFormatter(new DateTime);

    $this->assertInstanceOf('DateTime', $date->getStamp());
}

## Asserting Exceptions ##

/**
 * @expectedException InvalidArgumentException
 */
public function testCalculatesCommission()
{
    $commission = new Commission;
    $commission->setSalePrice('fifteen dollars'); // thrown an exception if a non-numeric value is passed.
}

> use doc-blocks to assert exceptions
> /**
   * @expectedException EXCEPTION_NAME
   */




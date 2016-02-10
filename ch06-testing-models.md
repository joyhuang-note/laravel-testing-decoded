# Ch06: Testing Models #

## What to Test ##

- Validations
- Scopes
- Accessors and Mutators
- Associations/Relationships
- Custom Methods

## Accessors and Mutators ##

// Accessor
public function getAgeAttribute($age) {}

// Mutator
public function setAgeAttribute($age) {}

## Password Hashing Example ##

// User.php
class User extends Eloquent {
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}

// UserTest.php
public function testHashesPasswordWhenSet
{
    Hash::shouldReceive('make')->once()->andReturn('hashed');

    $author = new Author;
    $author->password = 'foo';

    $this->assertEquals('hashed', $author->password);
}

> "I expect the make method on the Hash class to be triggered one time. When this occurs,
rather than calling the original method, I’ll just return the string, hashed."

This technique offers three advantages:

1. We continue testing in complete isolation from external objects.
2. If the mutator does not call Hash::make, the expectation will fail, and we’ll be notified immediately upon running phpunit.
3. Testing Hash::make can be tricky, because its return value will be somewhat random.

p.88
------

// app/models/BaseModel.php

static::$rules

=> php.net/manual/en/language.oop5.late-static-bindings.php

p.91
------

// app/database/migrations/2016_01_14_062059_create_authors_table.php

        Schema::create('authors', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });

## Helpers ##

trait: http://php.net/manual/en/language.oop5.traits.php

## Factories ##

install way/laravel-test-helpers

> dynamically building the attributes for a model

Factory::author();

> create an object with all of the necessary fields, and insert it into the DB

Factory::create('author');

Note:

.PHP Fatal error:  Class 'Doctrine\DBAL\Driver\PDOMySql\Driver' not found in {path}/vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php on line 59

=> install doctrine/dbal



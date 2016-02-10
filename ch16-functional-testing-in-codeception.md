# Functional Testing in Codeception #

> functional tests is nearly identical to acceptance testing

> There are only two core differences

1. Functional tests don’t require a server to execute. This can provide a performance boost. Instead, requests and responses will be emulated.
2. Functional tests provide better output for debugging. Rather than noting that a scenario step failed, functional tests will display the exception message directly in the console.

## The Laravel4 Module ##

> The Laravel4 module may be enabled by editing functional.suite.yml. By default, this file will include the Filesystem and TestHelper modules.

    // old version
    class_name:TestGuy
    modules:
        enabled: [Filesystem, TestHelper, Laravel4, Db]

    // new version
    class_name: FunctionalTester
    modules:
        enabled:
            # add framework module here
            - \Helper\Functional
            - Laravel4
            - Db

## The DB Module ##

> edit the global configuration file - codeception.yml - and provide your database credentials within the DB configuration block.

> The DB module’s core responsibility is to clean up the database after each test.

> To populate your database, Codeception requires a raw SQL dump.

    mysqldump --opt--user="USERNAME" --password="PASSWORD"DBNAME > app/tests/_data/dump.sql

## Updating TestGuy ##

> Any time that you add or remove a module from a suite, re-run the build command.

    codecept build

## Registering a User ##

> using functional testing, let’s write a test for registering a new user.

> This test should walk through the process of visiting the /register page, filling out the form, and then verifying whether the new user was saved to the database.

    codecept generate:cept functional Registration

    <?php // app/tests/functional/RegistrationCept.php

    $I = newTestGuy($scenario);
    $I->wantTo('register for a new account');
    $I->lookForwardTo('be a member');

    $I->amOnPage('/register');
    $I->see('Register','h1');
    $I->fillField('Email:', 'joe@sample.com');
    $I->fillField('Password:','1234');
    $I->click('Register Now');

    $I->seeCurrentUrlEquals('/login');
    $I->see('You may now signin!', '.flash');
    $I->seeInDatabase('users', ['email' => 'joe@sample.com']);

> Did you notice that last method, seeInDatabase? This references some of the sugar that the Db module provided.

> Don’t forget that, for each test, the database will be refreshed.

> for the life of this application, we will have a test that verifies whether or not the registration process works as we expect it to.


**Trouble shooting**

    ---------
    1) Failed to register for a new account in RegistrationCept (app/tests/functional/RegistrationCept.php)

     Step  I see in database "users",{"email":"joe@sample.com"}
     Fail  No matching records found for criteria {"email":"joe@sample.com"} in table users
    Failed asserting that 0 is greater than 0.

    Scenario Steps:

     9. $I->seeInDatabase("users",{"email":"joe@sample.com"})
     8. $I->see("You may now sign in!",".flash")

=> 實際網頁操作是可以寫入資料庫的
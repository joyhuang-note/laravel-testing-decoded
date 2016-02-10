# Ch03: Configuring PHPUnit #

p.38
------
## XML Configuration File ##

<phpunit bootstrap="vendor/autoload.php"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         stopOnFailure="true">
        <testsuites>
            <testsuite name="Test Suite">
                <directory>tests</directory>
            </testsuite>
            <testsuite name="Integration">
                <directory>tests/integration</directory>
            </testsuite>
        </testsuites>
</phpunit>

> To execute only the tests referenced in the “Integration” test suite, run:

$ phpunit --testsuite="Integration"

p.40
------
## Continuous Testing ##

> using Guard to handle your continuous testing needs, along with the notification tool that best suits your needs and OS

$ gem install guard
$ gem install guard-phpunit
$ gem install rb-fsevent
$ gem install terminal-notifier-guard

(may be modified)

> Initialize Guard for your application by running:

$ guild init

(see Guardfile)

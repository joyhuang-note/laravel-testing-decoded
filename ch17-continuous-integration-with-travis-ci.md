# Continuous Integration With Travis CI #

> continuous integration is the process of frequently (even multiple times a day) merging (or integrating) your local source revisions in an attempt to avoid what we refer to as integration hell. Each integration is then verified by an automated build server, like Travis or Jenkins. This cycle can help to prevent compatibility issues.

> 5. a CI server will automatically build the project again (in an environment
that’s as close to production as possible) and trigger all of the tests. If the tests pass, you’ve successfully integrated.

> think of it is as the teacher who checks over your work.


## Hello, Travis ##

3. Configure

> How can it run your tests, if it doesn’t know which language, version, and tools it was built with? Further, some applications may require a test database, setup work, and more. All of this can be declared within a **travis.yml** file

> Here’s the absolute essentials for a basic PHP project that is dependent upon Composer.

    language: php

    php:
        -5.4
        -5.3

    before_script:
        - curl -s http://getcomposer.org/installer | php
        - php composer.phar install --dev

    script: phpunit

> This file makes a handful of declarations:

1. Which language are we working with?
2. Which versions of that language must this project be tested against?
3. Anything we need to do before running the tests?
4. Which test script should be used?


## Build Configuration ##

### Absolute Basics ###

    language: php
    php:
        -5.4
        -5.2

### Register Dependencies ###

    before_script:
        - curl -s http://getcomposer.org/installer | php
        - php composer.phar install --dev

> Maybe you have a dedicated shell script that will install or prepare various dependencies. That, too, should be added to before_script.

    before_script:
        - ./bin/setup-dependencies.sh

> Anything that you would write in the Terminal may be used here. Perhaps you need to execute an Artisan command first:

    before_script:
        - curl -s http://getcomposer.org/installer | php
        - php composer.phar install --dev
        - php artisan migrate --seed

### Notifications ###

> Turn Off Notifications

    notifications:
        email: false

> Set Recipients

notifications:
    email:
        - devmanager@example.com
        - logs@example.com
        - steve-micromanager@example.com

> IRC

notifications:
  irc:
    - "chat.freenode.net#laravel"

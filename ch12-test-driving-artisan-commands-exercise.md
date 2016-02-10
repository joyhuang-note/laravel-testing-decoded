# Ch12: Test-Driving Artisan Commands Exercise #

## Testing Artisan Commands ##

> Open the package’s composer.json file (not the master composer.json file), and update the require objects, like so:

    "require": {
        "php": ">=5.3.0",
        "illuminate/support": "4.0.x",
        "illuminate/console": "4.0.x"
    },
    "require-dev": {
        "mockery/mockery": "dev-master"
    }

## Summary ##

> we leveraged Symfony’s Console component to build a model generator with tests.

> Testing console output can be a bit tricky, but, luckily, the Symfony team already considered this, and included a CommandTester class to ease the process considerably.

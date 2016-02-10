# Ch11: The IoC Container #

## Interfaces ##

    App::bind('OrderRepositoryInterface', 'EloquentOrderRepository');

> this line of code is identical to:

    App::bind('OrderRepositoryInterface', function() {
        return new EloquentOrderRepository;
    });

> When resolving an object through the IoC container, Laravel will attempt to read the constructor’s type-hints and automatically inject the instance for you.

> Consider the following constructor:

    class UsersController {
        public function __construct(UserRepository $user, Validator $validator)
        {

        }
    }

> Laravel will detect that instances of both UserRepository and Validator are required. It will then instantiate and inject them automagically!

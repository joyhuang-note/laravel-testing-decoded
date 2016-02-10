# Ch09: Just Swap That Thang #

## Mockery ##

(testing-with-laravel-facade-support)

> Every Laravel facade extends a parent Facade class that offers, among other things, a shouldReceive method. When called, Laravel will automatically swap out the registered instance with a mock, using Mockery.

> Even though the route’s callback calls File::put(), we can override the resolved instance of the Filesystem class and replace it with a mocked version - all by simply writing File::shouldReceive().
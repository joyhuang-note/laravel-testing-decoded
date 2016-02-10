<!doctype html>

<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
    </head>

    <body>
        @if(Session::has('message'))
            <div class="flash">
                {{ Session::get('message') }}
            </div>
        @endif
        <h1>Login</h1>
        {{ Form::open(['method' => 'post', 'route' => 'sessions.store']) }}
            <div>
                {{ Form::label('email', 'Email') }}
                {{ Form::text('email') }}
            </div>

            <div>
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password') }}
            </div>

            <div>
                {{ Form::submit('Login') }}
            </div>
        {{ Form::close() }}
    </body>
</html>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>

    @if (Session::has('message'))
        <div class="flash">
            {{ Session::get('message') }}
        </div>
    @endif

    {{ Form::open() }}
        {{ Form::label('email', 'Email:') }}
        {{ Form::text('email') }}

        {{ Form::label('password', 'Password:') }}
        {{ Form::text('password') }}

        {{ Form::submit('Register Now') }}
    {{ Form::close() }}
</body>
</html>
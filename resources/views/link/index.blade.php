<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->

        <!-- Styles -->
        <style>
        </style>
    </head>
    <body class="antialiased">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <form action="/create" method="post">
                @csrf

                <label for="input-link"></label>
                <input id="input-link" name="original_url" type="text" placeholder="url"/>
                <input id="input-expired-at" name="expired_at" type="datetime-local"/>
                <input type="submit" value="add link"/>
            </form>

            <form action="/statistic" method="get">
                @csrf

                <label for="input-link"></label>
                <input id="input-link" name="short_url" type="text" placeholder="shorted url"/>
                <input type="submit" value="show statistic">
            </form>
        </div>
    </body>
</html>

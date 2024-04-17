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
        <div>
            <form action="/create" method="post">
                @csrf

                <label for="input-link"></label>
                <input id="input-link" name="original_url" type="text" placeholder="url"/>
                <input id="input-expired-at" name="expired_at" type="datetime-local"/>
                <input type="submit"/>
            </form>
        </div>
    </body>
</html>

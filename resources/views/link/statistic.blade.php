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
            <p>Original link: {{ $original_url }}</p>
            <p>Short link: {{ $short_url }}</p>
            <p>Expired at: {{ $expired_at }}</p>
            <p>Count: {{ $used_count }}</p>
        </div>
    </body>
</html>

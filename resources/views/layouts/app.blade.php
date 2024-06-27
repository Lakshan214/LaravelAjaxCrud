
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('libraries.styles')
    
    <title>ajax-crud!</title>
</head>

<body>

<body>

    <div>


        <main>
            @yield('content')
        </main>

    </div>

    @include('libraries.script')

</body>

</html>

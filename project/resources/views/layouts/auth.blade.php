<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - VitaGuard</title>

    <link rel="stylesheet" href="{{ asset('css/loginTemplate/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loginTemplate/style.css') }}">
</head>
</head>

<body>
    @yield('content')
 
    <script src="{{ asset('js/loginTemplate/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/loginTemplate/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/loginTemplate/main.js') }}"></script>
    
    @yield('scripts')
</body>

</html>
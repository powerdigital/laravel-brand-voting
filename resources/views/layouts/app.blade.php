<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="HR Brand Crimea - первая премия за лучший бренд компании-работодателя в Крыму">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>{{env('APP_TITLE')}}</title>

    <link href="{{asset('/css/app.css')}}" rel="stylesheet">
</head>
<body>
<header id="header"></header>

<main role="main">
    @yield('content')
</main>

<footer class="py-5 bg-dark" id="footer"></footer>
<script src="{{asset('/js/app.js')}}"></script>
</body>
</html>

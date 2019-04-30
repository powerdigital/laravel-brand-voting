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
<header id="header">
    <div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex justify-content-between">
                <a href="/" class="navbar-brand d-flex align-items-center">
                    <span class="logo"></span>
                </a>
            </div>
        </div>
        <div class="bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-8 py-2">
                        <p class="text-white">HR Brand Crimea - первая премия за лучший бренд
                            компании-работодателя в Крыму.</p>
                        <button type="button" class="conditions btn btn-sm btn-primary" data-toggle="modal"
                                data-target=".bd-example-modal-lg">Условия конкурса
                        </button>
                    </div>
                    <div class="col-sm-4 py-2">
                        <h4 class="text-orange">Контакты</h4>
                        <ul class="list-unstyled">
                            <li><a href="tel:+79785555555" class="text-white">+7 978 555-55-55</a></li>
                            <li><a href="http://hrdaycrimea.ru" class="text-white"
                                   target="_blank">Организаторы</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main role="main">
    <div id="main"></div>
    @yield('content')
</main>

<footer class="py-5 bg-dark" id="footer">
    <div class="container">
        <p class="m-0 text-center text-white">ПРЕМИЯ HR BRAND CRIMEA &copy; 2019</p>
    </div>
</footer>
<script src="{{asset('/js/app.js')}}"></script>
</body>
</html>

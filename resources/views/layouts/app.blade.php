<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="HR Brand Crimea - первая премия за лучший бренд компании-работодателя в Крыму">

    <title>Премия "Лучший работодатель Крыма 2019"</title>

    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
<header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                <strong>HR Brand Crimea</strong>
            </a>
        </div>
    </div>
    <div class="bg-dark" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-8 py-2">
                    <h4 class="text-orange">О премии</h4>
                    <p class="text-white">HR Brand Crimea - первая премия за лучший бренд компании-работодателя в Крыму. Премия проводится с целью определения компаний с наиболее эффективной и лояльной системой управления.</p>
                    <button type="button" class="conditions btn btn-sm btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Условия конкурса</button>
                </div>
                <div class="col-sm-4 py-2">
                    <h4 class="text-orange">Контакты</h4>
                    <ul class="list-unstyled">
                        <li><a href="tel:+79785555555" class="text-white">+7 978 555-55-55</a></li>
                        <li><a href="http://hrdaycrimea.ru" class="text-white" target="_blank">Организаторы</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<main role="main">
    @yield('content')
</main>

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">ПРЕМИЯ HR BRAND CRIMEA &copy; 2019</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

</body>
</html>

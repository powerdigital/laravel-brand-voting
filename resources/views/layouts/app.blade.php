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

@if('local' === App::environment() && Auth::check())
    <div class="text-right py-1 mr-1">
        <a href="{{ route('logout') }}" class="btn btn-sm btn-primary"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Выход') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
@endguest

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
                        <p class="text-white">
                            Приглашаем вас проголосовать за лучших работодателей Крыма. Вы можете выбрать до трёх
                            компаний в каждой категории. Регистрация по телефону бесплатна. Голосование продлится до 17
                            мая.
                        </p>
                    </div>
                    <div class="col-sm-4 py-2">
                        <button type="button" class="conditions btn btn-primary" data-toggle="modal"
                                data-target=".bd-example-modal-lg">Условия конкурса
                        </button>
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
        <div class="col-5" style="margin-top: -20px">
            <div class="float-left">
                <a href="http://hrdaycrimea.ru/" target="_blank" rel="nofollow">
                    <div class="logo-footer"></div>
                </a>
            </div>
            <div class="float-left">
                <ul class="organizers m-0 p-0">
                    <li class="text-white">Организаторы</li>
                    <li class="text-white">Премия HR Brand Crimea &copy; 2019</li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="{{asset('/js/app.js')}}"></script>
</body>
</html>

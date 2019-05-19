@extends('layouts.app')

@section('content')
    <div class="categories">
        <a class="btn btn-sm btn-primary mb-1" href="/">Все</a>
        @foreach($categories as $index => $category)
            * <a class="btn btn-sm btn-primary mb-1 @if($categoryId === $index) {{'active'}} @endif"
                 href="/category/{{$index}}">{{$category}}</a>
        @endforeach
    </div>

    <div class="album py-5 bg-light">
        <div class="text-justify m-3 m-lg-5 text-dark font-weight-bold" style="font-size: 1.2rem">
            <p class="text-center">Уважаемые номинанты Премии HR BRAND Crimea 2019,</p>
            <p>благодарим Вас за участие и активность, которую каждый из вас проявил в привлечении внимания ваших
                сотрудников, клиентов и партнеров к процессу голосования.</p>
            <p>В настоящий момент оргкомитет проводит детальный анализ данных голосования, чтобы принять максимально
                объективные и взвешенные решения по результатам в каждой категории. В целях принятия справедливых
                решений и в рамках действующих правил Премии, оргкомитет сохраняет за собой право на проверку данных
                голосования путем технического анализа зарегистрированных голосов и в случае выявления недобросовестных
                методов сбора голосов может принимать решения, включая дисквалификацию номинанта.</p>
            <p>Также оргкомитет может сделать запрос дополнительной информации и документов по соответствию номинанта
                базовым требованиям привлекательного работодателя.</p>
            <p>Финальная информация о победителях в каждой категории Премии будет размещена на сайте Премии до 22 мая
                2019 года, а Победители будут приглашены на торжественную церемонию награждения 24 мая 2019 г.</p>
        </div>

        <div class="container">
            <div class="row">
                @if(count($companies))
                    @foreach($companies as $company)
                        <div class="col-md-4 mb-2 company" data-company-id="{{$company['id']}}">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-img text-center align-middle">
                                    <img src="/images/{{$company['logo']}}.png" alt="{{$company['name']}}">
                                </div>
                                <div class="card-body">
                                    <div class="card-left col-9 float-left">
                                        <ul>
                                            <li class="company-name">{{$company['name']}}</li>
                                            <li class="company-category">
                                                <small>{{$categories[$company['category_id']]}}</small>
                                            </li>
                                            <li class="company-desc">
                                                <small>{{$company['description']}}</small>
                                            </li>
                                            <li class="company-details">
                                                <a href="#" class="company-details-link">Подробнее...</a>
                                                <div class="d-none"></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-right col-3 float-left">
                                        <div class="score">
                                            <span class="text-primary text-weight-bold">
                                                {{$company['votes']}}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <div class="like"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3 class="text-dark pl-1 pr-1 text-center">
                        В данный момент в текущей категории нет ни одной компании
                    </h3>
                @endif
            </div>
        </div>
    </div>

    {{--    <nav aria-label="Page navigation" class="pagination-block">--}}
    {{--        {{$pagination->links()}}--}}
    {{--    </nav>--}}

    @include('modals.attention')
    @include('modals.conditions')
    @include('modals.company')
    @include('modals.auth')
    @include('modals.code')
    @include('modals.message')

@endsection

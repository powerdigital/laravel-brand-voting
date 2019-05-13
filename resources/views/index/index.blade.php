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
                                                <!--  data-toggle="modal" data-target="#authModal" -->
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

    @include('modals.conditions')
    @include('modals.company')
    @include('modals.auth')
    @include('modals.code')
    @include('modals.message')

@endsection

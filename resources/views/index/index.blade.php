@extends('layouts.app')

@section('content')
    <div class="categories">
        <a href="/">Все</a>
        @foreach($categories as $index => $category)
            * <a href="/category/{{$index}}">{{$category}}</a>
        @endforeach
    </div>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                @if(count($companies))
                    @foreach($companies as $company)
                        <div class="col-md-4 mb-2 company">
                            <div class="card mb-4 shadow-sm">
                                <img src="/img/{{$company['logo']}}.jpg" alt="fiolent">
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
                                                <a href="" data-toggle="modal"
                                                   data-target="#companyModal">Подробнее...</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-right col-3 float-left">
                                        <div class="score">
                                            <span class="text-primary text-weight-bold">
                                                {{isset($votes[$company['id']]) ?? 0}}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <div class="like" data-toggle="modal" data-target="#authModal"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3 class="text-dark">В данный момент в текущей категории нет ни одной компании</h3>
                @endif
            </div>
        </div>
    </div>

    <nav aria-label="Page navigation" class="pagination-block">
        {{$pagination->links()}}
    </nav>

    @include('index._modals')
@endsection

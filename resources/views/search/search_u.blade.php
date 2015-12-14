@extends('layouts.master')

@section('content')

    <div id="main-wrapper">
        <div class="wrapper style1">
            <div class="inner">
                <div class="container">
                    <div id="content">
                        <article class="box excerpt">
                            <header class="major">
                                <h2> Поиск пользователей
                                    <a style="font-size: 15px; margin-left:550px" class="button" href="/search/movies">Поиск
                                        фильмов</a>
                                </h2>
                            </header>


                            @yield('filter')
                        </article>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@extends('layouts.master')

@section('content')

    <div id="main-wrapper">
        <div class="wrapper style1">
            <div class="inner">
                <div class="container">
                    <div id="content">
                        <article class="box excerpt">
                            <header class="major">
                                <h2><a style="text-align: right" href="/search/users">Поиск пользователей</a>
                                    | Поиск фильмов</h2>
                            </header>


                            @yield('filter')
                        </article>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
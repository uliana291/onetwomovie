@extends('layouts.master')

@section('content')


        <!-- Main Wrapper -->
<div id="main-wrapper">
    <div class="wrapper style1">
        <div class="inner">
            <div class="container">
                <div id="content">

                    <!-- Content -->

                    <article class="box excerpt">
                        <header class="major">
                            <h2>Информация о сеансе</h2>
                        </header>

                        {!! Form::open() !!}


                        @include('errors.error')


                        <div>
                            <label style="font-size: medium">
                                Вы приглашены на фильм
                                <a href="/search/movie/{{ $seance->movie_id }}">{{ $seance->getMovie->title }}</a>
                                в кинотеатр
                                <a href="/search/cinema/{{ $seance->cinema_id }}">{{ $seance->getCinema->title }}</a>.
                                <div>Дата: {{ \App\Helper::russian_date($seance->date) }}, {{ $seance->time }}</div>
                            </label>
                            <div>
                                <button name="calendar" class="button">Добавить в календарь</button>
                                <input name="seanceHidden" type="hidden" value="{{ $seance->id }}"/>
                            </div>
                        </div>


                        {!! Form::close() !!}

                    </article>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
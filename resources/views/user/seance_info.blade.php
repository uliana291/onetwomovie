@extends('layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Информация о сеансе</div>
                    <div class="panel-body" style="padding:10px 40px;">

                        {!! Form::open(array('class' => 'form-horizontal')) !!}


                        @include('errors.error')


                        <div class="form-group">
                            <div class="row">
                                Вы приглашены на фильм
                                <a href="/search/movie/{{ $seance->movie_id }}">{{ $seance->getMovie->title }}</a>
                                в кинотеатр
                                <a href="/search/cinema/{{ $seance->cinema_id }}">{{ $seance->getCinema->title }}</a>.
                                <div>Дата: {{ \App\Helper::russian_date($seance->date) }}, {{ $seance->time }}</div>
                            </div>
                            <div class="row">
                                <button name="calendar" class="btn bg-primary">Добавить в календарь</button>
                                <input name="seanceHidden" type="hidden" value="{{ $seance->id }}"/>
                            </div>
                        </div>


                        {!! Form::close() !!}

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
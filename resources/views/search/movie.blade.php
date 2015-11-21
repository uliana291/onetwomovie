@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Информация о фильме</div>
                    <div class="panel-body" style="padding:10px 40px;">

                        {!! Form::open(array('class' => 'form-horizontal')) !!}

                        @include('errors.error')
                        <div>
                            <h3>{{ $movie->title }} {{ ($movie->original_title <> null? ("/ ".$movie->original_title)  : "") }}</h3>

                            <img src="/api/getPoster/{{$movie->poster}}" alt="Постер">

                        </div>

                        <hr>

                        <div>Длительность: {{ $movie->duration }} мин</div>

                        <div>Год: {{ $movie->production_year }}</div>


                        <div>
                            Жанры:
                            @foreach($genres as $genre)
                                {{ $genre . ($genre === end($genres) ? " " : ", ") }}
                            @endforeach
                        </div>

                        <div>Возраст: {{ $movie->age_restriction }}</div>

                        @if ($movie->rating <> 0)
                            <div>Рейтинг: {{$movie->rating}}</div>
                        @endif

                        @if ($images <> [])
                            <hr>
                            <div>
                                Кадры из фильма:
                                <div>
                                    @foreach($images as $image)
                                        <img src="/api/getPoster/{{$image}}" alt="Постер">

                                    @endforeach
                                </div>
                            </div>
                        @endif


                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
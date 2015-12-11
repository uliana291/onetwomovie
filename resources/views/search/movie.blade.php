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
                            <h2>Информация о фильме</h2>
                        </header>

                        {!! Form::open() !!}

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
                    </article>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
    @extends('search.search_f')

@section('filter')


    {!! Form::open(array('method'=>'GET')) !!}

    @include('errors.error')

    <div class="row">
        <div class="1u 12u(mobile)" style="text-align: right; ">
            {!!  Form::label('city_id', 'Город') !!}
        </div>
        <div class="3u 12u(mobile)">
            {!!  Form::select('city_id', $cityList , $city) !!}
        </div>
        <div class="8u 12u(mobile)">
        </div>
    </div>

    @if(count($movies) == 0)
        <hr>
        <label>В Вашем городе, к сожалению, фильмов не найдено :(</label>

    @else
        @foreach($movies as $key => $value)

            <hr>

            <div class="row">
                <div class="4u 12u(mobile)" style="text-align: left; ">
                    <label>{!! link_to("/search/movie/".$value['id'], $value['title'])  !!}</label>
                    <div>
                        <img src="/api/getPoster/{{$value['poster']}}" alt="Постер">
                    </div>
                </div>
                <div class="1u 12u(mobile)" style="text-align: center">
                    {!! Form::label('age_restriction', $value['age_restriction'])  !!}
                </div>
                <div class="7u 12u(mobile)">
                    <label>{!! link_to("/search/movie/".$value['id']."/cinemas/".$city, "Хочу пойти..")  !!}</label>
                </div>
            </div>

        @endforeach
    @endif


    {!! Form::close() !!}

@endsection
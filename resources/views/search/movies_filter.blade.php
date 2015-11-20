@extends('search.search_f')

@section('filter')


    {!! Form::open(array('class' => 'form-horizontal', 'method'=>'GET')) !!}

    @include('errors.error')

    <div class="form-group">
        <div class="row">
            <div class="col-md-3" style="text-align: right; ">
                {!!  Form::label('city_id', 'Город', array('class' => 'control-label')) !!}
            </div>
            <div class="col-md-9">
                {!!  Form::select('city_id', $cityList , $city, array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>

    <hr>

    @foreach($movies as $key => $value)

        <div class="form-group">
            <div class="row">
                <div class="col-md-3" style="text-align: right; ">
                    {!! link_to("/search/movie/".$value['id'], $value['title'], array('class' => 'control-label'))  !!}
                </div>
                <div class="col-md-4">
                    <img src="/api/getPoster/{{$value['poster']}}" alt="Постер">
                </div>
                <div class="col-md-1">
                    {!! Form::label('rating', ($value['rating'] == null? "-" : $value['rating'] ), array('class' => 'control-label'))  !!}
                </div>
                <div class="col-md-1" style="text-align: center">
                    {!! Form::label('age_restriction', $value['age_restriction'], array('class' => 'control-label'))  !!}
                </div>
                <div class="col-md-3">
                    {!! link_to("/search/movie/".$value['id']."/cinemas/".$city, "Хочу пойти..", array('class' => 'control-label'))  !!}
                </div>
            </div>
        </div>


    @endforeach


    {!! Form::close() !!}

@endsection
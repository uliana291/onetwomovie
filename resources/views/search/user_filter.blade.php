@extends('search.search_u')

@section('filter')


    {!! Form::open(array('class' => 'form-horizontal', 'method'=>'GET')) !!}

    @include('errors.error')

    <div class="form-group">
        <div class="row">
            <div class="col-md-3" style="text-align: right; ">
                Пол
            </div>
            <div class="col-md-9">
                {!!  Form::select('gender', array(null =>'любой','male' => 'М', 'female' => 'Ж'), $gender, array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-3" style="text-align: right; ">
                Город
            </div>
            <div class="col-md-9">
                {!!  Form::select('city_id', $cityList, $city_id, array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-3" style="text-align: right; ">
                Возраст
            </div>
            <div class="col-md-4">
                {!!  Form::number('age_from', $age_from, array('class' => 'form-control')) !!}
            </div>
            <div class="col-md-1" style="text-align: center">
                -
            </div>
            <div class="col-md-4">
                {!!  Form::number('age_to', $age_to,  array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div style="text-align: right; ">
                <button type="submit" class="btn btn-primary"
                        style="margin-right: 15px; width: 150px;">
                    Поиск
                </button>
            </div>
        </div>
    </div>

    @foreach($users as $key => $value)

    <div class="form-group">
        <div class="row">
            <div class="col-md-3" style="text-align: right; ">
                {!! Form::label('user_name', $value->name, array('class' => 'control-label'))  !!}
            </div>
            <div class="col-md-4">
                <img src="/api/getImage/{{$value->id}}-50x50.jpg" alt="Фото профиля">
            </div>
            <div class="col-md-1">
                {!! Form::label('user_gender', ($value->gender == 'female'? 'Ж' : 'М'), array('class' => 'control-label'))  !!}
            </div>
            <div class="col-md-1" style="text-align: center">
                {!! Form::label('user_age', $value->age, array('class' => 'control-label'))  !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('user_city', $value->city, array('class' => 'control-label'))  !!}
            </div>
        </div>
    </div>


    @endforeach


    {!! Form::close() !!}

@endsection
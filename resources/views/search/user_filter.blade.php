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

    <hr>
    <hr>

    @if ($id == null)

        @foreach($users as $key => $value)

            <div class="form-group">
                <div class="row">
                    <div class="col-md-3" style="text-align: right; ">
                        <a id="user_name" href="/user/{{$value->id}}" class="control-label">{{$value->name}}</a>
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

    @else
        @foreach($users as $key => $value)

            <div class="form-group">
                <div class="row">
                    <div class="col-md-2" style="text-align: right; ">
                        <a id="user_name" href="/user/{{$value->id}}" class="control-label">{{$value->name}}</a>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary openModal" data-id="{{$value->id}}">
                            Пригласить
                        </button>
                    </div>
                </div>
            </div>


        @endforeach

    @endif


    {!! Form::close() !!}

@endsection

@section('modal')

    @parent

    {!! Form::open()!!}

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Отправить приглашение</h4>
                </div>
                <div class="modal-body">
                    <textarea name="textArea" class="form-control textAreaModal" style="height: 250px"></textarea>
                    <input name="seanceHidden" type="hidden" value="{{$id}}">
                    <input name="userHidden" class="userHidden" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <input value="Отправить" type="submit" class="btn btn-primary"/>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close()!!}
    <script>
        $(document).ready(function () {
            $('.openModal').click(function () {
                var dataId = $(this).attr('data-id');

                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/api/getMessage",
                    async: true,
                    cache: false,
                    dataType: "json",
                    data: {user_id: dataId, seance: {{$id}}},
                    success: function (data) {
                        $('.textAreaModal').val(data.message);
                        $('.userHidden').val(dataId);
                    },
                    error: function (data) {

                    }
                });
                //alert(dataId);
                $('#myModal').modal('show');
            })
        });
    </script>
@endsection

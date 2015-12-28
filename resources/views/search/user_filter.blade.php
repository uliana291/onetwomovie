@extends('search.search_u')

@section('filter')


    {!! Form::open(array('method'=>'GET')) !!}

    @include('errors.error')
    <div class="row">
        <div id="content">
            <div class="2u 12u(mobile)" style="text-align: left">
                <label>Пол</label>
                {!!  Form::select('gender', array(null =>'любой','male' => 'М', 'female' => 'Ж'), $gender) !!}
            </div>
            <div class="3u 12u(mobile)">
                <label>Город</label>
                {!!  Form::select('city_id', $cityList, $city_id) !!}
            </div>
            <div class="7u 12u(mobile)">

                <label>Возраст</label>

                <div class="row">
                    <div class="5u 7u(mobile)">
                        {!!  Form::select('age_from', \App\Helper::age_range(), $age_from, array('style'=> 'width:50px', 'id' => 'age_from')) !!}
                    </div>
                    <div class="1u 3u(mobile)">
                        &#8212;
                    </div>
                    <div class="1u 2u(mobile)">
                        {!!  Form::select('age_to', \App\Helper::age_range(), $age_to, array('style'=> 'width:50px', 'id' => 'age_to')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div>
            <button type="submit" class="button"
                    style="margin-right: 15px; width: 150px;">
                Поиск
            </button>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="2u 2u(mobile)" style="text-align: right; ">
            <label>Имя</label>
        </div>
        <div class="1u 2u(mobile)" style="text-align: center; ">
            <label>Фото</label>
        </div>
        <div class="1u 1u(mobile)" style="text-align: left; ">
            <label>Пол</label>
        </div>
        <div class="2u 2u(mobile)">
            <label>Возраст</label>
        </div>
        <div class="6u 2u(mobile)">
            <label>Город</label>
        </div>
    </div>
    <hr>

    @if ($id == null)

        @foreach($users as $key => $value)

            <div class="row">
                <div class="2u 2u(mobile)" style="text-align: right; ">
                    <a id="user_name" href="/user/{{$value->id}}" class="control-label">{{$value->name}}</a>
                </div>
                <div class="1u 2u(mobile)">
                    <img src="/api/getImage/{{$value->id}}-50x50" alt="Фото профиля">
                </div>
                <div class="1u 1u(mobile)">
                    {!! Form::label('user_gender', ($value->gender == 'female'? 'Ж' : 'М'))  !!}
                </div>
                <div class="2u 2u(mobile)"s>
                    {!! Form::label('user_age', ($value->age != " "? $value->age : "не указан")) !!}
                </div>
                <div class="6u 3u(mobile)">
                    {!! Form::label('user_city', ($value->city != " " ? $value->city : "не указан")) !!}
                </div>
            </div>

        @endforeach

    @else
        @foreach($users as $key => $value)

            <div class="row">
                <div class="2u 2u(mobile)" style="text-align: right; ">
                    <a id="user_name" href="/user/{{$value->id}}" class="control-label">{{$value->name}}</a>
                </div>
                <div class="1u 2u(mobile)">
                    <img src="/api/getImage/{{$value->id}}-50x50" alt="Фото профиля">
                </div>
                <div class="1u 1u(mobile)">
                    {!! Form::label('user_gender', ($value->gender == 'female'? 'Ж' : 'М'))  !!}
                </div>
                <div class="2u 2u(mobile)">
                    {!! Form::label('user_age', ($value->age != " "? $value->age : "не указан"))  !!}
                </div>
                <div class="2u 2u(mobile)">
                    {!! Form::label('user_city', ($value->city != " " ? $value->city : "не указан"))  !!}
                </div>
                <div class="4u 3u(mobile)">
                    <button type="button" class="button openModal" data-id="{{$value->id}}">
                        Пригласить
                    </button>
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
                    <h4 class="modal-title" id="myModalLabel">Отправить приглашение</h4>
                </div>
                <div class="modal-body">
                    <textarea name="textArea" class="form-control textAreaModal" style="height: 250px"></textarea>
                    <input name="seanceHidden" type="hidden" value="{{$id}}">
                    <input name="userHidden" class="userHidden" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="button" class="button alt" data-dismiss="modal">Отмена</button>
                    <input value="Отправить" type="submit" class="button"/>
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
                        $('#myModal').modal('show');
                    },
                    error: function (data) {

                    }
                });

            })
        });
    </script>
@endsection

@section('script')

    @parent

    <script>
        $(document).ready(function () {
            $('#age_from').change(function () {
                var selected = $(this).find("option:selected").val();
                $('#age_to option').each(function () {
                    $(this).attr('disabled', false);
                    $(this).css('display', "block");
                });
                $('#age_to option').each(function () {
                    if ($(this).val() < selected && $(this).val() != 0) {
                        $(this).attr('disabled', true);
                        $(this).css('display', "none");
                    }
                });
            })
        });
    </script>

@endsection
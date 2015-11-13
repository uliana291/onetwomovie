@extends('layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Профиль {{$user->name ." " . $user->last_name}}
                        @if ($user->self == true)
                            <a style="text-align: right" href="user/edit">Редактировать</a>
                        @endif
                    </div>
                    <div class="panel-body" style="padding:10px 40px;">

                        {!! Form::open(array('class' => 'form-horizontal')) !!}


                        @include('errors.error')

                        @if ($user->ava <> null)
                        <div class="form-group">
                            <div class="row">
                                <img src="{{ $user->ava }}" alt="Фото профиля">
                            </div>
                        </div>
                        @endif



                        <div class="form-group">
                            <div class="row">
                                {{($user->status == "enable"? "Хочу в кино" : "Пока не хочу в кино")}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    Город
                                </div>
                                <div class="col-md-9">
                                    {{ $city->city }}
                                </div>
                            </div>
                        </div>

                        @if ($user->age != 0)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right; ">
                                        Возраст
                                    </div>
                                    <div class="col-md-9">
                                        {{$user->age}}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($user->mobile_number <> null)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right; ">
                                        Телефон
                                    </div>
                                    <div class="col-md-9">
                                        {{ $user->mobile_number }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($user->skype <> null)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right; ">
                                        Skype
                                    </div>
                                    <div class="col-md-9">
                                        {{ $user->skype }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($user->vk <> null)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right; ">

                                    </div>
                                    <div class="col-md-9">
                                        <a href="http://vk.com/{{$user->vk}}">Вконтакте</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($user->about <> null)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3" style="text-align: right; ">
                                        Обо мне
                                    </div>
                                    <div class="col-md-9">
                                        {{ $user->about }}
                                    </div>
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
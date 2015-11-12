@extends('layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ваш Профиль</div>
                    <div class="panel-body" style="padding:10px 40px;">

                        {!! Form::open(array('class' => 'form-horizontal')) !!}

                        {!! Form::token() !!}


                        @include('errors.error')

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('name', 'Имя', array('class' => 'control-label')) !!}
                                </div>
                                <div class="col-md-9">
                                    {!!  Form::text('name', $user->name, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('last_name', 'Фамилия', array('class' => 'control-label')) !!}
                                </div>
                                <div class="col-md-9">
                                    {!!  Form::text('last_name', $user->last_name, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('city_id', 'Город', array('class' => 'control-label')) !!}
                                </div>
                                <div class="col-md-9">
                                    {!!  Form::select('city_id', $cityList ,$user->city_id, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('status', 'Хочу сходить', array('class' => 'control-label')) !!}
                                </div>
                                <div class="col-md-9">
                                    {!!  Form::checkbox('status', $user->status, ($user->status == 'enable'? true : false)) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('birth_date', 'Дата рождения', array('class' => 'control-label')) !!}
                                </div>

                                <div class="col-md-9">
                                    {!!  Form::date('birth_date', $user->birth_date, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('about', 'Обо мне', array('class' => 'control-label')) !!}
                                </div>
                                <div class="col-md-9">
                                    {!!  Form::textarea('about', $user->about, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('email', 'Email', array('class' => 'control-label')) !!}
                                </div>
                                <div class="col-md-9">
                                    {!!  Form::text('email', $user->email, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('skype', 'Skype', array('class' => 'control-label')) !!}
                                </div>
                                <div class="col-md-9">
                                    {!!  Form::text('skype', $user->skype, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3" style="text-align: right; ">
                                    {!!  Form::label('vk', 'Vk.com/', array('class' => 'control-label')) !!}
                                </div>
                                <div class="col-md-9">
                                    {!!  Form::text('vk', $user->vk, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div style="text-align: right; ">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px; width: 150px;">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
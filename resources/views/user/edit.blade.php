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
                            <h2>Ваш профиль</h2>
                        </header>

                        {!! Form::open(array('files' => true)) !!}

                        {!! Form::token() !!}


                        @include('errors.error')
                        <div class="wrapper style2">
                            <div class="inner">

                                <section class="container box feature2" style="text-align: left">
                                    <div class="row">
                                        <div class="6u 12u(mobile)">
                                            <div>
                                                <div>
                                                    {!!  Form::label('name', 'Имя') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::text('name', $user->name) !!}
                                                </div>
                                            </div>


                                            <div>
                                                <div>
                                                    {!!  Form::label('last_name', 'Фамилия') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::text('last_name', $user->last_name) !!}
                                                </div>
                                            </div>

                                            <div>
                                                <div>
                                                    {!!  Form::label('gender', 'Пол') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::select('gender',array('male' => 'М', 'female' => 'Ж'), $user->gender) !!}
                                                </div>
                                            </div>

                                            <div>
                                                <div>
                                                    {!!  Form::label('city_id', 'Город') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::select('city_id', $cityList, $user->city_id) !!}
                                                </div>
                                            </div>

                                            <div>
                                                <div>
                                                    {!! Form::label('ava','Загрузка аватара') !!}
                                                </div>
                                                <div>
                                                    {!! Form::file('ava', null) !!}
                                                </div>
                                            </div>


                                            <div>

                                                {!!  Form::label('status', 'Хочу сходить', array('style'=>'display: inline-block; padding-top: 15px')) !!}
                                                {!!  Form::checkbox('status', $user->status, ($user->status == 'enable'? true : false)) !!}

                                            </div>

                                            <div>
                                                <div>
                                                    {!!  Form::label('birth_date', 'Дата рождения') !!}
                                                </div>

                                                <div>
                                                    {!!  Form::date('birth_date', $user->birth_date) !!}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="6u 12u(mobile)">

                                            <div>
                                                <div>
                                                    {!!  Form::label('about', 'Обо мне') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::textarea('about', $user->about, array('style'=>'height: 170px')) !!}
                                                </div>
                                            </div>


                                            <div>
                                                <div>
                                                    {!!  Form::label('email', 'Email') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::text('email', $user->email) !!}
                                                </div>
                                            </div>


                                            <div>
                                                <div>
                                                    {!!  Form::label('mobile_number', 'Телефон') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::text('mobile_number', $user->mobile_number) !!}
                                                </div>
                                            </div>


                                            <div>
                                                <div>
                                                    {!!  Form::label('skype', 'Skype') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::text('skype', $user->skype) !!}
                                                </div>
                                            </div>


                                            <div>
                                                <div>
                                                    {!!  Form::label('vk', 'Vk.com/') !!}
                                                </div>
                                                <div>
                                                    {!!  Form::text('vk', $user->vk) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div style="text-align: right">
                                    <button type="submit" class="button">
                                        Сохранить
                                    </button>
                                </div>

                                {!! Form::close() !!}


                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
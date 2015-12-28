@extends('layouts.master')

@section('content')


        <!-- Main Wrapper -->
<div id="main-wrapper">
    <div class="wrapper style1">
        <div class="inner">
            <div class="container">
                <div id="content">

                    <!-- Content -->

                    <article>
                        <header class="major">
                            <h2>Регистрация</h2>
                        </header>

                        @include('errors.error')


                        {!! Form::open() !!}
                        {!! Form::token() !!}
                        <div>
                            <label>Имя</label>

                            <div>
                                <input style="width:370px;" type="text" name="name"
                                       value="{{ old('name') }}">
                            </div>
                        </div>

                        <div>
                            <label>Email</label>

                            <div>
                                <input style="width:370px;" type="email" name="email"
                                       value="{{ old('email') }}">
                            </div>
                        </div>

                        <div>
                            <label>Пароль</label>

                            <div>
                                <input style="width:370px;" type="password" name="password">
                            </div>
                        </div>

                        <div>
                            <label>Подтверждение пароля</label>

                            <div>
                                <input style="width:370px;" type="password"
                                       name="password_confirmation">
                            </div>
                        </div>

                        <div>
                            <div>
                                <button type="submit" class="button"
                                        style="margin-right: 15px; margin-top: 15px">
                                    Зарегистрироваться
                                </button>
                            </div>
                        </div>
                        </form>
                    </article>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
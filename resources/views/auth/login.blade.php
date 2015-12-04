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
                            <h2>Вход</h2>
                        </header>

                        @include('errors.error')

                        <form role="form" method="POST" action="/auth/login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div>
                                <label>E-Mail</label>

                                <div>
                                    <input type="email" style="width:370px;" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div>
                                <label>Пароль</label>

                                <div>
                                    <input style="width:370px;" type="password" name="password">
                                </div>
                            </div>

                            <div>

                                <label>
                                    <input type="checkbox" name="remember"> Запомнить меня
                                </label>

                            </div>

                            <div>
                                <button type="submit" class="button"
                                        style="margin-right: 15px;">
                                    Войти
                                </button>

                                <a href="/password/email">Забыли пароль?</a>
                            </div>
                        </form>
                    </article>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
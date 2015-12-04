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
                            <h2>Сброс пароля</h2>
                        </header>

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Уупс!</strong> Возникла ошибка ввода.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="/password/reset">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div>
                                <label>E-Mail</label>

                                <div>
                                    <input type="email" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div>
                                <label>Пароль</label>

                                <div>
                                    <input type="password" name="password">
                                </div>
                            </div>

                            <div>
                                <label>Подтверждение пароля</label>

                                <div>
                                    <input type="password" name="password_confirmation">
                                </div>
                            </div>

                            <div>
                                <div>
                                    <button type="submit" class="button">
                                        Сбросить пароль
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
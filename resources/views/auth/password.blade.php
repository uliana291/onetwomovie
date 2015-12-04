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
                            <h2>Сброс пароля</h2>
                        </header>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Ууупс!</strong> Возникла ошибка ввода.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form role="form" method="POST" action="/password/email">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div>
                                <label>E-Mail</label>

                                <div>
                                    <input style="width:370px; border-color: grey;" type="email" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="button" style="margin-top: 15px;">
                                    Прислать ссылку на сброс пароля
                                </button>
                            </div>
                        </form>
                    </article>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
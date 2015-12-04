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
                            <h2>Информация о кинотеатре</h2>
                        </header>

                        {!! Form::open() !!}

                        @include('errors.error')

                        <h3>{{ $cinema->title }}</h3>

                        <hr>

                        <strong>Адрес: </strong>{{$cinema->address}}

                        {!! Form::close() !!}
                    </article>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Информация о кинотеатре</div>
                    <div class="panel-body" style="padding:10px 40px;">

                        {!! Form::open(array('class' => 'form-horizontal')) !!}

                        @include('errors.error')

                        <h3>{{ $cinema->title }}</h3>

                        <hr>

                        <strong>Адрес: </strong>{{$cinema->address}}

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
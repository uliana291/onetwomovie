@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Поиск фильмов</div>
                    <div class="panel-body" style="padding:10px 40px;">

                        @yield('filter')

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
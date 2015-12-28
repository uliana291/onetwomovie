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

                        <strong>Адрес: </strong><span id="address">{{$cinema->address}}</span>

                        <div id="map"></div>
                        <input id="latitude" type="hidden" value="{{ $cinema->latitude }}"/>
                        <input id="longitude" type="hidden" value="{{ $cinema->longitude }}"/>

                        {!! Form::close() !!}
                    </article>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

    @parent

    <style type="text/css">
        #map {
            width: 400px;
            height: 400px;
        }
    </style>
    <script src="http://maps.google.com/maps/api/js"></script>
    <script src="/assets/js/gmaps.js"></script>
    <script>
        $(document).ready(function () {
            var longitude = $('#longitude').val();
            var latitude = $('#latitude').val();
            var map = new GMaps({
                el: '#map',
                lat: latitude,
                lng: longitude
            });
            map.addMarker({
                lat: latitude,
                lng: longitude
            });
        });
    </script>


@endsection
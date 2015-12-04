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
                            <h2>Сеансы в вашем городе</h2>
                        </header>

                        {!! Form::open(array()) !!}

                        @include('errors.error')

                        @if (count($cinemas) <> 0)


                            @foreach($cinemas as $key => $value)
                                <h3><a href="/search/cinema/{{$key}}">{{ $names[$key] }}</a></h3>

                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach($value as $key2 => $value2)
                                            @if ($key2 == date('Y-m-d'))
                                                <li role="presentation" class="active">
                                            @else
                                                <li role="presentation">
                                                    @endif
                                                    <a aria-controls="home" role="tab" data-toggle="tab"
                                                       href="#tab{{$value2[0]->cinema_id}}{{str_replace("-","",$key2)}}">{{$key2}}</a>
                                                </li>
                                                @endforeach
                                    </ul>

                                    <div class="tab-content">
                                        @foreach($value as $key2 => $value2)

                                            @if ($key2 == date('Y-m-d'))
                                                <div id="tab{{$value2[0]->cinema_id}}{{str_replace("-","",$key2)}}"
                                                     role="tabpanel"
                                                     class="tab-pane active">
                                                    @else
                                                        <div id="tab{{$value2[0]->cinema_id}}{{str_replace("-","",$key2)}}"
                                                             role="tabpanel"
                                                             class="tab-pane">
                                                            @endif
                                                            @foreach($value2 as $item)
                                                                <a href="/search/users/seances/{{ $item->id }}">{{$item->time}}</a>
                                                            @endforeach
                                                        </div>
                                                        @endforeach
                                                </div>

                                    </div>

                                    <hr>
                                    @endforeach

                                    @else
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: center; ">
                                                Сеансов не найдено :(
                                            </div>
                                        </div>

                                </div>

                                @endif



                                {!! Form::close() !!}

                    </article>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
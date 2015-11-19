@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Сеансы в Вашем городе</div>
                    <div class="panel-body" style="padding:10px 40px;">

                        {{--TODO-SweetJuli: Менять город--}}

                        {!! Form::open(array('class' => 'form-horizontal')) !!}

                        @include('errors.error')

                        @if (count($cinemas) <> 0)


                            @foreach($cinemas as $key => $value)
                                <h3><a href ="/search/cinema/{{$key}}">{{ $names[$key] }}</a></h3>

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
                                                                <a href="/users/seances/{{ $item->id }}">{{$item->time}}</a>
                                                            @endforeach
                                                        </div>
                                                        @endforeach
                                                </div>

                                    </div>
                                    @endforeach

                                    @else
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12" style="text-align: center; ">
                                                    Сеансов не найдено :(
                                                </div>
                                            </div>
                                        </div>

                                    @endif



                                    {!! Form::close() !!}

                                </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
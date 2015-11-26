@extends('layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $dialog_with->name . ' ' . $dialog_with->last_name  }}</div>
                    <div class="panel-body" style="padding:10px 40px;">

                        {!! Form::open(array('class' => 'form-horizontal')) !!}


                        @include('errors.error')

                        @if (count($messages) == 0)

                            <div style="text-align: center">Сообщений нет</div>

                        @else
                            <div class="form-group" style="overflow-y: scroll; height: 500px; overflow-x: hidden;">
                                @foreach($messages as $message)
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-2" style="text-align: right; ">
                                            <a href="/user/{{$message->getSender->id}}"><img
                                                        src="/api/getImage/{{$message->getSender->id}}-50x50.jpg"
                                                        alt="Фото профиля"></a>
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <a href="/user/{{$message->getSender->id}}">{{$message->getSender->name}}</a>
                                            </div>
                                            {{ $message->message }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ $message->created_at }}
                                        </div>
                                    </div>
                                    @if ($message->seance_id)
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8" style="text-align: right">
                                                <a href="/user/messages/{{$message->dialog_num}}/seance/{{$message->seance_id}}">Подробнее
                                                    о сеансе..</a>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <hr>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2" style="text-align: center; ">
                                    <img src="/api/getImage/{{$id}}-50x50.jpg"
                                         alt="Фото профиля">
                                </div>
                                <div class="col-md-8">
                                    <textarea id="messageArea" name="messageArea" class="form-control"
                                              style="width: 600px; height: 70px; resize: none                                                                      "
                                              placeholder="Введите свое сообщение..."></textarea>

                                    <div>
                                        <button type="submit" class="btn btn-primary"
                                                style="margin-right: 15px; width: 100px; margin-top: 10px;">
                                            Отправить
                                        </button>
                                    </div>
                                    <input name="userHidden" type="hidden" value="{{$dialog_with->id}}">
                                </div>
                                <div class="col-md-2" style="text-align: center; ">
                                    <a href="/user/{{$dialog_with->id}}"><img
                                                src="/api/getImage/{{$dialog_with->id}}-50x50.jpg"
                                                alt="Фото профиля"></a>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
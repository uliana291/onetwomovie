@extends('layouts.master')

@section('content')


        <!-- Main Wrapper -->
<div id="main-wrapper">
    <div class="wrapper style1">
        <div class="inner">
            <!-- Content -->

            <section class="container box feature1">
                <div class="row">
                    <div class="12u">
                        <header class="first major">
                            <h2>{{ $dialog_with->name . ' ' . $dialog_with->last_name  }}</h2>
                        </header>
                    </div>
                </div>
                {!! Form::open() !!}


                @include('errors.error')

                @if (count($messages) == 0)

                    <div style="text-align: center">Сообщений нет</div>

                @else
                    <div style="overflow-y: scroll; height: 500px; overflow-x: hidden; border: gray;" id="dialogDiv">
                        @foreach($messages as $message)
                            <div class="row" style="margin-top: 5px">
                                <div class="2u 12u(mobile)" style="text-align: right; ">
                                    <a href="/user/{{$message->getSender->id}}"><img
                                                src="/api/getImage/{{$message->getSender->id}}-50x50.jpg"
                                                alt="Фото профиля"></a>
                                </div>
                                <div class="8u 12u(mobile)" style="text-align: left">
                                    <div>
                                        <a href="/user/{{$message->getSender->id}}">{{$message->getSender->name}}</a>
                                    </div>
                                    {{ $message->message }}
                                </div>
                                <div class="2u 12u(mobile)">
                                    {{ $message->created_at }}
                                </div>
                            </div>
                            @if ($message->seance_id)
                                <div class="row">
                                    <div class="2u 12u(mobile)"></div>
                                    <div class="8u 12u(mobile)" style="text-align: right">
                                        <a href="/user/messages/{{$message->dialog_num}}/seance/{{$message->seance_id}}">Подробнее
                                            о сеансе..</a>
                                    </div>
                                    <div class="2u 12u(mobile)"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                <hr>
                <div class="row">
                    <div class="12u 12u(mobile)">

                        <section>
                            <div>
                                <div class="row" style="margin-left: 100px;">
                                    <div style="text-align: right" class="2u 12u(mobile)">
                                        <img src="/api/getImage/{{$id}}-50x50.jpg"
                                             alt="Фото профиля">
                                    </div>


                                    <div class="9u 12u(mobile)">
                                    <textarea id="messageArea" name="messageArea" class="form-control"
                                              style="width: 600px; height: 70px; resize: none                                                                      "
                                              placeholder="Введите свое сообщение..."></textarea>
                                    </div>

                                    <div class="1u 12u(mobile)">
                                        <a href="/user/{{$dialog_with->id}}"><img
                                                    src="/api/getImage/{{$dialog_with->id}}-50x50.jpg"
                                                    alt="Фото профиля"></a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="button"
                                        style="margin-right: 55px;  margin-top: 10px; float: right">
                                    Отправить
                                </button>
                            </div>
                            <input name="userHidden" type="hidden" value="{{$dialog_with->id}}">
                        </section>
                    </div>

                </div>

                {!! Form::close() !!}
            </section>
        </div>

    </div>
</div>


@endsection

@section('script')
@parent
    <script>
        $(document).ready(function() {
            $("#dialogDiv").scrollTop($("#dialogDiv")[0].scrollHeight);
        });
    </script>
@endsection
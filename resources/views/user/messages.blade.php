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
                            <h2>Сообщения</h2>
                        </header>

                        @include('errors.error')

                        {!! Form::open() !!}


                        @if (count($messages) == 0)

                            <div style="text-align: center">Сообщений нет</div>

                        @else
                            <table class="table table-bordered">
                                <tbody>
                                @foreach($messages as $message)
                                    <tr class="{{($message->read != 0 || $message->getReceiver->id != $id)?  "" : "success"}}">
                                        @if ($message->getSender->id == $id)
                                            <td style="text-align: right; border-right-color: white;"><a href="/user/{{$message->getReceiver->id}}"><img
                                                            src="/api/getImage/{{$message->getReceiver->id}}-50x50"
                                                            alt="Фото профиля"></a>
                                            <td style="text-align: center">
                                                <a href="/user/{{$message->getReceiver->id}}">{{$message->getReceiver->name . " " . $message->getReceiver->last_name}}</a>

                                                <div>{{$message->created_at}}</div>
                                            </td>
                                        @else
                                            <td><a href="/user/{{$message->getSender->id}}"><img
                                                            src="/api/getImage/{{$message->getSender->id}}-50x50"
                                                            alt="Фото профиля"></a>
                                            <td style="text-align: center">
                                                <a href="/user/{{$message->getSender->id}}">{{$message->getSender->name . " " . $message->getSender->last_name}}</a>

                                                <div>{{$message->created_at}}</div>
                                            </td>
                                        @endif
                                        <td class="{{($message->read == 0 && $message->getReceiver->id != $id)?   "active" : ""}}"
                                            style="width: 710px">
                                            <a href="/user/messages/{{$message->dialog_num}}">{!! \App\Helper::utf8_substr_replace($message->message, '..', 100)!!}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                        {!! Form::close() !!}
                    </article>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
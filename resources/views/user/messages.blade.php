@extends('layouts.master')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Сообщения</div>
                    <div class="panel-body" style="padding:10px 40px;">

                        {!! Form::open(array('class' => 'form-horizontal')) !!}


                        @include('errors.error')

                        @if (count($messages) == 0)

                            <div style="text-align: center">Сообщений нет</div>

                        @else
                            <table class="table table-bordered">
                                <tbody>
                                @foreach($messages as $message)
                                    <tr class="{{($message->read != 0 || $message->getReceiver->id != $id)?  "" : "success"}}">
                                        @if ($message->getSender->id == $id)
                                            <td><a href="/user/{{$message->getReceiver->id}}"><img
                                                            src="/api/getImage/{{$message->getReceiver->id}}-50x50.jpg"
                                                            alt="Фото профиля"></a>
                                            <td style="text-align: center">
                                                <a href="/user/{{$message->getReceiver->id}}">{{$message->getReceiver->name . " " . $message->getReceiver->last_name}}</a>

                                                <div>{{$message->created_at}}</div>
                                            </td>
                                        @else
                                            <td><a href="/user/{{$message->getSender->id}}"><img
                                                            src="/api/getImage/{{$message->getSender->id}}-50x50.jpg"
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

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
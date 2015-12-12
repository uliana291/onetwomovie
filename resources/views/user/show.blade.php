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
                            <h2>Профиль {{$user->name ." " . $user->last_name}}</h2>

                            <h4>     @if ($user->self == true)
                                    <a style="text-color: blue;" href="user/edit">Нажмите, чтобы отредактировать</a>
                                @endif
                            </h4>

                        </header>

                        @include('errors.error')

                        {!! Form::open(array('method'=>'GET')) !!}



                        @if ($user->ava <> null)
                            <div>
                                <img class="image left" src="{{ $user->ava }}"
                                     alt="Фото профиля">
                                <span class="date">
                                    {{($user->status == "enable"? "Хочу в кино" : "Пока не хочу в кино")}}
                                </span>
                            </div>
                        @endif



                        @if ($city <> null )

                            <div>
                                <strong>Город</strong>
                                <span style="margin-left: 50px;">{{ $city->city }}</span>

                            </div>

                        @endif

                        @if ($user->age != 0)
                            <div>
                                <strong>
                                    Возраст
                                </strong>
                                <span style="margin-left: 35px;">
                                    {{$user->age}}
                                </span>
                            </div>

                        @endif

                        @if ($user->mobile_number <> null)
                            <div>
                                <strong>
                                    Телефон
                                </strong>
                                <span style="margin-left: 30px;">
                                    {{ $user->mobile_number }}
                                </span>
                            </div>
                        @endif

                        @if ($user->skype <> null)

                            <div>
                                <strong>
                                    Skype
                                </strong>
                                <span style="margin-left: 52px;">
                                    {{ $user->skype }}
                                </span>
                            </div>

                        @endif

                        @if ($user->vk <> null)
                            <div>
                                <a href="http://vk.com/{{$user->vk}}">Вконтакте</a>
                            </div>
                        @endif

                        @if ($user->about <> null)
                            <div>
                                <strong>
                                    Обо мне
                                </strong>
                                <span style="margin-left: 30px;">
                                    {{ $user->about }}
                                </span>
                            </div>
                        @endif
                        <hr>
                        @if($user->id <> request()->user()->id)
                            <div>
                                <input type="button" class="button openModal"
                                       value="Написать сообщение" data-id="{{$user->id}}"/>
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


@section('modal2')

    @parent

    {!! Form::open()!!}

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Отправить</h4>
                </div>
                <div class="modal-body">
                    <textarea name="messageArea" class="form-control messageArea" style="height: 250px"></textarea>
                    <input name="userHidden" class="userHidden" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="button" class="button alt" data-dismiss="modal">Отмена</button>
                    <input value="Отправить" type="submit" class="button"/>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close()!!}
    <script>
        $(document).ready(function () {
            $('.openModal').click(function () {
                var dataId = $(this).attr('data-id');
                $('.userHidden').val(dataId);

                $('#myModal').modal('show');

            })
        });
    </script>
@endsection
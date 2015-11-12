{!! Form::open(array('route' => array('user/{id}', $user->id))) !!}

echo Form::label('login', 'Login');

{!! Form::close() !!}
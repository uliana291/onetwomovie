
    @if(session()->has('error'))
        @if(session()->get('error') == 1)
            <div class="alert alert-danger">{!! session()->get('message') !!}</div>
        @else
            <div class="alert alert-success">{!! session()->get('message') !!}</div>
        @endif
    @endif
    @if(count($errors->all()) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

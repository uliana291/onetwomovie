<!DOCTYPE html>
<html lang="en">
<head>
    <title>OneTwoMovie</title>

    <!— Latest compiled and minified CSS —>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
          crossorigin="anonymous">

    <!— Optional theme —>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"
          integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

</head>

<body>
<div class="container">
    <nav class="navbar navbar-default">
        <a class="navbar-brand" href="/auth/login">OneTwoMovie</a>
        @if ( !Auth::check())
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/auth/register">Регистрация</a>
                </li>
            </ul>
        @endif

        @if ( Auth::check())
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/user">Профиль</a>
                </li>
            </ul>
        @endif

        @if ( Auth::check())
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/search/users">Поиск</a>
                </li>
            </ul>
        @endif

    </nav>
</div>

@yield('content')

<!— Latest compiled and minified JavaScript —>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"
        integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ=="
        crossorigin="anonymous"></script>

</body>
</html>
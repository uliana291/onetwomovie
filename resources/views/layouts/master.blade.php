<!DOCTYPE html>
<html lang="en">
<head>
    <title>OneTwoMovie</title>


    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!--[if lte IE 8]>
    <script src="/assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="/assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="/assets/css/main.css"/>
    <link rel="stylesheet" href="/assets/css/bootstrap-theme.min.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ie8.css"/><![endif]-->
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/assets/css/ie9.css"/><![endif]-->

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>

<body class="{{ $url == "/" ? "homepage" : "no-sidebar" }}">
<div id="page-wrapper">

    <!-- Header -->
    <div id="header-wrapper">
        <div class="container">

            <!-- Header -->
            <header id="header">
                <div class="inner">

                    <!-- Logo -->
                    <h1><a href="/" id="logo">One-Two-Movie</a></h1>

                    <!-- Nav -->
                    <nav id="nav">
                        <ul>
                            @if ( !Auth::check())
                                <li><a href="/auth/register">Регистрация</a></li>
                            @endif
                            @if ( !Auth::check())
                                <li><a href="/auth/login">Вход</a></li>
                            @endif
                            @if ( Auth::check())
                                <li><a href="/user">Профиль</a></li>
                            @endif
                            @if ( Auth::check())
                                <li><a href="/user/messages">Сообщения @if ($unread <> 0)
                                            <div class="current_page_item">{{ $unread }}</div> @endif</a></li>
                            @endif
                            @if ( Auth::check())
                                <li><a href="/search/users">Поиск</a></li>
                            @endif

                            @if ( Auth::check())
                                <li><a href="/auth/logout">Выйти</a></li>
                            @endif
                        </ul>
                    </nav>

                </div>
            </header>

            @if ($url == "/")
                    <!-- Banner -->
            <div id="banner">
                <h2>Не можешь найти с кем пойти в кино?
                    <br/>
                    Не отчаивайся :D
                    <br/>
                    <strong>one-two-movie</strong> тебе поможет ;) </h2>

                <p>Тебе же хочется нажать на большую яркую кнопку?</p>
                <a href="/auth/register" class="button big icon ">Регистрация</a>
            </div>
            @endif

        </div>
    </div>
</div>
{{--{!! Breadcrumbs::render($breadcrumb) !!}--}}

@if ($url <> "/")
@yield('content')
@endif


        <!-- Footer Wrapper -->
<div id="footer-wrapper">
    <footer id="footer" class="container">
        <div class="row">
            <div class="6u 12u(mobile)">

                <!-- Contact -->
                <section>
                    <h2>Контакты</h2>

                    <div>
                        <div class="row">
                            <div class="6u 12u(mobile)">
                                <dl class="contact">
                                    <dt>Twitter</dt>
                                    <dd><a href="https://twitter.com/sweetjulskiss">@sweetjulskiss</a></dd>
                                    <dt>Facebook</dt>
                                    <dd><a href="https://www.facebook.com/sweetkissjuli">facebook.com/sweetkissjuli</a>
                                    </dd>
                                    <dt>Email</dt>
                                    <dd><a href="#">uliana291@gmail.com</a></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </footer>
</div>


<script src="/assets/jquery.min.js"></script>

<!— Latest compiled and minified JavaScript —>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"
        integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ=="
        crossorigin="anonymous"></script>

<script>
    $(function () {
        $('#city_id').change(function () {
            this.form.submit();
        });
    });
</script>
@yield('modal')
@yield('modal2')
@yield('script')

        <!-- Scripts -->

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/jquery.dropotron.min.js"></script>
<script src="/assets/js/skel.min.js"></script>
<script src="/assets/js/skel-viewport.min.js"></script>
<script src="/assets/js/util.js"></script>
<!--[if lte IE 8]>
<script src="/assets/js/ie/respond.min.js"></script><![endif]-->
<script src="/assets/js/main.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>


<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter34148225 = new Ya.Metrika({
                    id: 34148225,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true,
                    trackHash: true
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
            n.parentNode.insertBefore(s, n);
        };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/34148225" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-71266770-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
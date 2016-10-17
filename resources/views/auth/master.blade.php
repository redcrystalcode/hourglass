<!DOCTYPE html>
<html>
    <head>
        <title>Hourglass – Workplace Time Tracking Simplified</title>

        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/mdl-select.min.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <!-- Favicons -->
        <meta name="theme-color" content="#00796B">

        <style type="text/css">
            .mdl-selectfield--floating-label.is-focused .mdl-selectfield__label,
            .mdl-selectfield--floating-label.is-dirty .mdl-selectfield__label {
                color: rgb(0,150,136);
            }
            .mdl-selectfield__label:after {
                background-color: rgb(0,150,136);
            }
            .mdl-selectfield {
                width: 100%;
            }
        </style>
    </head>

    <body>
        <div class="app">
            <div class="app__header-region">
                <header class="navbar">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--4-col mdl-cell--middle mdl-cell--1-col-tablet">
                        </div>
                        <div class="mdl-cell mdl-cell--4-col mdl-cell--middle mdl-cell--6-col-tablet">
                            <div class="navbar__logo">
                                <span class="hidden">Hourglass</span>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--4-col mdl-cell--middle mdl-cell--1-col-tablet text-right">
                            <ul class="navbar__nav">
                                <li class="nav__item nav__item--pill">
                                    @if (Request::getRequestUri() === '/login')
                                        <a href="/register">Register</a>
                                    @elseif (Request::getRequestUri() === '/register')
                                        <a href="/login">Log In</a>
                                    @endif
                                </li>
                            </ul>
                        </div>

                    </div>
                </header>
            </div>
            <div class="app__content-region">
                @yield('content')
            </div>
            <div class="app__footer-region">
                <footer class="footer">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--middle mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--hide-phone">
                            <div class="footer__logo">
                                <span class="hidden">Hourglass</span>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--middle mdl-cell--8-col mdl-cell--5-col-tablet">
                            {{--<div class="footer__nav">--}}
                            {{--<ul class="nav__list">--}}
                            {{--<li class="list__item"><a href="#">Privacy Policy</a></li>--}}
                            {{--<li class="list__item"><a href="#">Terms of Service</a></li>--}}
                            {{--<li class="list__item">--}}
                            {{--<a href="#">--}}
                            {{--<i class="material-icons">help</i> Help--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--</ul>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="//code.jquery.com/jquery-2.1.1.js"></script>
        <script src="//code.getmdl.io/1.1.1/material.min.js"></script>
        <script src="/js/mdl-select.min.js"></script>
        <script>
            $(function() {
                componentHandler.upgradeAllRegistered();
            });
        </script>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <title>Hourglass</title>

        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="/css/main.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <!-- Favicons -->
        <meta name="theme-color" content="#00796B">

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
                            {{--<ul class="navbar__nav">
                                <li class="nav__item nav__item--pill">
                                    <a href="/register">Register</a>
                                </li>
                            </ul>--}}
                        </div>
                    </div>
                </header>
            </div>
            <div class="app__content-region">
                <div class="container container--with-ribbon">
                    <div class="container__ribbon"></div>
                    <main class="main-content">
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-offset-desktop mdl-cell--6-col-tablet mdl-cell--1-offset-tablet">
                                <div class="login-card card card--animate-in card--4dp">
                                    <h2 class="card__title card__title--xl">Log In</h2>

                                    <form method="POST" action="{{ url('/login') }}" class="login-form">
                                        {!! csrf_field() !!}
                                        <div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield {{ $errors->has('username') ? 'mdl-textfield--invalid' : '' }}">
                                            <input class="mdl-textfield__input" type="text" id="username" name="username"
                                                   tabindex="1" autofocus value="{{ old('username') }}">
                                            <label class="mdl-textfield__label" for="username">Username</label>
                                            @if ($errors->has('username'))
                                                <div class="mdl-textfield__error">{{ $errors->first('username') }}</div>
                                            @endif
                                        </div>
                                        <div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield {{ $errors->has('password') ? 'mdl-textfield--invalid' : '' }}">
                                            <input class="mdl-textfield__input" type="password" id="password"
                                                   name="password" tabindex="2">
                                            <label class="mdl-textfield__label" for="password">Password</label>
                                            @if ($errors->has('password'))
                                                <div class="mdl-textfield__error">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember" style="margin-top: 8px;">
                                            <input type="checkbox" id="remember" name="remember" class="mdl-checkbox__input">
                                            <span class="mdl-checkbox__label" style="font-weight: 300; font-size: 15px;">Remember Me</span>
                                        </label>
                                        {{--<div class="mdl-textfield__hint">--}}
                                        {{--<a href="#" tabindex="-1">Forgot your password?</a>--}}
                                        {{--</div>--}}

                                        <div class="text-right">
                                            <input tabindex="3" type="submit" value="Log In"
                                                   class="mdl-button mdl-button--accent mdl-js-button mdl-js-ripple-effect" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
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
        <script defer src="//code.getmdl.io/1.1.1/material.min.js"></script>
        <script>
            $(function() {
                componentHandler.upgradeAllRegistered();
            });
        </script>
    </body>
</html>

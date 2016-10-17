@extends('auth.master')

@section('content')
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
@endsection

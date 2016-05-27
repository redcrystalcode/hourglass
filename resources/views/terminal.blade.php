<!DOCTYPE html>
<html>
    <head>
        <title>Hourglass</title>

        <link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|Material+Icons|Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/css/main.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <!-- Favicons -->
        <meta name="theme-color" content="#00796B">

        @if (App::environment('production'))
            <!-- Error Tracking -->
            <script src="//d2wy8f7a9ursnm.cloudfront.net/bugsnag-2.min.js" data-apikey="94e126e5132891331c05828423f4b288"></script>
        @endif

    </head>

    <body>
        <div class="app"></div>

        <script>function bootstrap() { return {!! json_encode($bootstrap) !!}; }</script>
        <script src="//code.jquery.com/jquery-2.1.1.js"></script>
        <script defer src="//code.getmdl.io/1.1.1/material.min.js"></script>
        <script defer src="/js/main.js"></script>
    </body>
</html>

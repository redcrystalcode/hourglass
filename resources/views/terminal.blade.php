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
        <div class="app"></div>

        <script>function bootstrap() { return {!! json_encode($bootstrap) !!}; }</script>
        <script src="//code.jquery.com/jquery-2.1.1.js"></script>
        <script defer src="//code.getmdl.io/1.1.1/material.min.js"></script>
        <script defer src="/js/main.js"></script>
    </body>
</html>

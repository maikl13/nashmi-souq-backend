<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #f5f5f5;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                font-size: 16px;
                padding: 0 15px 0 15px;
                text-align: center;
                display: block
            }

            .message {
                font-size: 25px;
                text-align: center;
            }

            .wrapper {
                width: 100%;
                max-width: 500px;
                background-color: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                margin: 15px;
                padding: 50px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="wrapper">
                <img src="/assets/images/alert.svg" alt="error image" width="100">
                <div class="code">
                    {{ __('Error') }}: @yield('code')
                </div>

                <div class="message" style="padding: 22px;">
                    @yield('message')
                </div>
            </div>
        </div>
    </body>
</html>

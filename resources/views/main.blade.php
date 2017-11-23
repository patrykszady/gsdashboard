<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>GS | @yield('title') </title>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-3.2.1/dt-1.10.16/datatables.min.css"/>
 
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/jq-3.2.1/dt-1.10.16/datatables.min.js"></script>

    </head>
    <body>
        @include('partials.nav')

        <div class="container">
            @include('partials.messages')
            @yield('content')
        </div>
        @stack('script')
    </body>
</html>

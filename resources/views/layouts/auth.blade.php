<!doctype html>
<html lang="en">
    <head>
        @include('partials.dashmix._head')
    </head>
    <body>
        <div id="page-container">
            <main id="main-container">
                @yield('content')
            </main>
        </div>
        @include('partials.dashmix._scripts')
    </body>
</html>

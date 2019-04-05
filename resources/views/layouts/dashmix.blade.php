<!doctype html>
<html lang="en">
    <head>
        @include('partials.dashmix._head')
        <style type="text/css">
            .content {
    width: 100%;
    margin: 0 auto;
     padding: 0px;
    overflow-x: visible;
}
        </style>
    </head>
    <body>
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed page-header-dark main-content-narrow side-trans-enabled">
            <aside id="side-overlay">
                @include('partials.dashmix._aside')
            </aside>
            <nav id="sidebar" aria-label="Main Navigation">
                @include('partials.dashmix._sidenav')
            </nav>
            <header id="page-header">
                @include('partials.dashmix._header')
            </header>
            <main id="main-container">
                @yield('breadcrumbs')
                @include('includes._alert')
                @yield('content')
            </main>
            <footer id="page-footer" class="bg-white">
                @include('partials.dashmix._footer')
            </footer>
        </div>
        @include('partials.dashmix._scripts')
    </body>
</html>

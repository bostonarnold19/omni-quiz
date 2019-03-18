<!doctype html>
<html lang="en">
    <head>
        @include('partials.dashmix._head')
    </head>
    <body>
        <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
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
                @yield('content')
            </main>
            <footer id="page-footer" class="bg-white">
                @include('partials.dashmix._footer')
            </footer>
        </div>
        @include('partials.dashmix._scripts')
    </body>
</html>

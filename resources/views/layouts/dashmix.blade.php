<!doctype html>
<html lang="en">
    <head>
        @include('partials.dashmix._head')
    </head>
    <body>
        <div id="page-container" class="page-header-dark main-content-boxed">

            <!-- Header -->
            <header id="page-header">
                @include('partials.dashmix._header')
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                @include('partials.dashmix._sidenav')
                <div class="content content-full">
                  @include('includes._alert')
                  @yield('content')
                </div>
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="footer-static bg-white">
                <div class="content py-4">
                    <!-- Footer Copyright -->
                    <div class="row font-size-sm pt-4">
                        <div class="col-sm-6 order-sm-1 text-center text-sm-left">
                          <a class="font-w600" href="#" target="_blank">{{ config('core.title') }}</a> &copy; <span data-toggle="year-copy">{{ config('core.copyright') }}</span>
                        </div>
                    </div>
                    <!-- END Footer Copyright -->
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        @include('partials.dashmix._scripts')

    </body>
</html>
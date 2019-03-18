<div class="content-header">
    <div>
        <button type="button" class="btn btn-dual mr-1 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
        <i class="fa fa-fw fa-bars"></i>
        </button>
        <button type="button" class="btn btn-dual" data-toggle="layout" data-action="header_search_on">
        <i class="fa fa-fw fa-search"></i> <span class="ml-1 d-none d-sm-inline-block">Search Account..</span>
        </button>
    </div>
    <div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-fw fa-user-circle"></i>
            <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                    <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ auth()->user()->profile_picture }}" alt="">
                    <div class="pt-2">
                        <a class="text-white font-w600" href="#">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
                    </div>
                </div>
                <div class="p-2">
                    <a class="dropdown-item" href="#">
                        <i class="far fa-fw fa-user mr-1"></i> Profile
                    </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <i class="far fa-fw fa-building mr-1"></i> Settings
                    </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sign Out
                    </a>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-dual" data-toggle="layout" data-action="side_overlay_toggle">
        <i class="far fa-fw fa-bookmark"></i>
        </button>
    </div>
</div>
<div id="page-header-search" class="overlay-header bg-sidebar-dark">
    <div class="content-header">
        <form class="w-100" action="#" method="post">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="btn btn-dark" data-toggle="layout" data-action="header_search_off">
                    <i class="fa fa-fw fa-times-circle"></i>
                    </button>
                </div>
                <input type="text" class="form-control border-0" placeholder="Search Account.." id="page-header-search-input" name="page-header-search-input">
            </div>
        </form>
    </div>
</div>
<div id="page-header-loader" class="overlay-header bg-primary-darker">
    <div class="content-header">
        <div class="w-100 text-center">
            <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

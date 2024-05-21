<div class="content-header">
    <div class="d-flex align-items-center">
        <!-- Logo -->
        <a class="link-fx font-size-lg text-white" href="#">
            <span class="text-white-75">Omni</span><span class="text-white font-w700">Aviation</span>
        </a>
    </div>
    <div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-fw fa-user-circle"></i>
            <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                    <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset(auth()->user()->profile_picture) }}" alt="">
                    <div class="pt-2">
                        <a class="text-white font-w600" href="#">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
                    </div>
                </div>
                <div class="p-2">
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sign Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

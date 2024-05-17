<div class="content-header justify-content-lg-center">
    <a class="link-fx font-size-lg text-dual" href="/">
                            <img src="{{ asset('img/airline-training.png') }}" class="img-fluid" width="500">

{{--         <span class="text-white-75">{{ config('core.title_primary') }}</span>
        {{ config('core.title_extension') }} --}}
    </a>
    <div class="d-lg-none">
        <a class="text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
            <i class="fa fa-times-circle"></i>
        </a>
    </div>
</div>
<div class="content-side content-side-full bg-black-10 text-center">
    <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset(auth()->user()->profile_picture) }}" alt="">
</div>
<div class="content-side content-side-full">
    <ul class="nav-main">
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="nav-main-link-icon si si-bar-chart"></i>
                <span class="nav-main-link-name">Dashboard</span>
            </a>
        </li>
        {{-- <li class="nav-main-heading">Manage</li> --}}
        @permission('manage-user')
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('user*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">User</span>
            </a>
        </li>
        @endpermission
        @permission('manage-user-profile')
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('student-profile*') ? 'active' : '' }}" href="{{ route('student-profile.index') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">Profile</span>
            </a>
        </li>
        @endpermission
        @permission('manage-role')
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('role*') ? 'active' : '' }}" href="{{ route('role.index') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">Role</span>
            </a>
        </li>
        @endpermission
        @permission('manage-permission')
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('permission*') ? 'active' : '' }}" href="{{ route('permission.index') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">Permission</span>
            </a>
        </li>
        @endpermission
        @permission('manage-group-question')
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('group-question*') ? 'active' : '' }}" href="{{ route('group-question.index') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">Exams</span>
            </a>
        </li>
        @endpermission
        @permission('manage-question')
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('question*') ? 'active' : '' }}" href="{{ route('question.index') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">Question</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('import') ? 'active' : '' }}" href="{{ route('import') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">Import</span>
            </a>
        </li>
        @endpermission
        @permission('manage-result')
        {{-- <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('result') ? 'active' : '' }}" href="{{ route('result.index') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">Result</span>
            </a>
        </li> --}}
        @endpermission
        @permission('codes')
        <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('codes') ? 'active' : '' }}" href="{{ route('codes') }}">
                <i class="nav-main-link-icon far fa-dot-circle"></i>
                <span class="nav-main-link-name">Codes</span>
            </a>
        </li>
        @endpermission
    </ul>
</div>

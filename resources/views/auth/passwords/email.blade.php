@extends('layouts.auth')
@section('content')
<div class="bg-image" style="background-image: url('{{ asset('themes/dashmix/assets/media/photos/photo21@2x.jpg') }}');">
    <div class="row no-gutters bg-gd-sun-op">
        <div class="hero-static col-md-6 d-flex align-items-center bg-white">
            <div class="p-3 w-100">
                <div class="text-center">
                    <a class="link-fx text-warning font-w700 font-size-h1" href="index.html">
                        <span class="text-dark">{{ config('core.title_primary') }}</span><span class="text-warning">{{ config('core.title_extension') }}</span>
                    </a>
                    <p class="text-uppercase font-w700 font-size-sm text-muted">Reset Password</p>
                </div>
                <div class="row no-gutters justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                        <form class="js-validation-reminder" action="{{ route('password.email') }}" method="post">
                            @csrf
                            <div class="form-group py-3">
                                <input autocomplete="off" type="text" class="form-control form-control-lg form-control-alt" id="reminder-credential" name="email" placeholder="Email">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-block btn-hero-lg btn-hero-warning">
                                <i class="fa fa-fw fa-reply mr-1"></i> Send Password Reset Link
                                </button>
                                <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                                    <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('login') }}">
                                        <i class="fa fa-sign-in-alt text-muted mr-1"></i> Sign In
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
            <div class="p-3">
                @php
                    $quote = explode("-", \Illuminate\Foundation\Inspiring::quote());
                @endphp
                <p class="display-4 font-w700 text-white mb-0">
                    {{ $quote[0] }}
                </p>
                <p class="font-size-h1 font-w600 text-white-75 mb-0">
                    {{ $quote[1] }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

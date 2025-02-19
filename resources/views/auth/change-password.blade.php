@extends('layouts.dashmix')
@section('content')
    <div class="bg-dark bg-image" style="background-image: url('{{ asset('themes/dashmix/assets/media/photos/photo23@2x.jpg') }}');">
        <div class="bg-black-75">
            <div class="content content-full content-top" style="padding:0px">
                <div class="py-7 text-center">
                    <h1 class="text-white">Change Password</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        <div class="block block-rounded block-bordered">
            <div class="block-content mb-3">
                <form action="{{ route('new-password.update') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <label for="first_name">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="col-md-12 col-12">
                            <label for="last_name">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="col-md-12 col-12">
                            <label for="last_name">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary mt-3">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

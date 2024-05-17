@extends('layouts.dashmix')
@section('content')
<div class="bg-dark bg-image" style="background-image: url('{{ asset('themes/dashmix/assets/media/photos/photo23@2x.jpg') }}');">
    <div class="bg-black-75">
        <div class="content content-full content-top" style="padding:0px">
            <div class="py-7 text-center">
                <h1 class="text-white">Profile</h1>
            </div>
        </div>
    </div>
</div>
<div class="content content-boxed">
    <div class="block block-rounded block-bordered">
        <div class="block-content mb-3">
            <form action="{{route('student-profile.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{$user->email}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

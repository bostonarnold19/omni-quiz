@extends('layouts.dashmix')
@section('content')
<div class="bg-dark bg-image" style="background-image: url('{{ asset('themes/dashmix/assets/media/photos/photo23@2x.jpg') }}');">
    <div class="bg-black-75">
        <div class="content content-full content-top">
            <div class="py-7 text-center">
                <h1 class="font-w700 text-white mb-2">
                Enter Code
                </h1>
                <form action="{{ route('omni-questionnaire.create') }}" method="GET">
                    <div class="row push mb-3">
                        <div class="col-5 mx-auto">
                            <input type="text" min="0" name="codes" class="form-control" placeholder="Enter Code" v-model="search">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-hero-primary">
                        <i class="fa fa-play mr-1"></i> Start Exam
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="content content-boxed">
    <div class="block block-rounded block-bordered">
        <div class="block-content">

        </div>
    </div>
</div>
@endsection

@extends('layouts.dashmix')
@section('content')
<div class="bg-dark bg-image" style="background-image: url('{{ asset('themes/dashmix/assets/media/photos/photo23@2x.jpg') }}');">
    <div class="bg-black-75">
        <div class="content content-full content-top">
            <div class="py-7 text-center">
                {{-- <h1 class="font-w700 text-white mb-2">
                Enter Code
                </h1> --}}
                {{-- <a href="{{route('study-mode.index')}}" class="btn btn-hero-primary">
                    <i class="fa fa-book mr-1"></i> Study mode
                </a> --}}
                @if(auth()->user()->course)
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-study-mode"  class="btn btn-hero-primary">
                        <i class="fa fa-book mr-1"></i> Study Exam
                    </a>
                    <br>
                    <br>
                    @if (!$questionnaire_code)
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#add-question-code"  class="btn btn-hero-primary">
                            <i class="fa fa-book mr-1"></i> Mock Exam
                        </a>
                    @else
                        <a href="{{route('exam-mode.index')}}"  class="btn btn-hero-primary">
                            <i class="fa fa-book mr-1"></i> Mock Exam
                        </a>
                    @endif
                @else
                    <h1 class="font-w700 text-white mb-2">Welcome {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h1>
                @endif
                @if($qualifying)
                <br>
                <br>
                <a href="javascript:void(0)"  data-toggle="modal" data-target="#add-qualifying"  class="btn btn-hero-primary">
                    <i class="fa fa-book mr-1"></i> Qualifying Exam
                </a>
                @include('modules.home.includes._modal_qualifying_exam')
                @endif
                                
                @include('modules.exam_mode.includes._modal_exam_mode_selection')
                @include('modules.study_mode.includes._modal_study_mode_selection')
            </div>
        </div>
    </div>
</div>
@endsection

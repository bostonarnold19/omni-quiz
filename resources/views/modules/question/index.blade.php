@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('question.index') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Question</h3>
            <a href="#" class="btn btn-outline-primary push"  data-toggle="modal" data-target="#add-modal">Add New Question</a>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                    <tr>
                        <td>{{ $question->question }}</td>
                        <td>{{ $question->time }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-secondary button-edit" data-id="{{$question->id}}">Edit</a>
                            <form style="display:inline;" method="POST" action="{{ route('question.destroy', $question->id) }}" onsubmit="return confirm('Are you sure you want to delete tihs?')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="app">
    @include('modules.question.includes._modal_add_question')
    @include('modules.question.includes._modal_edit_question')
</div>
@endsection
@section('styles')
<style type="text/css">
    .is_correct_btn{
        color:#d6d3d3;
        cursor: pointer;
    }
    .is_correct_btn.active{
        color:green;
    }
</style>
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/js/vue.js') }}"></script>
<script>
    window.publicUrl = "{{url('/')}}";
</script>
<script src="{{ asset('/js/custom.js') }}"></script>
@endsection

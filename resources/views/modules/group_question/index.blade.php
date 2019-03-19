@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('group-question.index') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Group Question</h3>
            <a href="#" class="btn btn-outline-primary push">Add New Group Question</a>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Published</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($group_questions as $group_question)
                    <tr>
                        <td>{{ $group_question->title }}</td>
                        <td>{{ $group_question->description }}</td>
                        <td>{{ $group_question->is_published }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-secondary">Edit</a>
                            <form style="display:inline;" method="POST" action="#{{-- {{ route('group-question.destroy', $group_question->id) }} --}}" onsubmit="return confirm('Are you sure you want to delete tihs?')">
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
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endsection

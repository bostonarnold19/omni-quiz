@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('result.index') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Result</h3>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Items</th>
                        <th>Published</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user_questions as $user_question)
                    <tr>
                        <td>{{ $user_question->group_question->title }}</td>
                        <td>{{ $user_question->group_question->description }}</td>
                        <td>{{ $user_question->group_question->questions->count() }}</td>
                        <td>{{ $user_question->group_question->is_published }}</td>
                        <td>
                            <a class="btn btn-sm btn-secondary" href="{{ route('omni-questionnaire.create', ['questionnaire_id' => $user_question->group_question_id]) }}">
                                Show
                            </a>
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

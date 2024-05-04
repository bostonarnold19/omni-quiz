@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('group-question.index') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Exam</h3>
            <a href="#" class="btn btn-outline-primary push"  data-toggle="modal" data-target="#add-modal">Add New Exam</a>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Passing Grade</th>
                        <th>Items</th>
                        <th>Published</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="app">
    @include('modules.group_question.includes._modal_add_group_question')
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('group-question.index') }}',
            columns: [
                { data: 'type', name: 'type' },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'passing', name: 'passing' },
                { data: 'questions_count', name: 'questions_count', searchable: false, orderable: false },
                { data: 'is_published', name: 'is_published' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    $(".validate-number-only").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });
</script>
@endsection

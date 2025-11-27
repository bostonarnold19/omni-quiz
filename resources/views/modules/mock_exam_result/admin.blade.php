@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('mock-exam-result.index') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Mock Exam Results - All Students</h3>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter" id="datatable">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('css/datatable-button.css')}}">
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{asset('js/datatable-button.js')}}"></script>
<script src="{{asset('js/datatable-print.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#datatable').DataTable( {
        processing: true,
        serverSide: true,
        ajax: "{{ route('mock-exam-result.create') }}",
        columns: [
            {data: 'student_id', name: 'student_id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'course', name: 'course'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    });
    $('#datatable input').attr('name', 'search_text');
});
</script>
@endsection


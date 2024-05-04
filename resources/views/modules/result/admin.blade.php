@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('user.index') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">User</h3>
            {{-- @ability('Admin', 'add_user') --}}
            <button type="button" class="btn btn-outline-primary push" data-toggle="modal" data-target="#add-modal">Add New User</button>
            {{-- @endability --}}
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th><i class="far fa-user"></i></th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    jQuery("#datatable").dataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('result.create') }}',
        columns : [
            {data: 'profile_picture', orderable: false, searchable: false},
            {data: 'name'},
            {data: 'student_id'},
            {data: 'username'},
            {data: 'email'},
            {data: 'role'},
            {data: 'action', orderable: false, searchable: false}
        ],
        columnDefs: [
            {targets: 0, className: "text-center", width: "10%" },
        ],
        order: [
            [ 1, "desc" ]
        ],
        pageLength: 50,
        lengthMenu: [
            [5, 10, 20, 50],
            [5, 10, 20, 50]
        ],
        autoWidth: !1,
    });
</script>
@endsection

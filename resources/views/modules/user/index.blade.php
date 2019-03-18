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
@include('user::includes._modal_edit')
@include('user::includes._modal_add')
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
        ajax: '{{ route('user.index') }}',
        columns : [
            {data: 'profile_picture', orderable: false, searchable: false},
            {data: 'name'},
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
        pageLength: 5,
        lengthMenu: [
            [5, 10, 20],
            [5, 10, 20]
        ],
        autoWidth: !1,
    });
    $(document).on('click', '[id=btn-edit]', function(){
        var id = $(this).data('id');
        var show_route = '{{ route('user.show', ':id') }}';
        var update_route = '{{ route('user.update', ':id') }}';
        show_route = show_route.replace(':id', id);
        update_route = update_route.replace(':id', id);
        if (id) {
            $.ajax({
                method: 'get',
                url: show_route,
                jsonp: false,
                success: function(result) {
                    $('[id=id]').val(result.id);
                    $('[id=first_name]').val(result.first_name);
                    $('[id=last_name]').val(result.last_name);
                    $('[id=email]').val(result.email);
                    $("[id=roles]").val(result.roles).trigger("change");
                    $("[id=update-form]").attr("action", update_route);
                    $('[id=edit-modal]').modal();
                }
            });
        }
    });
    jQuery(".js-select2:not(.js-select2-enabled)").each(function(e, a) {
        var t = jQuery(a);
        t.addClass("js-select2-enabled").select2({
            width: "100%",
            placeholder: t.data("placeholder") || !1
        })
    })
</script>
@endsection

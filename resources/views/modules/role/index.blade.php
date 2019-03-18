@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('role.index') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Role</h3>
            {{-- @ability('Admin', 'add_role') --}}
            <button type="button" class="btn btn-outline-primary push" data-toggle="modal" data-target="#add-modal">Add New Role</button>
            {{-- @endability --}}
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@include('role::includes._modal_edit')
@include('role::includes._modal_add')
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    jQuery("#datatable").dataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('role.index') }}',
        columns : [
            {data: 'name'},
            {data: 'action', orderable: false, searchable: false}
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
        var show_route = '{{ route('role.show', ':id') }}';
        var update_route = '{{ route('role.update', ':id') }}';
        show_route = show_route.replace(':id', id);
        update_route = update_route.replace(':id', id);
        if (id) {
            $.ajax({
                method: 'get',
                url: show_route,
                jsonp: false,
                success: function(result) {
                    $('[id=id]').val(result.id);
                    $('[id=name]').val(result.name);
                    $(".edit-perm").prop("checked", false);
                    for (var i = result.permissions.length - 1; i >= 0; i--) {
                        $('#edit-perm-' + result.permissions[i]).prop('checked', true);
                    }
                    $("[id=update-form]").attr("action", update_route);
                    $('[id=edit-modal]').modal();
                }
            });
        }
    });
</script>
@endsection

@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('codes') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Codes</h3>
        </div>
        <div class="block-content block-content-full">
             <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questionnaire_codes as $questionnaire_code)
                    <tr>
                        <td>{{ $questionnaire_code->user->student_id }}</td>
                        <td>{{ $questionnaire_code->user->first_name }} {{ $questionnaire_code->user->last_name }}</td>
                        <td>{{ $questionnaire_code->codes }}</td>
                        <td>
                            <button class="btn btn-sm btn-secondary">Print Questionnaire</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#datatable').DataTable( {
    } );

    new $.fn.dataTable.FixedHeader( table );
} );
</script>
@endsection

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
                    @foreach($questionaires as $questionaire)
                    <tr>
                        <td>{{ $questionaire->type }}</td>
                        <td>{{ $questionaire->title }}</td>
                        <td>{{ $questionaire->description }}</td>
                        <td>{{ $questionaire->passing ? $questionaire->passing : '0' }} %</td>
                        <td>{{ $questionaire->questions->count() }}</td>
                        <td>{{ $questionaire->is_published }}</td>
                        <td>
                            <a href="{{ route('group-question.edit', $questionaire->id) }}"  data-toggle="modal" data-target="#edit-modal-{{$questionaire->id}}" class="btn btn-sm btn-secondary">Edit</a>
                            @php
                                $ids = [];
                                foreach ($questionaire->questions as $question) {
                                    $ids[] = $question->id;
                                }
                            @endphp
                            @include('modules.group_question.includes._modal_edit_group_question')
                            <form style="display:inline;" method="POST" action="{{ route('group-question.destroy', $questionaire->id) }}" onsubmit="return confirm('Are you sure you want to delete tihs?')">
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
<script >
    $(document).ready(function() {
    var table = $('#datatable').DataTable( {
    } );

    new $.fn.dataTable.FixedHeader( table );
} );
    var add_table = $('.question_tables').DataTable();
    $(document).on('click','.add-checkbox-question', function(){
        var matches = [];
        var checkedcollection = add_table.$(".add-checkbox-question:checked", { "page": "all" });
        checkedcollection.each(function (index, elem) {
            matches.push($(elem).val());
        });

        var AccountsJsonString = JSON.stringify(matches);
        $('[id=add_questions]').val(AccountsJsonString)
        // alert(AccountsJsonString);
    });

    $(document).on('click','.edit-checkbox-question', function(){
        var matches = [];
        var g_id = $(this).data('id')
        var checkedcollection = add_table.$(".group-id-"+g_id+":checked", { "page": "all" });
        checkedcollection.each(function (index, elem) {
            matches.push($(elem).val());
        });

        var AccountsJsonString = JSON.stringify(matches);
        $('[id=edit_questions_'+g_id+']').val(AccountsJsonString)
    });

    $(".validate-number-only").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });

    $(document).on('change', '.validate-number-only', function(){
        var value =  $(this).val();
        console.log(value)
    });
</script>
@endsection

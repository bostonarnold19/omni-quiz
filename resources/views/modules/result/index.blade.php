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
             <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>EXAMINATION TYPE</th>
                        <th>Subject</th>
                        <th>Rating</th>
                        <th>CORRECT ANSWERS</th>
                        <th>NO. of Items</th>
                        <th>Result</th>
                        <th>Exam Date</th>
                        <th>Last Date taken</th>
                        <th>Result</th>
                        <th>Rating</th>
                        <th>No. of Takes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questionnaire_codes as $questionnaire_code)
                    @php
                    $f_answers = $questionnaire_code->first()->answers;
                    $f_correct = 0;
                    $l_correct = 0;
                    $items = $questionnaire_code->last()->questionnaire->questions()->count();
                    $f_correct = $questionnaire_code->first()->result;
                    if ($questionnaire_code->count()) {
                        $l_correct = $questionnaire_code->last()->result;
                    }
                    @endphp
                        <td>{{ $questionnaire_code->first()->user->student_id }}</td>
                        <td>{{ $questionnaire_code->first()->user->first_name }} {{ $questionnaire_code->first()->user->last_name }}</td>
                        <td>{{ $questionnaire_code->first()->questionnaire->course }}</td>
                        <td>{{ $questionnaire_code->first()->questionnaire->type }}</td>
                        <td>{{ $questionnaire_code->first()->questionnaire->subject }}</td>
                        <td>{{  number_format((($f_correct / $items) * 100), 2) }} % </td>
                        <td>{{$f_correct}}</td>
                        <td>{{ $items }}</td>
                        <td> {{$f_correct}} / {{$items}} </td>
                        <td> {{ $questionnaire_code->first()->questionnaire->created_at->format('d/m/Y') }}</td>
                        <td> {{ $questionnaire_code->last()->questionnaire->created_at->format('d/m/Y') }}</td>
                        <td> {{$l_correct}} / {{$items}} </td>
                        <td> {{  number_format((($l_correct / $items) * 100), 2) }} %  </td>
                        <td> {{ $questionnaire_code->count() }} </td>
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

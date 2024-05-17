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
                            <th width="120">Rating</th>
                            <th>CORRECT ANSWERS</th>
                            <th>Result</th>
                            <th>Exam Date</th>
                            <th>No. of Takes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($questionnaire_codes)

                            @foreach($questionnaire_codes as $questionnaire_code)
                            @php

                            if(!$questionnaire_code->where('is_official', 1)->first()->user) {
                                continue;
                            }

                            $items = @$questionnaire_code->first()->questionnaire->questions()->count();
                            @endphp
                            <tr>
                                <td>{{ @$questionnaire_code->where('is_official', 1)->first()->user->student_id }}</td>
                                <td>{{ @$questionnaire_code->where('is_official', 1)->first()->user->first_name }} {{ @$questionnaire_code->where('is_official', 1)->first()->user->last_name }}</td>
                                <td>{{ @$questionnaire_code->where('is_official', 1)->first()->questionnaire->course }}</td>
                                <td>{{ @$questionnaire_code->where('is_official', 1)->first()->questionnaire->type }}</td>
                                <td>{{ @$questionnaire_code->where('is_official', 1)->first()->questionnaire->subject }}</td>
                                <td>
                                    @foreach($questionnaire_code as $question)
                                    @if($question->result != 0)
                                    {{  number_format((($question->result / $items) * 100), 2) }} % <br>
                                    @else
                                    0 % <br>
                                    @endif
                                    @endforeach
                                </td>


                                <td>
                                    @foreach($questionnaire_code as $question)
                                    {{ $question->result == null ? 0 : $question->result }} <br>
                                    @endforeach
                                </td>


                                <td>
                                    @foreach($questionnaire_code as $question)
                                    {{ $question->result != 0 ? $question->result : '0'}} / {{$items}}<br>
                                    @endforeach
                                </td>



                                <td>
                                    @foreach($questionnaire_code as $question)
                                    {{ $question->created_at->format('d/m/Y') }}<br>
                                    @endforeach
                                </td>

                                <td> {{ $questionnaire_code->count() }} </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css')
    }}">
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
    dom: 'Bfrtip',
    buttons: [
    'print'
    ]
    } );
    $('#datatable input').attr('name', 'search_text');
    // new $.fn.dataTable.FixedHeader( table );
    } );
    $(document).on('click', '#btn-print-report', function(){
    var val = $(this).val();
    var query = $('#dataTables_filter input.form-controlform-control-sm').val()
    });
    </script>
    @endsection

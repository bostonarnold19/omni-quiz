@extends('layouts.dashmix')
@section('breadcrumbs')
{{-- {{ Breadcrumbs::render('omni-questionnaire.create', $questionnaire_code->questionnaire) }} --}}
@endsection
@section('content')
<style type="text/css">
    [v-cloak] {display: none}
</style>
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-content block-content-full">
            <div id="app" v-cloak>
                <div v-if="done">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 v-if="((score/items) * 100) >= passing">@{{ ((score/items) * 100) }} % <br> Congrats!</h3>
                            <h3 v-else>@{{ ((score/items) * 100) }} % <br> Failed</h3>
                            <h4></h4>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <h1 style="font-weight: bold; text-align: center;" id="demo"></h1>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>@{{ question.question }}</h4>
                            <div class="form-group">
                                <ol>
                                    <li v-for="(option_v, option_k) in options" @click="selectAnswer(option_v.id)">
                                      <span>@{{ alphabet[option_k] }}.</span>
                                      <div class="custom-control custom-radio custom-control-primary mb-1">
                                          <input type="radio" class="custom-control-input" v-model="ans" name="ans" :id="option_k" :value="option_v.id">
                                          <label class="custom-control-label" :for="option_k">@{{ option_v.description }}</label>
                                      </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button v-on:click="nextBtn" class="btn btn-lg btn-success">Next</button>
                            <button v-on:click="skipSS" class="btn btn-lg btn-warning " id="btn-skip">Skip</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/sweetalert2/dist/sweetalert2.min.css') }}">
<style>
    .correct {
        color:green;
    }
    .wrong {
        color:red;
    }
     .form-group-item:has(.custom-radio > label.correct) {
        border:1px solid green;
        background:#00800021;
    }
     .form-group-item:has(.custom-radio > label.wrong) {
        border:1px solid red;
        background:#ff000021;
    }
    .form-group ol li{
        margin:10px;
        padding:5px 10px;
        border-radius: 15px;
        flex-basis: 45%;
        box-sizing: border-box;
        list-style-position:inside;
        border: 1px solid black;
        cursor: pointer;
        display: flex;
    }
    .form-group ol{
        display: flex;
        flex-wrap: wrap;
    }
    .custom-control {
        margin-left: 10px;
    }
</style>
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2/dist/sweetalert2.js') }}"></script>
<script src="{{ asset('/js/vue.js') }}"></script>
<script>
    window.publicUrl = "{{url('/')}}";
    window.questionnaireCode = @json($questionnaire_code);
</script>
<script src="{{ asset('/js/exam-mode.js') }}"></script>
@endsection

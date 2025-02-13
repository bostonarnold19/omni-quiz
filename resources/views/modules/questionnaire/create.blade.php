@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('omni-questionnaire.create', $questionnaire_code->questionnaire) }}
@endsection
@section('content')
<style type="text/css">
    [v-cloak] {display: none}
</style>
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
        </div>
        <div class="block-content block-content-full">
            <img class="water-mark" src="{{asset('img/Logo_MTC_1-removebg-preview.png')}}" alt="">
            <div id="app" v-cloak>
                <div v-if="done">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 v-if="((score/items) * 100) >= passing">@{{ ((score/items) * 100).toFixed(2) }} % <br> Congrats!</h3>
                            <h3 v-else>@{{ ((score/items) * 100).toFixed(2) }} % <br> Failed</h3>
                            <h4></h4>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="col-md-12">
                        <h1 style="font-size:1.5rem;font-weight: bold; text-align: right;" id="demo"></h1>
                        <center>
                            <div style="text-align: center;font-weight: bold;font-size: 2rem;margin-top: -5%;margin-bottom: 5%;">Items Left: @{{itemsLeft}}</div>
                        </center>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 :style="question.image_link ? 'margin-bottom:0px' :''">@{{ question.question }}</h4>
                            <a v-if="question.image_link"  :href="question.image_link" target="_blank">See Image</a>
                            <div class="form-group" :style="question.image_link ? 'margin-top:1.375rem' : ''">
                                <ol>
                                  <li type="a" v-for="(option_v, option_k) in options">
                                    <span>@{{ alphabet[option_k] }}.</span>
                                    <div class="custom-control custom-radio custom-control-primary mb-1">
                                        <label class="custom-control-label" :for="option_k">@{{ option_v.description }}</label>
                                    </div>
                                  </li>
                                </ol>
                                <div class="option-select">
                                    <ul>
                                        <li class="selected-option">
                                            <span v-if="alphabetAnswer" style="text-decoration: underline;font-weight:bold;font-size:1.2rem">
                                                @{{ alphabetAnswer }}
                                            </span>
                                            <span v-else>____</span>
                                        </li>
                                        <li v-for="(option_v, option_k) in options"  style="font-weight:bold;font-size:1.2rem"  @click="selectAnswer(option_v, alphabet[option_k])">@{{ alphabet[option_k] }}</li>
                                        <li class="selected-option"  style="font-weight:bold;font-size:1.2rem"  @click="skipSS" id="btn-skip">Skip</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="display: flex">
                            <button v-if="alphabetAnswer" v-on:click="nextBtn" class="btn btn-lg accept-button">Accept</button>
                            <button v-else class="btn btn-lg btn-secondary accept-button">Accept</button>
                            {{-- <button v-on:click="skipSS" class="btn btn-lg btn-warning " id="btn-skip">Skip</button> --}}
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


    @media screen and (max-width: 544px) {
        .form-group ol{
            display: unset !important;
        }
        .option-select ul li {
            margin:0px 2px;
        }
        .option-select ul {
            margin-left:-15% !important;
            margin-top:20px !important;
        }
    }
    .option-select .selected-option {
        background:unset;
        color:black;
    }
    .accept-button {
        margin:auto;
        margin-top:30px;
        background: #259ade;
        color: white;
        font-weight: normal !important;
    }
    .option-select {
        display:flex;
    }
    .option-select ul {
        display: flex;
        margin:auto;
    }
    .option-select li {
        list-style: none;
        cursor: pointer;
        padding:20px;
        background: #259ade;
        color: white;
        margin: 0px 25px;
        text-transform:capitalize;
        cursor: pointer;
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
    .block-content-full {
        overflow: hidden;
        position: relative;
    }
    .water-mark {
        opacity: 0.2;
        position: absolute;
        left: 0;
        top: 50%;
        width: 50%;
        height: auto;
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
<script src="{{ asset('/js/question.js') }}"></script>
@endsection

@extends('layouts.dashmix')
@section('breadcrumbs')
@endsection
@section('content')
<style type="text/css">
    [v-cloak] {display: none}
</style>
<div class="content" id="app" v-cloak>
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <a href="javascript:void(0)" @click="destroy" class="btn btn-danger float-left">Exit</a>
            <a href="javascript:void(0)" @click="save" class="btn btn-danger float-right">Save and Exit</a>
        </div>
        <div class="block-content block-content-full">
            <img class="water-mark" src="{{asset('img/Logo_MTC_1-removebg-preview.png')}}" alt="">
            <div >
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
                            <h4 :style="question.image_link ? 'margin-bottom:0px' :''">@{{ question.question }}</h4>
                            <a v-if="question.image_link"  :href="question.image_link" target="_blank">See Image</a>
                            <div class="form-group" :style="question.image_link ? 'margin-top:1.375rem' : ''">
                                <ol>
                                  <li type="a" class="form-group-item" v-for="(option_v, option_k) in options" >
                                    <span>@{{ alphabet[option_k] }}.</span>
                                    <div class="custom-control custom-radio custom-control-primary mb-1">
                                        <template v-if="ans">
                                            <label v-if="ans.id == option_v.id" class="custom-control-label" :class="ans.id == option_v.id && ans.is_correct ? 'correct' : 'wrong' "  :for="option_k">@{{ option_v.description }}</label>
                                            <label v-else class="custom-control-label" :class="option_v.is_correct ? 'correct' : ''" :for="option_k">@{{ option_v.description }}</label>
                                        </template>
                                        <template v-else>
                                            <label class="custom-control-label"  :for="option_k">@{{ option_v.description }}</label>
                                        </template>
                                    </div>
                                    {{-- v-model="ans" --}}
                                  </li>
                                </ol>
                            </div>

                            <div class="option-select">
                                <ul>
                                    <li v-for="(option_v, option_k) in options"  @click="selectAnswer(option_v)">@{{ alphabet[option_k] }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12" style="display: flex;">
                            <button v-on:click="getQuestion" class="btn btn-lg  accept-button">Accept</button>
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
            margin-left:0px !important;
            margin-top:20px !important;
        }
    }
    .accept-button {
        margin:auto;
        margin-top:30px;
        background: #259ade;
        color: white;
        font-weight: normal !important;
    }
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
    .block-content-full {
        overflow: hidden;
        position: relative;
    }
    .water-mark {
        opacity: 0.2;
        position: absolute;
        left: 0;
        top: 75%;
        width: 25%;
        height: auto;
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
        padding:20px;
        background: #259ade;
        color: white;
        margin: 0px 25px;
        text-transform:capitalize;
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
    window.subject = "{{@$data['subject']}}";
    window.course = "{{@$data['course']}}";
</script>
<script src="{{ asset('/js/study-mode.js') }}"></script>
@endsection

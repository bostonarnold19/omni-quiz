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
                                  <li type="a" v-for="(option_v, option_k) in options">
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

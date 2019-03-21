@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('questionnaire.create', $group_question) }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
        </div>
        <div class="block-content block-content-full">
            <div id="app">
                <div v-if="done">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1 style="font-size: 10em;">@{{ score }}/@{{ items }}</h1>
                            <h4></h4>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>@{{ question.question }}</h4>
                            <div class="form-group">
                                <ol>
                                  <li type="a" v-for="(option_v, option_k) in options">
                                    <div class="custom-control custom-radio custom-control-primary mb-1">
                                        <input type="radio" class="custom-control-input" name="ans" :id="option_k">
                                        <label class="custom-control-label" :for="option_k">@{{ option_v.description }}</label>
                                    </div>
                                  </li>
                                </ol>


                            </div>
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
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/js/vue.js') }}"></script>
<script>
    window.publicUrl = "{{url('/')}}";
    window.groupQuestion = @json($group_question);
</script>
<script src="{{ asset('/js/question.js') }}"></script>
@endsection

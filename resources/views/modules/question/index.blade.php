@extends('layouts.dashmix')
@section('breadcrumbs')
{{ Breadcrumbs::render('question.index') }}
@endsection
@section('content')
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Question</h3>
            <a href="#" class="btn btn-outline-primary push"  data-toggle="modal" data-target="#add-modal">Add New Question</a>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter" id="datatable">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Subject</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div id="app">
    @include('modules.question.includes._modal_add_question')
    @include('modules.question.includes._modal_edit_question')
</div>
@endsection
@section('styles')
<style type="text/css">
    .is_correct_btn{
        color:#d6d3d3;
        cursor: pointer;
    }
    .is_correct_btn.active{
        color:green;
    }
</style>
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('themes/dashmix/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection
@section('scripts')
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('themes/dashmix/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/js/vue.js') }}"></script>
<script>
    window.publicUrl = "{{url('/')}}";
    var app;

    $(document).ready(function () {
        jQuery("#datatable").dataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("question.index") }}',
            columns: [
                {data: 'question'},
                {data: 'subject'},
                {data: 'course'},
                {data: 'action', orderable: false, searchable: false}
            ],
            pageLength: 20,
            lengthMenu: [
                [5, 10, 20],
                [5, 10, 20]
            ],
            autoWidth: false,
            drawCallback: function (settings) {
                // Only initialize Vue if it's not already initialized
                if (!app) {
                    app = new Vue({
                        el: '#app',
                        // Your Vue.js code here
                        data () {
                            return {
                                question_options:[],
                                url:{
                                    routeGetQuestion:window.publicUrl+"/question/",
                                },
                                question:{
                                    id:'',
                                    question:'',
                                    time:'',
                                    minute:'',
                                    second:'',
                                    is_correct:[],
                                    question_options:[],
                                },
                            }
                        },
                        mounted: function(){
                            var _this = this;
                            
                            $(document).on('click', '.is_correct_btn', function(){
                                var key = $(this).data('id');
                                var input = $(this).data('text');
                                var is_data = JSON.parse($('#is_correct').val());
                                var is_e_data = JSON.parse($('#is_correct_edit').val());
                                // $('.is_correct_btn').removeClass('active');
                                if ($(this).hasClass('active')) {
                                    if (input == "#is_correct") {
                                        var ni = _this.getKeyArray(key, is_data);
                                        if (ni != 'empty') {
                                            is_data.splice(parseInt(ni), 1)
                                            $(input).val(JSON.stringify(is_data));
                                        }
                                    }else if (input == "#is_correct_edit") {
                                        var ni = _this.getKeyArray(key, is_e_data);
                                        if (ni != 'empty') {
                                            is_e_data.splice(parseInt(ni), 1)
                                            $(input).val(JSON.stringify(is_e_data));
                                        }
                                    }
                                    $(this).removeClass('active');
                                }else{
                                    if (input == "#is_correct") {
                                        is_data.push(key)
                                        $(input).val(JSON.stringify(is_data));
                                    }else if (input == "#is_correct_edit") {
                                        is_e_data.push(key)
                                        $(input).val(JSON.stringify(is_e_data));
                                    }
                                    $(this).addClass('active');

                                }

                                // $('#is_correct').val(key);
                                // $('#is_correct_edit').val(key);
                                // console.log(is_data, is_e_data)
                            })

                            $(document).on('click', '.button-edit', function(){
                                var key = $(this).data('id');

                                app.editQuestion(key);  // Call the Vue method
                            })

                        },
                        methods:{
                            editQuestion(id) {
                                var _this = this;

                                var key = id;
                                $.ajax({
                                    method: 'get',
                                    url: _this.url.routeGetQuestion+key,
                                    jsonp: false,
                                    success: function(response){
                                        _this.question = response;
                                        $('#edit-modal').modal();
                                    },
                                });
                            },
                            addOption:function(){
                                var _this = this
                                _this.question_options.push([]);
                            },
                            removeOption: function(key){
                                var _this = this
                                _this.question_options.splice(key,1);   
                            },
                            addEditOption:function(){
                                var _this = this
                                _this.question.question_options.push([]);
                            },
                            removeEditOption: function(key){
                                var _this = this
                                _this.question.question_options.splice(key,1);   
                            },
                            getKeyArray: function(needle, haystack) {
                                var length = haystack.length;
                                for(var i = 0; i < length; i++) {
                                    if(haystack[i] == needle) return i;
                                }
                                return 'empty';
                            },
                        }
                    });
                } else {
                    app.$forceUpdate(); // Re-render the Vue instance if it's already initialized
                }
            }
        });
    });
</script>
@endsection

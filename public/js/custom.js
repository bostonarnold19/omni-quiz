const app = new Vue({
    el: '#app',
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
                is_correct:'',
                question_options:[],
            },
        }
    },
    mounted: function(){
        var _this = this;
        
        $(document).on('click', '.is_correct_btn', function(){
            var key = $(this).data('id');
            $('.is_correct_btn').removeClass('active');
            $(this).addClass('active');
            $('#is_correct').val(key);
            $('#is_correct_edit').val(key);
        })

        $(document).on('click', '.button-edit', function(){
            var key = $(this).data('id');
            $.ajax({
                method: 'get',
                url: _this.url.routeGetQuestion+key,
                jsonp: false,
                success: function(response){
                    _this.question = response;
                    $('#edit-modal').modal();
                },
            });
        })

    },
    created: function(){	
    },
    methods:{
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
        }
    }
});


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


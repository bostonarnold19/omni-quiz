const app = new Vue({
    el: '#app',
    data () {
        return {
            question_options:[],
            url:{
                routeGetQuestion: window.publicUrl+"/questionnaire/create?questionnaire_id=" + window.groupQuestion.id,
            },
            question:{
                id:'',
                question:'',
                time:'',
                is_correct:'',
                question_options:[],
            },
        }
    },
    mounted: function(){
        var _this = this;

        $.ajax({
            method: 'get',
            url: _this.url.routeGetQuestion,
            jsonp: false,
            success: function(response){
                var result = response.data;
                console.log(result);
            },
        });

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


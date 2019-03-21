const app = new Vue({
    el: '#app',
    data () {
        return {
            question_options:[],
            url:{
                routeGetQuestion: window.publicUrl+"/questionnaire/create?questionnaire_id=" + window.groupQuestion.id,
            },
            question: {
                question: '',
            },
            options: [],
            user_question: {
                time_start: null,
                time_end: null,
            },
            score: 0,
            items: 0,
            user_questions: [],
            done: false,
        }
    },
    mounted: function(){
        var _this = this;

        $.ajax({
            method: 'get',
            url: _this.url.routeGetQuestion,
            jsonp: false,
            success: function(response){
                if(response.done) {
                    _this.done = response.done;
                    _this.score = response.score;
                    _this.items = response.items;
                    _this.user_questions = response.user_questions;
                } else {
                    _this.question = response.question;
                    _this.options = response.options;
                    _this.user_question = response.user_question;
                }
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


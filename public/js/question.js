const app = new Vue({
    el: '#app',
    data () {
        return {
            question_options:[],
            url:{
                routeGetQuestion: window.publicUrl+"/omni-questionnaire/create?questionnaire_id=" + window.groupQuestion.id,
                routeAnsQuestion: window.publicUrl+"/omni-questionnaire",
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
            ans: '',
            user_questions_taken: [],
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
                    _this.user_questions_taken = response.user_questions_taken
                }
            },
        });

    },
    created: function(){
    },
    methods:{
        nextBtn:function(){
            var _this = this;
            var data = _this.user_question;
            data.question_option_id = _this.ans;
            data.user_questions_taken = _this.user_questions_taken;
            data._token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                method: 'POST',
                url: _this.url.routeAnsQuestion,
                data: data,
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
                            _this.user_questions_taken = response.user_questions_taken
                        }

                },
            });

        }
    }
});


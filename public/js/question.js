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
            ans: null,
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

                    _this.timer(_this.user_question.time_end.date);
                }
            },
        });

    },
    created: function(){
    },
    methods:{
        timer: function(time){
            var _this = this;
            clearInterval(window.x);
            var deadline = new Date(time).getTime();
            window.x = setInterval(function() {
                var now = new Date().getTime();
                var t = deadline - now;
                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60));
                var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((t % (1000 * 60)) / 1000);
                document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";
                    if (t < 0) {
                        clearInterval(window.x);
                        _this.nextBtn()
                    }
            }, 1000);
        },
        nextBtn:function(){
            var _this = this;

            if(_this.ans == null) {
                _this.ans = 'x';
            }

            var data = _this.user_question;
            data.question_option_id = _this.ans;
            data.user_questions_taken = _this.user_questions_taken;

            _this.ans = null;

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
                            _this.timer(_this.user_question.time_end.date);
                        }

                },
            });

        }
    }
});


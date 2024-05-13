const app = new Vue({
    el: '#app',
    data () {
        return {
            question_options:[],
            url:{
                routeGetQuestion: window.publicUrl+"/omni-questionnaire/create?codes=" + window.questionnaireCode.codes,
                routeAnsQuestion: window.publicUrl+"/omni-questionnaire",
            },
            question: {
                question: '',
            },
            questionnaire_code: {},
            options: [],
            answer: {
            },
            score: 0,
            items: 0,
            answers: [],
            done: false,
            ans: null,
            passing: null,
            skip: 0,
            alphabet:[
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'
            ],
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
                    _this.passing = response.passing;

                    var grade = ((_this.score/_this.items) * 100) >= _this.passing;
                    var msg = 'Congrats';
                    var type = 'success';
                    var ave = ((_this.score/_this.items) * 100) + "%";

                    if(grade == false) {
                        msg = 'Failed';
                        type = 'error';
                    }

                    Swal.fire(
                      msg,
                      ave,
                      type
                    );

                } else {
                    _this.question = response.question;
                    // _this.options = _this.fisherYates(response.options);
                    _this.options = response.options;
                    _this.answer = response.answer;
                    _this.questionnaire_code = response.questionnaire_code;
                    console.log(_this.questionnaire_code);
                    _this.timer(_this.questionnaire_code.time_end);
                }
            },
        });


    },
    created: function(){

    },
    methods:{
        selectAnswer(answer) {
            this.ans = answer
        },
        timer: function(time){
            console.log(time);
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
        fisherYates: function( array ){
         var count = array.length,
             randomnumber,
             temp;
         while( count ){
          randomnumber = Math.random() * count-- | 0;
          temp = array[count];
          array[count] = array[randomnumber];
          array[randomnumber] = temp
         }
         return array;
        },

        skipSS:function(){
            var _this = this;

            _this.ans = null;
            $('[id=btn-skip]').attr('disabled',true);
            var data = _this.answer;
            data.question_option_id = _this.ans;
            data.answers = _this.answers;
            data.questionnaire_code = _this.questionnaire_code;

            _this.skip++;

            data.skip = _this.skip;

            _this.ans = null;

            data._token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                method: 'POST',
                url: _this.url.routeAnsQuestion,
                data: data,
                jsonp: false,
                success: function(response){
            $('[id=btn-skip]').removeAttr('disabled');

                      if(response.done) {
                            _this.done = response.done;
                            _this.score = response.score;
                            _this.items = response.items;


                        } else {
                            _this.question = response.question;
                            _this.options = response.options;
                            // _this.options = _this.fisherYates(response.options);
                            _this.answer = response.answer;
                            _this.skip = response.skip
                            // _this.timer(_this.answer.time_end.date);
                        }

                },
            });

        },



        nextBtn:function(){
            var _this = this;

            if(_this.ans == null) {
                _this.ans = 'x';
            }


            var data = _this.answer;
            data.question_option_id = _this.ans;
            data.answers = _this.answers;
            data.questionnaire_code = _this.questionnaire_code;

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
                            _this.passing = response.passing;

                            var grade = ((_this.score/_this.items) * 100) >= _this.passing;
                    var msg = 'Congrats';
                    var type = 'success';
                    var ave = ((_this.score/_this.items) * 100) + "%";

                    if(grade == false) {
                        msg = 'Failed';
                        type = 'error';
                    }

                    Swal.fire(
                      msg,
                      ave,
                      type
                    );


                        } else {
                            // console.log(response.answer);
                            _this.question = response.question;
                    _this.options = response.options;
                            // _this.options = _this.fisherYates(response.options);
                            _this.answer = response.answer;
                            // _this.timer(_this.answer);
                        }

                },
            });

        }
    }
});


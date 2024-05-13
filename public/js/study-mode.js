const app = new Vue({
    el: '#app',
    data () {
        return {
            question_options:[],
            url:{
                routeGetQuestion: window.publicUrl+"/study-mode/store",
            },
            question: {
                question: '',
            },
            questionnaire_code: {},
            options: [],
            answer: {},
            score: 0,
            items: 0,
            answers: [],
            done: false,
            ans: null,
            passing: null,
            skip: 0,
            questionIds:[],
            alphabet:[
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'
            ],
        }
    },
    mounted: function(){
        this.getQuestion()
    },
    created: function(){

    },
    methods:{
        selectAnswer(answer) {
            this.ans = answer
        },
        getQuestion() {
            var _this = this;
            let data = {};
            data._token = $('meta[name="csrf-token"]').attr('content');
            data.question_ids = _this.questionIds;
            data.subject = window.subject;
            data.course = window.course;

            $.ajax({
                method: 'POST',
                url: _this.url.routeAnsQuestion,
                data: data,
                jsonp: false,
                success: function(response){
                    if (!response.question) {
                        window.location.href = `${window.publicUrl}/dashboard`;
                        return;
                    }
                    _this.question = response.question;
                    _this.options = response.question.options;
                    _this.answer = response.answer;
                    _this.questionnaire_code = response.questionnaire_code;
                    _this.ans = null
                    _this.questionIds.push(response.question.id)
                },
            });
        },
    }
});


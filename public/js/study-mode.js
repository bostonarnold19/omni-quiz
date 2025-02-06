const app = new Vue({
    el: '#app',
    data () {
        return {
            question_options:[],
            url:{
                routeGetQuestion: window.publicUrl+"/study-mode/store",
                routeUpdateQuestion: window.publicUrl+"/study-mode-history",
                routeDeleteQuestion: window.publicUrl+"/study-mode-history/delete",
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
            alphabetAnswer:'',
        }
    },
    mounted: function(){
        this.getQuestion()
    },
    created: function(){

    },
    methods:{
        selectAnswer(answer, alphabet) {
            this.ans = answer
            this.alphabetAnswer = alphabet
        },
        save() {
            let data = {
                question_id: this.question.id,
                subject: this.question.subject,
                subtopic: this.question.subtopic,
            }
            let _this = this

            data._token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: 'POST',
                url: `${_this.url.routeUpdateQuestion}/${data.question_id}/update`,
                data: data,
                jsonp: false,
                success: function(response){
                    window.location.href = `${window.publicUrl}/dashboard`;
                },
            });
        },
        destroy() {
            let data = {
                question_id: this.question.id,
                subject: this.question.subject,
                subtopic: this.question.subtopic,
            }
            let _this = this

            data._token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: 'POST',
                url: `${_this.url.routeDeleteQuestion}`,
                data: data,
                jsonp: false,
                success: function(response){
                    window.location.href = `${window.publicUrl}/dashboard`;
                },
            });
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
                    // if (!response.question) {
                    //     window.location.href = `${window.publicUrl}/dashboard`;
                    //     return;
                    // }
                    _this.question = response.question;
                    _this.options = response.question.options;

                    // if (response.question.options.length < 4) {
                    //     _this.options.push({
                    //         created_at: '',
                    //         description: 'None of the above',
                    //         id: 'skip',
                    //         is_correct: '',
                    //         question_id: '',
                    //         updated_at: '',
                    //     })
                    // } 
                    _this.answer = response.answer;
                    _this.questionnaire_code = response.questionnaire_code;
                    _this.ans = null
                    _this.questionIds.push(response.question.id)
                },
            });
        },
    }
});


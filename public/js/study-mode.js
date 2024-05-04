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
        }
    },
    mounted: function(){
        this.getQuestion()
    },
    created: function(){

    },
    methods:{
        getQuestion() {
            var _this = this;
            let data = {};
            data._token = $('meta[name="csrf-token"]').attr('content');
            data.question_ids = _this.questionIds;
            $.ajax({
                method: 'POST',
                url: _this.url.routeAnsQuestion,
                data: data,
                jsonp: false,
                success: function(response){
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


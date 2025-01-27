const app = new Vue({
    el: '#app',
    data () {
        return {
        	subjects:{},
        	selectedSubject:''
        }
    },
    mounted: function(){
    	this.javascript()
    },
    created: function(){

    },
    methods:{
    	javascript() {
    		this.subjects = JSON.parse(document.getElementById('subject-selector').value)
    	}
    }
});
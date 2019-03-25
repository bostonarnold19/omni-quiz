<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="save-form" method="POST" action="{{ route('question.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Question</label>
                                <input type="text" class="form-control" name="question" placeholder="Question" required>
                                <input type="hidden" class="form-control" name="type" value="multiple choice">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control" name="subject" v-model="question.subject" placeholder="Subject" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Course</label>
                                <input type="text" class="form-control" name="course" v-model="question.course" placeholder="Course" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12" style="padding: 20px 15px;">
                            <div class="row" style="margin-bottom:20px">
                                <div class="col-xl-12">
                                    <label>Question Options</label>
                                    <span class="btn btn-outline-primary" v-on:click="addOption" style="float:right">Add Options</span>
                                </div>
                            </div>
                            <input type="hidden" name="is_correct" id="is_correct">
                            <div class="questions_options row" v-for="(options, key) in question_options">
                                <div class="col-sm-9">
                                    <input type="text" name="description[]" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <span class="is_correct_btn" :data-id="key">Correct Answer</span>
                                    <span style="color:red;cursor:pointer" v-on:click="removeOption(key)">Remove</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="submit" form="save-form" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>

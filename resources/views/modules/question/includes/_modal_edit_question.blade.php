<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form method="POST" id="edit-form" action="{{ route('question.update','update') }}">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Question</label>
                                <input type="hidden" name="id" v-model="question.id" >
                                <input type="text" class="form-control" name="question" v-model="question.question" placeholder="Question" required>
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
                                <label>Subtopic</label>
                                <input type="text" class="form-control" name="subtopic" v-model="question.subtopic" placeholder="Subtopic" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Image Link</label>
                                <input type="text" class="form-control" name="image_link" v-model="question.image_link"  placeholder="Image Link" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Course</label>
                                <select name="course" id="course" v-model="question.course" class="form-control" required>
                                    <option value="">Select Course</option>
                                    @foreach(config('courses') as $abr => $name)
                                    <option value="{{ $abr }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12" style="padding: 20px 15px;">
                            <div class="row" style="margin-bottom:20px">
                                <div class="col-xl-12">
                                    <label>Question Options</label>
                                    <span class="btn btn-outline-primary" v-on:click="addEditOption" style="float:right">Add Options</span>
                                </div>
                            </div>
                            <input type="hidden" name="is_correct" id="is_correct_edit"  :value="JSON.stringify(question.is_correct)">
                            <div class="questions_options row" v-for="(options, key) in question.question_options">
                                <div class="col-sm-9">
                                    <input type="text" name="description[]" class="form-control" v-model="options">
                                </div>
                                <div class="col-sm-3">
                                    <span class="is_correct_btn active" v-if="getKeyArray(key, question.is_correct) != 'empty'"  data-text="#is_correct_edit" :data-id="key">Correct Answer</span>
                                    <span class="is_correct_btn " v-else data-text="#is_correct_edit" :data-id="key">Correct Answer</span>
                                    <span style="color:red;cursor:pointer" v-on:click="removeEditOption(key)">Remove</span>
                                </div>    
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="submit" form="edit-form" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>

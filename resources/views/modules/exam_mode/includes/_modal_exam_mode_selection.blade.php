<div class="modal fade" id="add-question-code" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mock Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="question-form" method="POST" action="{{ route('group-question.store') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="question-user_id">
                    <input type="hidden" name="codes" id="question-user_codes">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Questionnaire</label>
                                <select name="select_subject" class="form-control js-select2">
                                    <option value="">Select Question</option>
                                    @foreach($subjects as $subject)
                                    <option value="{{$subject}}">{{$subject}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="submit" form="question-form" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>

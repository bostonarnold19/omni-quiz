<div class="modal fade" id="add-question-code" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="question-form" method="POST" action="{{ route('questionnaire-code.store') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="question-user_id">
                    <input type="hidden" name="codes" id="question-user_codes">
                    <center>
                        <h1 id="show-generated-code"></h1>
                    </center>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Questionnaire</label>
                                <select name="questionnaire_id" class="form-control js-select2">
                                    <option value="">Select Question</option>
                                    @foreach($questionnaires as $questionnaire)
                                    <option value="{{$questionnaire->id}}">{{$questionnaire->title}} || {{$questionnaire->subject}} || {{$questionnaire->course}}</option>
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

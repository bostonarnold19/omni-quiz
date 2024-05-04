<div class="modal fade" id="add-study-mode" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Study Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="study-form" method="get" action="{{ route('study-mode.index') }}">
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
                <button type="submit" form="study-form" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>

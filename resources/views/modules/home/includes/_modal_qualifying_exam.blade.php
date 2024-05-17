<div class="modal fade" id="add-qualifying" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mock Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="question-form" action="{{ route('omni-questionnaire.create') }}" method="GET">
                    <div class="row push mb-3">
                        <div class="col-5 mx-auto">
                            <input type="text" min="0" name="codes" class="form-control" placeholder="Enter Code" v-model="search">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-hero-primary">
                        <i class="fa fa-play mr-1"></i> Start Exam
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="submit" form="question-form" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>

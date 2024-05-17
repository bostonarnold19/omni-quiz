<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="save-form" method="POST" action="{{ route('group-question.store') }}">
                    @csrf
                    <input type="hidden" name="mode" value="admin-input">
                    <input type="hidden" name="is_official" value="1">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Type</label>
                            <select name="type" class="form-control">
                                <option>Exam</option>
                                <option>Quiz</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Title" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Subject</label>
                                <select name="select_subject" class="form-control" required>
                                    <option value="">Select Subject Course</option>
                                    @foreach($subjects as $subject)
                                    <option >{{$subject}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Question Count</label>
                                <input type="number" name="question_count" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Passing Grade %</label>
                                <input type="number" name="passing" max="100" min="0" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Time</label><br>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label>Minute</label>
                                        <input type="number"  min="00" class="form-control validate-number-only" name="minute" required>
                                    </div>
                                    <div class="col-xl-3">
                                        <label>Second</label>
                                        <input type="number" max="59" min="00" class="form-control validate-number-only" name="second" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published">
                                <label class="form-check-label" for="is_published">
                                    Publish
                                </label>
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

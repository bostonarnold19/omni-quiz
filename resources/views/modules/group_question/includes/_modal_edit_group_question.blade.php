<div class="modal fade" id="edit-modal-{{$questionaire->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="edit-form-{{$questionaire->id}}" method="POST" action="{{ route('group-question.update','update') }}">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Type</label>
                            <select name="type" class="form-control">
                                <option {{ $questionaire->type == "Exam" ? 'selected=selected' : null  }}>Exam</option>
                                <option {{ $questionaire->type == "Quiz" ? 'selected=selected' : null  }}>Quiz</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{$questionaire->id}}">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Title" value="{{$questionaire->title}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Subject</label><br>
                                <span><b>{{$questionaire->subject}}</b></span>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Course</label><br>
                                <span><b>{{$questionaire->course}}</b></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Passing Grade %</label>
                                <input type="number" name="passing" value="{{$questionaire->passing}}" max="100" min="0" class="form-control" required>
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
                                        @php
                                            $time = explode(':', $questionaire->time);
                                        @endphp
                                        <input type="number"  min="00" class="form-control validate-number-only" name="minute" value="{{$time[0]}}" required>
                                    </div>
                                    <div class="col-xl-3">
                                        <label>Second</label>
                                        <input type="number" max="59" min="00" class="form-control validate-number-only" name="second"  value="{{$time[1]}}" required>
                                    </div>
                                    <div class="col-xl-6">
                                        <label>Question Count</label><br>
                                        <span><b>{{$questionaire->questions()->count()}}</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control">{{$questionaire->description}}</textarea>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" {{empty($questionaire->is_published) ? null : "checked='checked'" }}>
                                <label class="form-check-label" for="is_published">
                                    Publish
                                </label>
                            </div>
                        </div>
                    </div><br>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="submit" form="edit-form-{{$questionaire->id}}" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>

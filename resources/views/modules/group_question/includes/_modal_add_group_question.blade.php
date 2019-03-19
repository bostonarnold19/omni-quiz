<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Group Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="save-form" method="POST" action="{{ route('group-question.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="question" placeholder="Title" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control" name="type" placeholder="Subject" required>
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
                                <input class="form-check-input" type="checkbox" name="is_published" id="is_published">
                                <label class="form-check-label" for="is_published">
                                    Publish
                                </label>
                            </div>
                        </div>
                    </div><br>
                    <h4>Questions</h4>
                    <div class="row">
                        <div class="col-xl-12">
                            <table  class="table table-bordered table-striped table-vcenter question_tables">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                    <tr>
                                        <td><input type="checkbox" name="questions[]" value="{{$question->id}}"></td>
                                        <td>{{$question->question}}</td>
                                        <td>
                                            @foreach($question->options as $key => $options)
                                            @if($key !=0 )
                                            <br>
                                            @endif
                                            {{$options->description}}
                                            @if(!empty($options->is_correct))
                                            <b>(correct answer)</b>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>{{$question->created_at->format('M d, Y H:i A')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

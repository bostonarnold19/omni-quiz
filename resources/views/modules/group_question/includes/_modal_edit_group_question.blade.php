<div class="modal fade" id="edit-modal-{{$group_question->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Group Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="edit-form" method="POST" action="{{ route('group-question.update','update') }}">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{$group_question->id}}">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Title" value="{{$group_question->title}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control" name="type" placeholder="Subject" value="{{$group_question->type}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control">{{$group_question->description}}</textarea>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" {{empty($group_question->is_published) ? null : "checked='checked'" }}>
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
                                        <td><input type="checkbox" class="edit-checkbox-question group-id-{{ $group_question->id }}" data-id="{{ $group_question->id }}" value="{{$question->id}}" {{ !in_array($question->id, $ids) ?  null : "checked='checked'" }}></td>
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
                    @php
                        $ids = [];
                        foreach ($group_question->questions as $question) {
                            $ids[] = $question->id;
                        }
                    @endphp
                    <input type="hidden" name="questions" id="edit_questions_{{$group_question->id}}" value="{{json_encode($ids)}}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="submit" form="edit-form" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>

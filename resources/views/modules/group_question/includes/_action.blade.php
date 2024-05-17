<a href="{{ $editUrl }}"  data-toggle="modal" data-target="#edit-modal-{{$questionaire->id}}" class="btn btn-sm btn-secondary">Edit</a>
@include('modules.group_question.includes._modal_edit_group_question')
<form style="display:inline;" method="POST" action="{{ $deleteUrl }}" onsubmit="return confirm('Are you sure you want to delete tihs?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
{{-- @ability('Admin', 'edit_user') --}}
<button type="button" data-id="{{ $user->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
{{-- @endability
@ability('Admin', 'delete_user') --}}
<form style="display:inline;" method="POST" action="{{ route('user.destroy', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete tihs?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
{{-- @endability --}}

<button type="button" data-id="{{ $user->id }}" data-toggle="modal" data-target="#add-question-code" class="btn btn-sm btn-secondary btn-questionaire">Assign Exam</button>
<input type="hidden" id="questionaire-code-{{$user->id}}" value="{{ config('core.code_generator') }}">

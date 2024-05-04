{{-- @ability('Admin', 'edit_question') --}}
<button type="button" data-id="{{ $question->id }}" class="button-edit btn btn-sm btn-secondary">Edit</button>
{{-- @endability
@ability('Admin', 'delete_question') --}}
<form style="display:inline;" method="POST" action="{{ route('question.destroy', $question->id) }}" onsubmit="return confirm('Are you sure you want to delete tihs?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
{{-- @endability --}}

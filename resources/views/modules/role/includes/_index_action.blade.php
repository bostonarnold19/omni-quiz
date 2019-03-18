{{-- @ability('Admin', 'edit_role') --}}
<button type="button" data-id="{{ $role->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
{{-- @endability
@ability('Admin', 'delete_role') --}}
<form style="display:inline;" method="POST" action="{{ route('role.destroy', $role->id) }}" onsubmit="return confirm('Are you sure you want to delete tihs?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
{{-- @endability --}}

<div class="d-flex align-items-center">
    @can('member show')
        <a href="{{ route('church.members.show', $member->id) }}"
            class="btn btn-sm btn-info me-1" data-bs-toggle="tooltip"
            title="View">
            <i class="ti ti-eye"></i>
        </a>
    @endcan

    @can('member edit')
        <a href="{{ route('church.members.edit', $member->id) }}"
            class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip"
            title="Edit">
            <i class="ti ti-edit"></i>
        </a>
    @endcan

    @can('member delete')
        <form method="POST" action="{{ route('church.members.destroy', $member->id) }}"
            onsubmit="return confirm('Are you sure you want to delete this member?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete">
                <i class="ti ti-trash"></i>
            </button>
        </form>
    @endcan
</div>

<form method="POST" 
      action="{{ route('discipleship.requirement.submit', $req->id) }}" 
      enctype="multipart/form-data"
      class="d-inline">
    @csrf

    @if($req->type === 'file_upload')
        <input type="file" name="evidence" class="form-control form-control-sm mb-2">
    @endif

    @if($req->type === 'custom_text')
        <input type="text" name="evidence" class="form-control form-control-sm mb-2" placeholder="Enter details">
    @endif

    <button type="submit" class="btn btn-sm btn-primary">
        {{ __('Submit') }}
    </button>
</form>

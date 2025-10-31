@extends('layouts.main')

@section('page-title', __('Edit Discipleship Stage'))

@section('content')
<div class="row">
   
    <div class="col-sm-9">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-pencil text-primary"></i> {{ __('Edit Stage & Requirements') }}</h5>

                <form action="{{ route('discipleship.update', $stage->id) }}" method="POST">
                    @csrf
                    {{-- Stage Info --}}
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Stage Name') }}</label>
                        <input type="text" name="name" value="{{ $stage->name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control">{{ $stage->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">{{ __('Order') }}</label>
                        <input type="number" name="order" value="{{ $stage->order }}" class="form-control">
                    </div>

                    <hr>
                    <h6>{{ __('Requirements') }}</h6>
                    <div id="requirements">
                        @foreach($stage->requirements as $i => $req)
                            <div class="requirement-block mb-3 border p-3 rounded">
                                <input type="hidden" name="requirements[{{ $i }}][id]" value="{{ $req->id }}">

                                <input type="text" name="requirements[{{ $i }}][title]" class="form-control mb-2"
                                    value="{{ $req->title }}" placeholder="Requirement Title">

                                <select name="requirements[{{ $i }}][type]" class="form-select mb-2">
                                    <option value="attendance" {{ $req->type=='attendance'?'selected':'' }}>Attendance</option>
                                    <option value="quiz" {{ $req->type=='quiz'?'selected':'' }}>Quiz</option>
                                    <option value="file_upload" {{ $req->type=='file_upload'?'selected':'' }}>File Upload</option>
                                    <option value="mentor_approval" {{ $req->type=='mentor_approval'?'selected':'' }}>Mentor Approval</option>
                                    <option value="self_check" {{ $req->type=='self_check'?'selected':'' }}>Self Check</option>
                                    <option value="custom_text" {{ $req->type=='custom_text'?'selected':'' }}>Text/Testimony</option>
                                </select>

                                <textarea name="requirements[{{ $i }}][description]" class="form-control mb-2"
                                    placeholder="Requirement Description">{{ $req->description }}</textarea>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-check">
                                            <input type="checkbox" name="requirements[{{ $i }}][is_mandatory]" {{ $req->is_mandatory ? 'checked' : '' }}>
                                            <span class="form-check-label">{{ __('Mandatory') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check">
                                            <input type="checkbox" name="requirements[{{ $i }}][requires_approval]" {{ $req->requires_approval ? 'checked' : '' }}>
                                            <span class="form-check-label">{{ __('Requires Approval') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="requirements[{{ $i }}][points]"
                                            value="{{ $req->points }}" class="form-control form-control-sm"
                                            placeholder="Points (e.g., 10)">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary mb-3" id="add-requirement">
                        <i class="ti ti-plus"></i> {{ __('Add Requirement') }}
                    </button>

                    <button class="btn btn-primary w-100">
                        <i class="ti ti-device-floppy"></i> {{ __('Save Changes') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> {{ __('Editing Help') }}</h6>
                <p class="small text-muted">
                    {{ __('Here you can update the stage details and manage requirements. You may add new requirements, edit existing ones, or remove them.') }}
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let reqIndex = {{ $stage->requirements->count() }};

    document.getElementById("add-requirement").addEventListener("click", function() {
        let container = document.getElementById("requirements");

        let block = document.createElement("div");
        block.classList.add("requirement-block","mb-3","border","p-3","rounded");

        block.innerHTML = `
            <input type="text" name="requirements[${reqIndex}][title]" class="form-control mb-2"
                placeholder="Requirement Title">

            <select name="requirements[${reqIndex}][type]" class="form-select mb-2">
                <option value="attendance">Attendance</option>
                <option value="quiz">Quiz</option>
                <option value="file_upload">File Upload</option>
                <option value="mentor_approval">Mentor Approval</option>
                <option value="self_check">Self Check</option>
                <option value="custom_text">Text/Testimony</option>
            </select>

            <textarea name="requirements[${reqIndex}][description]" class="form-control mb-2"
                placeholder="Requirement Description"></textarea>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-check">
                        <input type="checkbox" name="requirements[${reqIndex}][is_mandatory]">
                        <span class="form-check-label">{{ __('Mandatory') }}</span>
                    </label>
                </div>
                <div class="col-md-4">
                    <label class="form-check">
                        <input type="checkbox" name="requirements[${reqIndex}][requires_approval]">
                        <span class="form-check-label">{{ __('Requires Approval') }}</span>
                    </label>
                </div>
                <div class="col-md-4">
                    <input type="number" name="requirements[${reqIndex}][points]"
                        class="form-control form-control-sm" placeholder="Points (e.g., 10)">
                </div>
            </div>
        `;

        container.appendChild(block);
        reqIndex++;
    });
});
</script>
@endsection

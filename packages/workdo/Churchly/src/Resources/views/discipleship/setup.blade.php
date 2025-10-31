@extends('layouts.main')
@php
    $company_settings = getCompanyAllSetting();   
@endphp

@section('page-action')
     @permission('discipleship manage')
        <a href="{{ route('discipleship.index') }}" 
           class="btn btn-sm btn-secondary"
           title="{{ __('Create') }}">
            <i class="ti ti-arrow-back-up me-2"></i>
        </a>
    @endpermission
@endsection
@section('page-title', __('Discipleship Setup Wizard'))

@section('content')
<div class="row">
    

    {{-- Main Wizard Form --}}
    <div class="col-sm-9">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-flag text-primary"></i> {{ __('Setup Discipleship Pathway') }}</h5>
                <p class="text-muted small mb-4">
                    {{ __('Create discipleship stages and their requirements. Each stage represents a key step in a member’s spiritual growth journey. You can add as many stages and requirements as your church needs.') }}
                </p>

                <form action="{{ route('discipleship.setup.save') }}" method="POST">
                    @csrf

                    <div id="wizard-stages">
                        <!-- Stage Block -->
                        <div class="stage-template mb-4 border p-3 rounded bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-2">{{ __('Stage') }} <span class="stage-number">1</span></h6>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-stage d-none">
                                    <i class="ti ti-trash"></i> {{ __('Remove Stage') }}
                                </button>
                            </div>

                            <input type="text" name="stages[0][name]" class="form-control mb-2"
                                placeholder="Stage Name (e.g., Believe)" required>
                            <textarea name="stages[0][description]" class="form-control mb-3"
                                placeholder="Stage Description (What is this stage about?)"></textarea>

                            <div class="requirements">
                                <h6>{{ __('Requirements') }}</h6>

                                <!-- Requirement Block -->
                                <div class="requirement-template mb-3 p-2 border rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="fw-bold">{{ __('Requirement') }}</small>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-requirement d-none">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>

                                    <input type="text" name="stages[0][requirements][0][title]" class="form-control mb-1"
                                        placeholder="Requirement Title (e.g., Attend New Believers Class)">
                                    
                                    <select name="stages[0][requirements][0][type]" class="form-select mb-1">
                                        <option value="attendance">Attendance</option>
                                        <option value="quiz">Quiz</option>
                                        <option value="file_upload">File Upload</option>
                                        <option value="mentor_approval">Mentor Approval</option>
                                        <option value="self_check">Self Check</option>
                                        <option value="custom_text">Text/Testimony</option>
                                    </select>

                                    <textarea name="stages[0][requirements][0][description]" class="form-control mb-1"
                                        placeholder="Requirement Description (optional)"></textarea>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-check">
                                                <input type="checkbox" name="stages[0][requirements][0][is_mandatory]" value="1" checked>
                                                <span class="form-check-label">{{ __('Mandatory') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-check">
                                                <input type="checkbox" name="stages[0][requirements][0][requires_approval]" value="1">
                                                <span class="form-check-label">{{ __('Requires Approval') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="stages[0][requirements][0][points]"
                                                class="form-control form-control-sm"
                                                placeholder="Points (e.g., 10)">
                                        </div>
                                    </div>
                                </div>
                                <!-- /Requirement Block -->

                                <button type="button" class="btn btn-sm btn-outline-primary add-requirement">
                                    <i class="ti ti-plus"></i> {{ __('Add Requirement') }}
                                </button>
                            </div>
                        </div>
                        <!-- /Stage Block -->
                    </div>

                    <button type="button" class="btn btn-outline-success mb-3" id="add-stage">
                        <i class="ti ti-plus"></i> {{ __('Add Stage') }}
                    </button>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-check"></i> {{ __('Save Pathway') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Instruction Column --}}
    <div class="col-sm-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> {{ __('How to Use the Wizard') }}</h6>
                <p class="small text-muted">
                    {{ __('This wizard helps pastors and admins build a discipleship pathway tailored to their church. Each stage is a major milestone in spiritual growth, and each requirement defines what members must complete before progressing.') }}
                </p>

                <ul class="small text-muted ps-3">
                    <li><b>Stage:</b> Name and describe the spiritual milestone (e.g., Believe, Serve).</li>
                    <li><b>Requirements:</b> Add multiple tasks such as:
                        <ul>
                            <li>✅ <b>Attendance</b>  Link to events or classes.</li>
                            <li>✅ <b>Quiz</b>   Knowledge checks inside Churchly.</li>
                            <li>✅ <b>File Upload</b>   Certificates or reflection papers.</li>
                            <li>✅ <b>Mentor Approval</b>   Requires review by a leader.</li>
                            <li>✅ <b>Self Check</b>   Simple yes/no progress step.</li>
                            <li>✅ <b>Custom Text</b>   Testimonies or short essays.</li>
                        </ul>
                    </li>
                    <li><b>Mandatory:</b> Required for completion.</li>
                    <li><b>Points:</b> Assign points for gamification and reporting.</li>
                    <li><b>Approval:</b> Flag requirements that need mentor/pastor validation.</li>
                </ul>

                <div class="alert alert-info small mt-3">
                    <i class="ti ti-lightbulb"></i> <b>Tip:</b> Start simple (3–5 stages). You can always add more stages or requirements later as your church grows.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let stageIndex = 0;

    // Add Stage
    document.getElementById("add-stage").addEventListener("click", function() {
        stageIndex++;
        let stageBlock = document.querySelector(".stage-template").cloneNode(true);
        stageBlock.querySelector(".stage-number").innerText = stageIndex + 1;

        // Reset inputs
        stageBlock.querySelectorAll("input, textarea, select").forEach(el => { el.value = ""; });

        // Update name attributes with new stage index
        stageBlock.querySelectorAll("input, textarea, select").forEach(el => {
            el.name = el.name.replace(/stages\[\d+\]/, `stages[${stageIndex}]`);
        });

        // Show remove button for additional stages
        stageBlock.querySelector(".remove-stage").classList.remove("d-none");

        document.getElementById("wizard-stages").appendChild(stageBlock);
    });

    // Remove Stage
    document.addEventListener("click", function(e) {
        if (e.target.closest(".remove-stage")) {
            e.target.closest(".stage-template").remove();
        }
    });

    // Add Requirement inside a stage
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("add-requirement")) {
            let requirementsDiv = e.target.closest(".requirements");
            let requirementIndex = requirementsDiv.querySelectorAll(".requirement-template").length;
            let stageBlock = e.target.closest(".stage-template");
            let stageId = [...document.querySelectorAll(".stage-template")].indexOf(stageBlock);

            let newReq = requirementsDiv.querySelector(".requirement-template").cloneNode(true);
            newReq.querySelectorAll("input, textarea, select").forEach(el => {
                el.value = "";
                el.name = el.name.replace(/stages\[\d+\]\[requirements\]\[\d+\]/, `stages[${stageId}][requirements][${requirementIndex}]`);
            });

            // Show remove button
            newReq.querySelector(".remove-requirement").classList.remove("d-none");

            requirementsDiv.insertBefore(newReq, e.target);
        }
    });

    // Remove Requirement
    document.addEventListener("click", function(e) {
        if (e.target.closest(".remove-requirement")) {
            e.target.closest(".requirement-template").remove();
        }
    });
});
</script>
@endsection

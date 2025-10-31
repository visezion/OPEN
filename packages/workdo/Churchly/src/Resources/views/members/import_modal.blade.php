
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            
            <!-- Header -->
            <div class="modal-header text-white">
                <h5 class="modal-title">
                    <i class="ti ti-upload me-2"></i> {{ __('Import Members') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <!-- Instructions -->
                <div class="alert alert-info mb-4">
                    <h6 class="fw-bold mb-2"><i class="ti ti-info-circle me-1"></i> {{ __('Instructions') }}</h6>
                    <ol class="mb-2">
                        <li>{{ __('Download the sample CSV to see the required structure.') }}</li>
                        <li>{{ __('Fill in member details (Name, Email, Phone, Gender, etc.).') }}</li>
                        <li>{{ __('Branch, Department, Designation, and Role should match existing records in the system. If not found, they will be set to "Unknown".') }}</li>
                        <li>{{ __('Date fields must use format DD/MM/YYYY or YYYY-MM-DD (e.g., 19/01/2024).') }}</li>
                        <li>{{ __('During import, a unique Member ID will be auto-generated and a linked User account will be created (default password: "password").') }}</li>
                        <li>{{ __('After upload, you will preview the cleaned data before confirming the import.') }}</li>
                    </ol>
                    <small class="text-muted">
                        {{ __('Tip: Always check the preview screen to confirm Branch, Department, and Role mappings before finalizing.') }}
                    </small>
                </div>

                <!-- Nav Tabs -->
                <ul class="nav nav-tabs" id="importTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="file-tab" data-bs-toggle="tab" data-bs-target="#file-tab-pane" type="button" role="tab">  
                        <img src=" https://cdn.pixabay.com/photo/2017/03/08/21/21/spreadsheet-2127832_1280.png"
                            alt="CSV File" style="height:20px; margin-right:8px;">{{ __('Upload CSV File') }}                            
                        </button>
                    </li>
                   
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gdrive-tab" data-bs-toggle="tab" data-bs-target="#gdrive-tab-pane" type="button" role="tab">
                            <img src="https://www.gstatic.com/images/branding/product/1x/drive_2020q4_48dp.png"
                            alt="Google Drive" style="height:20px; margin-right:8px;">{{ __('Google Drive Link') }}
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="importTabContent">
                    <!-- File Upload -->
                    <div class="tab-pane fade show active" id="file-tab-pane" role="tabpanel">
                        <form id="csv_import_form" action="{{ route('members.import.file') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="csv_file" class="form-label fw-bold">Select CSV File</label>
                                <input type="file" 
                                       name="csv_file" 
                                       id="csv_file" 
                                       class="form-control form-control-lg"
                                       accept=".csv,.txt"
                                       required>
                                <small class="text-muted d-block mt-2">Accepted formats: CSV, TXT (max 2MB).</small>
                            </div>
                        </form>
                    </div>

                    <!-- Google Drive Link -->
                    <div class="tab-pane fade" id="gdrive-tab-pane" role="tabpanel">
                        <form id="gdrive_import_form" action="{{ route('members.import.google') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="gdrive_link" class="form-label fw-bold">Paste Google Drive Link</label>
                                <input type="url" 
                                       name="gdrive_link" 
                                       id="gdrive_link" 
                                       class="form-control form-control-lg" 
                                       placeholder="https://drive.google.com/file/d/FILE_ID/view" 
                                       required>
                                <small class="text-muted d-block mt-2">
                                    {{ __('Make sure the file is shared with "Anyone with link".') }}
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

           <!-- Footer -->
            <div class="modal-footer d-flex flex-wrap justify-content-between align-items-center">
                <!-- Left: Download sample -->
                <a href="{{ route('members.import.sample') }}" class="btn btn-outline-secondary mb-2 mb-sm-0">
                    <i class="ti ti-download me-1"></i> {{ __('Download Sample CSV') }}
                </a>

                <!-- Right: Actions -->
                <div class="d-flex gap-2">
                    <!-- Upload CSV -->
                    <button type="submit" form="csv_import_form" class="btn btn-primary"
                        class="btn d-flex align-items-center px-3 py-2 border rounded shadow-sm"
                        style="background-color:#fff; color:#5f6368; border-color:#dadce0; transition: all .2s;">
                        <img src=" https://cdn.pixabay.com/photo/2017/03/08/21/21/spreadsheet-2127832_1280.png"
                            alt="CSV File" style="height:20px; margin-right:8px;">{{ __('Upload CSV File') }}
                       
                    </button>

                    <!-- Import from Google Drive -->
                    <button type="submit" form="gdrive_import_form"
                        class="btn d-flex align-items-center px-3 py-2 border rounded shadow-sm"
                        style="background-color:#fff; color:#5f6368; border-color:#dadce0; transition: all .2s;">
                        <img src="https://www.gstatic.com/images/branding/product/1x/drive_2020q4_48dp.png"
                            alt="Google Drive"
                            style="height:20px; margin-right:8px;">
                        <span class="fw-bold">{{ __('Import from Google Drive') }}</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

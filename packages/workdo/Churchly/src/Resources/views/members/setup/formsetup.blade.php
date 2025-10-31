@extends('layouts.main')

@section('page-title')
    {{ __('Custom Member Fields') }}
@endsection

@section('page-action')
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFieldModal">
        <i class="ti ti-plus"></i> {{ __('Add Field') }}
    </button>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-2">
        @include('churchly::layouts.churchly_setup')
    </div>

    <div class="col-sm-7">
        {{-- Main Card --}}
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Order') }}</th>
                            <th>{{ __('Key') }}</th>
                            <th>{{ __('Label') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Default Value') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fields as $field)
                            <tr>
                                <td>{{ $field->order }}</td>
                                <td><code>{{ $field->field_key }}</code></td>
                                <td>{{ $field->field_label }}</td>
                                <td>{{ ucfirst($field->field_type) }}</td>
                                <td>{{ $field->field_value }}</td>
                                <td>
                                    <a href="{{ route('formsetup.edit', $field->id) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                                    <form action="{{ route('formsetup.destroy', $field->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this field?')">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">{{ __('No fields found') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Documentation / Info Column --}}
    <div class="col-sm-3">
        <div class="card p-3">
            <h6 class="mb-2"><i class="ti ti-info-circle text-primary"></i> {{ __('What Are Custom Member Fields?') }}</h6>
            <p class="small text-muted">
                {{ __('Custom fields allow you to extend the standard member form with additional inputs that suit your church needs. For example, you can collect emergency contacts, baptism dates, or ministry preferences.') }}
            </p>

            <h6 class="mt-3">{{ __('Field Properties Explained') }}</h6>
            <ul class="small text-muted ps-3">
                <li><strong>{{ __('Field Key') }}:</strong> {{ __('A unique identifier used internally (e.g., "emergency_phone"). Keep it lowercase and without spaces.') }}</li>
                <li><strong>{{ __('Field Label') }}:</strong> {{ __('The name shown on the member form (e.g., "Emergency Phone").') }}</li>
                <li><strong>{{ __('Type') }}:</strong> {{ __('Choose how members will enter data: text, textarea, date, dropdown, file upload, or checkbox.') }}</li>
                <li><strong>{{ __('Default Value') }}:</strong> {{ __('Pre-fill options or values. For dropdowns/checkboxes, separate multiple options with commas (e.g., "Yes,No,Maybe").') }}</li>
                <li><strong>{{ __('Order') }}:</strong> {{ __('Controls the display sequence of fields on the form. Lower numbers appear first.') }}</li>
            </ul>

            <h6 class="mt-3">{{ __('Best Practices') }}</h6>
            <ul class="small text-muted ps-3">
                <li>{{ __('Always use clear labels so members know what to enter.') }}</li>
                <li>{{ __('Keep field keys consistent (no spaces, use underscores).') }}</li>
                <li>{{ __('Avoid adding too many fields at once — keep the form simple and relevant.') }}</li>
                <li>{{ __('Test new fields by previewing the member registration form.') }}</li>
            </ul>

            <p class="small text-muted mt-2">
                {{ __('💡 Tip: Use dropdowns for controlled choices, checkboxes for multiple selections, and file uploads for documents like ID scans or certificates.') }}
            </p>
        </div>
    </div>
</div>

<!-- Add Field Modal -->
<div class="modal fade" id="addFieldModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="POST" action="{{ route('formsetup.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add Custom Field') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>{{ __('Field Key') }}</label>
                    <input type="text" name="field_key" class="form-control" placeholder="e.g., emergency_contact" required>
                </div>
                <div class="mb-3">
                    <label>{{ __('Field Label') }}</label>
                    <input type="text" name="field_label" class="form-control" placeholder="e.g., Emergency Contact" required>
                </div>
                <div class="mb-3">
                    <label>{{ __('Field Type') }}</label>
                    <select name="field_type" class="form-control" required>
                        <option value="text">{{ __('Text') }}</option>
                        <option value="textarea">{{ __('Textarea') }}</option>
                        <option value="date">{{ __('Date') }}</option>
                        <option value="dropdown">{{ __('Dropdown') }}</option>
                        <option value="file">{{ __('File Upload') }}</option>
                        <option value="checkbox">{{ __('Checkbox') }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>{{ __('Default Value (Optional)') }}</label>
                    <input type="text" name="field_value" class="form-control" placeholder="e.g., Yes,No,Maybe">
                </div>
                <div class="mb-3">
                    <label>{{ __('Display Order') }}</label>
                    <input type="number" name="order" class="form-control" value="0" min="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection

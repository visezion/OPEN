<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Assignments') }}</h5>
    </div>
    <div class="card-body">
        {!! Form::open(['route' => ['churchly.volunteers.assignments.store', $volunteer->id], 'method' => 'POST', 'class' => 'row g-3 align-items-end assignment-form']) !!}
            <div class="col-md-3">
                {!! Form::label('assignment_type', __('Assignment Type'), ['class' => 'form-label']) !!}
                {!! Form::select('assignment_type', [
                    'event' => __('Event'),
                    'attendance_event' => __('Attendance Session'),
                    'worship_team' => __('Worship Team'),
                    'service_role' => __('Service Role'),
                ], null, ['class' => 'form-select assignment-type', 'required' => true]) !!}
            </div>
            <div class="col-md-3 assignment-picker assignment-picker-event d-none">
                {!! Form::label('assignment_id_event', __('Select Event'), ['class' => 'form-label']) !!}
                <select name="assignment_id" class="form-select" disabled>
                    <option value="">{{ __('Choose event') }}</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">
                            {{ $event->title ?? __('Event #:id', ['id' => $event->id]) }}
                            @if($event->start_time)
                                ({{ \Illuminate\Support\Carbon::parse($event->start_time)->format('d M Y H:i') }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 assignment-picker assignment-picker-attendance d-none">
                {!! Form::label('assignment_id_attendance', __('Attendance Session'), ['class' => 'form-label']) !!}
                <select name="assignment_id" class="form-select" disabled>
                    <option value="">{{ __('Choose attendance session') }}</option>
                    @foreach($attendanceEvents as $session)
                        <option value="{{ $session->id }}">
                            {{ optional($session->event)->title ?? __('Session #:id', ['id' => $session->id]) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 assignment-label-field">
                {!! Form::label('assignment_label', __('Label / Team name'), ['class' => 'form-label']) !!}
                {!! Form::text('assignment_label', null, ['class' => 'form-control', 'placeholder' => __('E.g. Sunday Worship 1st Service')]) !!}
            </div>
            <div class="col-md-2">
                {!! Form::label('role', __('Role'), ['class' => 'form-label']) !!}
                {!! Form::text('role', null, ['class' => 'form-control', 'placeholder' => __('Usher, Lead vocals...')]) !!}
            </div>
            <div class="col-md-2">
                {!! Form::label('scheduled_for', __('Scheduled for'), ['class' => 'form-label']) !!}
                {!! Form::datetimeLocal('scheduled_for', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-2">
                {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
                {!! Form::select('status', [
                    'planned' => __('Planned'),
                    'confirmed' => __('Confirmed'),
                    'completed' => __('Completed'),
                    'cancelled' => __('Cancelled')
                ], 'planned', ['class' => 'form-select']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
                {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 2]) !!}
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-plus"></i> {{ __('Add Assignment') }}
                </button>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>{{ __('Context') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Schedule') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th class="text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($volunteer->assignments as $assignment)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $assignment->context_label }}</div>
                            <div class="small text-muted">
                                {{ ucfirst(str_replace('_', ' ', $assignment->assignment_type)) }}
                            </div>
                            @if($assignment->notes)
                                <div class="small text-muted mt-1">{{ $assignment->notes }}</div>
                            @endif
                        </td>
                        <td>{{ $assignment->role ?? '—' }}</td>
                        <td class="small text-muted">
                            {{ optional($assignment->scheduled_for)->format('d M Y H:i') ?? '—' }}
                        </td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($assignment->status) }}</span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#assignment-edit-{{ $assignment->id }}">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                {!! Form::open([
                                    'route' => ['churchly.volunteers.assignments.destroy', $volunteer->id, $assignment->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".__('Remove this assignment?')."');"
                                ]) !!}
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="assignment-edit-{{ $assignment->id }}">
                        <td colspan="5">
                            {!! Form::model($assignment, ['route' => ['churchly.volunteers.assignments.update', $volunteer->id, $assignment->id], 'method' => 'PUT']) !!}
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    {!! Form::label('assignment_type_'.$assignment->id, __('Type'), ['class' => 'form-label']) !!}
                                    {!! Form::select('assignment_type', [
                                        'event' => __('Event'),
                                        'attendance_event' => __('Attendance Session'),
                                        'worship_team' => __('Worship Team'),
                                        'service_role' => __('Service Role'),
                                    ], $assignment->assignment_type, ['class' => 'form-select']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('assignment_id_'.$assignment->id, __('Reference ID'), ['class' => 'form-label']) !!}
                                    {!! Form::number('assignment_id', $assignment->assignment_id, ['class' => 'form-control', 'min' => 1]) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('assignment_label_'.$assignment->id, __('Label'), ['class' => 'form-label']) !!}
                                    {!! Form::text('assignment_label', $assignment->assignment_label, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('role_'.$assignment->id, __('Role'), ['class' => 'form-label']) !!}
                                    {!! Form::text('role', $assignment->role, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('scheduled_for_'.$assignment->id, __('Scheduled for'), ['class' => 'form-label']) !!}
                                    {!! Form::datetimeLocal('scheduled_for', optional($assignment->scheduled_for)->format('Y-m-d\TH:i'), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('status_'.$assignment->id, __('Status'), ['class' => 'form-label']) !!}
                                    {!! Form::select('status', [
                                        'planned' => __('Planned'),
                                        'confirmed' => __('Confirmed'),
                                        'completed' => __('Completed'),
                                        'cancelled' => __('Cancelled'),
                                    ], $assignment->status, ['class' => 'form-select']) !!}
                                </div>
                                <div class="col-12">
                                    {!! Form::label('notes_'.$assignment->id, __('Notes'), ['class' => 'form-label']) !!}
                                    {!! Form::textarea('notes', $assignment->notes, ['class' => 'form-control', 'rows' => 2]) !!}
                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#assignment-edit-{{ $assignment->id }}">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            {{ __('No assignments yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

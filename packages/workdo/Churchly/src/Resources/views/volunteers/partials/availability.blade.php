<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Availability') }}</h5>
    </div>
    <div class="card-body">
        {!! Form::open(['route' => ['churchly.volunteers.availability.store', $volunteer->id], 'method' => 'POST', 'class' => 'row g-3']) !!}
            <div class="col-md-6">
                {!! Form::label('day_of_week', __('Day of week'), ['class' => 'form-label']) !!}
                {!! Form::select('day_of_week', [
                    'monday' => __('Monday'),
                    'tuesday' => __('Tuesday'),
                    'wednesday' => __('Wednesday'),
                    'thursday' => __('Thursday'),
                    'friday' => __('Friday'),
                    'saturday' => __('Saturday'),
                    'sunday' => __('Sunday'),
                    'flexible' => __('Flexible'),
                ], null, ['class' => 'form-select', 'required' => true]) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('start_time', __('From'), ['class' => 'form-label']) !!}
                {!! Form::time('start_time', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('end_time', __('To'), ['class' => 'form-label']) !!}
                {!! Form::time('end_time', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('effective_from', __('Effective from'), ['class' => 'form-label']) !!}
                {!! Form::date('effective_from', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('effective_until', __('Effective until'), ['class' => 'form-label']) !!}
                {!! Form::date('effective_until', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('timezone', __('Timezone'), ['class' => 'form-label']) !!}
                {!! Form::text('timezone', config('app.timezone'), ['class' => 'form-control']) !!}
            </div>
            <div class="col-12">
                {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
                {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 2]) !!}
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-plus"></i> {{ __('Add availability') }}
                </button>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>{{ __('Window') }}</th>
                    <th>{{ __('Effective dates') }}</th>
                    <th class="text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($volunteer->availabilities as $availability)
                    <tr>
                        <td>
                            <div class="fw-semibold text-capitalize">{{ str_replace('_', ' ', $availability->day_of_week) }}</div>
                            <div class="small text-muted">
                                {{ $availability->start_time ? \Illuminate\Support\Carbon::parse($availability->start_time)->format('H:i') : '—' }}
                                —
                                {{ $availability->end_time ? \Illuminate\Support\Carbon::parse($availability->end_time)->format('H:i') : '—' }}
                                @if($availability->timezone)
                                    <span class="ms-1">({{ $availability->timezone }})</span>
                                @endif
                            </div>
                            @if($availability->notes)
                                <div class="small text-muted mt-1">{{ $availability->notes }}</div>
                            @endif
                        </td>
                        <td class="small text-muted">
                            {{ optional($availability->effective_from)->format('d M Y') ?? '—' }}
                            @if($availability->effective_until)
                                <br>{{ __('Until :date', ['date' => $availability->effective_until->format('d M Y')]) }}
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#availability-edit-{{ $availability->id }}">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                {!! Form::open([
                                    'route' => ['churchly.volunteers.availability.destroy', $volunteer->id, $availability->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".__('Remove this availability?')."');"
                                ]) !!}
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="availability-edit-{{ $availability->id }}">
                        <td colspan="3">
                            {!! Form::model($availability, ['route' => ['churchly.volunteers.availability.update', $volunteer->id, $availability->id], 'method' => 'PUT']) !!}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    {!! Form::label('day_of_week_'.$availability->id, __('Day of week'), ['class' => 'form-label']) !!}
                                    {!! Form::select('day_of_week', [
                                        'monday' => __('Monday'),
                                        'tuesday' => __('Tuesday'),
                                        'wednesday' => __('Wednesday'),
                                        'thursday' => __('Thursday'),
                                        'friday' => __('Friday'),
                                        'saturday' => __('Saturday'),
                                        'sunday' => __('Sunday'),
                                        'flexible' => __('Flexible'),
                                    ], $availability->day_of_week, ['class' => 'form-select']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('start_time_'.$availability->id, __('From'), ['class' => 'form-label']) !!}
                                    {!! Form::time('start_time', $availability->start_time ? \Illuminate\Support\Str::of($availability->start_time)->substr(0,5) : null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('end_time_'.$availability->id, __('To'), ['class' => 'form-label']) !!}
                                    {!! Form::time('end_time', $availability->end_time ? \Illuminate\Support\Str::of($availability->end_time)->substr(0,5) : null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('effective_from_'.$availability->id, __('Effective from'), ['class' => 'form-label']) !!}
                                    {!! Form::date('effective_from', optional($availability->effective_from)->format('Y-m-d'), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('effective_until_'.$availability->id, __('Effective until'), ['class' => 'form-label']) !!}
                                    {!! Form::date('effective_until', optional($availability->effective_until)->format('Y-m-d'), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('timezone_'.$availability->id, __('Timezone'), ['class' => 'form-label']) !!}
                                    {!! Form::text('timezone', $availability->timezone, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-12">
                                    {!! Form::label('notes_'.$availability->id, __('Notes'), ['class' => 'form-label']) !!}
                                    {!! Form::textarea('notes', $availability->notes, ['class' => 'form-control', 'rows' => 2]) !!}
                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#availability-edit-{{ $availability->id }}">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">{{ __('No availability preferences recorded.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

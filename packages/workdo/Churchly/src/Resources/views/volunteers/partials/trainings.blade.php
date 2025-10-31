<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Training History') }}</h5>
    </div>
    <div class="card-body">
        {!! Form::open(['route' => ['churchly.volunteers.trainings.store', $volunteer->id], 'method' => 'POST', 'class' => 'row g-3']) !!}
            <div class="col-md-6">
                {!! Form::label('title', __('Training title'), ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('provider', __('Provider'), ['class' => 'form-label']) !!}
                {!! Form::text('provider', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('completed_on', __('Completed on'), ['class' => 'form-label']) !!}
                {!! Form::date('completed_on', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('valid_until', __('Valid until'), ['class' => 'form-label']) !!}
                {!! Form::date('valid_until', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
                {!! Form::select('status', [
                    'scheduled' => __('Scheduled'),
                    'in_progress' => __('In progress'),
                    'completed' => __('Completed'),
                    'expired' => __('Expired'),
                ], 'completed', ['class' => 'form-select']) !!}
            </div>
            <div class="col-12">
                {!! Form::label('notes', __('Notes'), ['class' => 'form-label']) !!}
                {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 2]) !!}
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-plus"></i> {{ __('Add training') }}
                </button>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>{{ __('Course') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Completed') }}</th>
                    <th class="text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($volunteer->trainings as $training)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $training->title }}</div>
                            <div class="small text-muted">{{ $training->provider ?? '—' }}</div>
                            @if($training->notes)
                                <div class="small text-muted mt-1">{{ $training->notes }}</div>
                            @endif
                        </td>
                        <td><span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $training->status)) }}</span></td>
                        <td class="small text-muted">
                            {{ optional($training->completed_on)->format('d M Y') ?? '—' }}
                            @if($training->valid_until)
                                <br><span>{{ __('Valid till :date', ['date' => $training->valid_until->format('d M Y')]) }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#training-edit-{{ $training->id }}">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                {!! Form::open([
                                    'route' => ['churchly.volunteers.trainings.destroy', $volunteer->id, $training->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".__('Remove this training record?')."');"
                                ]) !!}
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="training-edit-{{ $training->id }}">
                        <td colspan="4">
                            {!! Form::model($training, ['route' => ['churchly.volunteers.trainings.update', $volunteer->id, $training->id], 'method' => 'PUT']) !!}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    {!! Form::label('title_'.$training->id, __('Training title'), ['class' => 'form-label']) !!}
                                    {!! Form::text('title', $training->title, ['class' => 'form-control', 'required' => true]) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('provider_'.$training->id, __('Provider'), ['class' => 'form-label']) !!}
                                    {!! Form::text('provider', $training->provider, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('completed_on_'.$training->id, __('Completed on'), ['class' => 'form-label']) !!}
                                    {!! Form::date('completed_on', optional($training->completed_on)->format('Y-m-d'), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('valid_until_'.$training->id, __('Valid until'), ['class' => 'form-label']) !!}
                                    {!! Form::date('valid_until', optional($training->valid_until)->format('Y-m-d'), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label('status_'.$training->id, __('Status'), ['class' => 'form-label']) !!}
                                    {!! Form::select('status', [
                                        'scheduled' => __('Scheduled'),
                                        'in_progress' => __('In progress'),
                                        'completed' => __('Completed'),
                                        'expired' => __('Expired'),
                                    ], $training->status, ['class' => 'form-select']) !!}
                                </div>
                                <div class="col-12">
                                    {!! Form::label('notes_'.$training->id, __('Notes'), ['class' => 'form-label']) !!}
                                    {!! Form::textarea('notes', $training->notes, ['class' => 'form-control', 'rows' => 2]) !!}
                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#training-edit-{{ $training->id }}">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">{{ __('No training records yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

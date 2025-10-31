@extends('layouts.main')

@section('page-title')
    {{ $volunteer->display_name }}
@endsection

@section('page-breadcrumb')
    <a href="{{ route('churchly.volunteers.index') }}">{{ __('Volunteers') }}</a> /
    {{ $volunteer->display_name }}
@endsection

@section('page-action')
    <div class="d-flex gap-2">
        @permission('church_volunteer manage')
            <a href="{{ route('churchly.volunteers.edit', $volunteer) }}"
               class="btn btn-sm btn-primary">
                <i class="ti ti-pencil"></i> {{ __('Edit') }}
            </a>
        @endpermission
        @permission('church_volunteer manage')
            {!! Form::open(['route' => ['churchly.volunteers.destroy', $volunteer], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                <button type="submit"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('{{ __('Delete this volunteer profile?') }}');">
                    <i class="ti ti-trash"></i> {{ __('Delete') }}
                </button>
            {!! Form::close() !!}
        @endpermission
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-4">
                        <div class="flex-grow-1">
                            <h4 class="mb-1">{{ $volunteer->display_name }}</h4>
                            <div class="mb-2">
                                <span class="badge bg-success me-2">{{ ucfirst($volunteer->status) }}</span>
                                @if($volunteer->joined_at)
                                    <span class="text-muted small">
                                        {{ __('Serving since :date', ['date' => $volunteer->joined_at->format('d M Y')]) }}
                                    </span>
                                @endif
                            </div>
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted">{{ __('Email') }}</dt>
                                <dd class="col-sm-8">{{ $volunteer->email ?? '—' }}</dd>

                                <dt class="col-sm-4 text-muted">{{ __('Phone') }}</dt>
                                <dd class="col-sm-8">{{ $volunteer->phone ?? '—' }}</dd>

                                <dt class="col-sm-4 text-muted">{{ __('Linked member') }}</dt>
                                <dd class="col-sm-8">
                                    @if($volunteer->member)
                                        <a href="{{ route('members.show', $volunteer->member->id) }}">
                                            {{ $volunteer->member->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">{{ __('Not linked') }}</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4 text-muted">{{ __('Primary team') }}</dt>
                                <dd class="col-sm-8">
                                    {{ optional($volunteer->primary_department)->name ?? __('Unset') }}
                                </dd>
                            </dl>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small">{{ __('Departments') }}</h6>
                            <div class="mb-3">
                                @forelse($volunteer->departments as $department)
                                    <span class="badge bg-light text-dark me-1 mb-1">
                                        {{ $department->name }}
                                        @if(data_get($department, 'pivot.is_primary'))
                                            <span class="text-success ms-1">{{ __('Primary') }}</span>
                                        @endif
                                    </span>
                                @empty
                                    <span class="text-muted">{{ __('No departments assigned yet.') }}</span>
                                @endforelse
                            </div>
                            <h6 class="text-muted text-uppercase small">{{ __('Skills') }}</h6>
                            <div>
                                @forelse($volunteer->skills as $skill)
                                    <span class="badge bg-secondary me-1 mb-1">
                                        {{ $skill->name }}
                                        <span class="ms-1 small">
                                            ({{ ucfirst($skill->pivot->proficiency ?? 'intermediate') }})
                                        </span>
                                    </span>
                                @empty
                                    <span class="text-muted">{{ __('No skills tagged.') }}</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @if($volunteer->notes)
                        <hr>
                        <div>
                            <h6 class="text-muted text-uppercase small">{{ __('Notes') }}</h6>
                            <p class="mb-0">{{ $volunteer->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12">
            @include('churchly::volunteers.partials.assignments')
        </div>

        <div class="col-lg-6">
            @include('churchly::volunteers.partials.trainings')
        </div>

        <div class="col-lg-6">
            @include('churchly::volunteers.partials.availability')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.assignment-form .assignment-type').forEach(function (select) {
            function togglePickers() {
                const wrapper = select.closest('.assignment-form');
                const type = select.value;
                wrapper.querySelectorAll('.assignment-picker').forEach(function (el) {
                    el.classList.add('d-none');
                    const input = el.querySelector('select');
                    if (input) {
                        input.disabled = true;
                    }
                });
                if (type === 'event') {
                    const block = wrapper.querySelector('.assignment-picker-event');
                    if (block) {
                        block.classList.remove('d-none');
                        const input = block.querySelector('select');
                        if (input) {
                            input.disabled = false;
                        }
                    }
                } else if (type === 'attendance_event') {
                    const block = wrapper.querySelector('.assignment-picker-attendance');
                    if (block) {
                        block.classList.remove('d-none');
                        const input = block.querySelector('select');
                        if (input) {
                            input.disabled = false;
                        }
                    }
                }
                const labelField = wrapper.querySelector('.assignment-label-field');
                if (labelField) {
                    labelField.classList.toggle('d-none', type === 'event' || type === 'attendance_event');
                }
            }
            select.addEventListener('change', togglePickers);
            togglePickers();
        });
    </script>
@endpush

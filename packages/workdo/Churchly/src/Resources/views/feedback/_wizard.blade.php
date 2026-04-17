@php
    $isEditing = isset($feedback) && $feedback->exists;
    $reportPayload = $feedback->report_payload ?? [];
    $attendanceSummary = $attendancePreview ?? ($feedback->attendance_summary ?? []);
    $weekEndingValue = old(
    'week_ending_date',
    optional($feedback)->week_ending_date?->toDateString()
        ?? ($defaultWeekEnding ?? now()->endOfWeek(\Carbon\Carbon::SUNDAY)->toDateString())
);
    $steps = [
        1 => ['label' => __('Week'), 'icon' => 'ti ti-calendar-event'],
        2 => ['label' => __('Activities'), 'icon' => 'ti ti-clipboard-text'],
        3 => ['label' => __('Attendance'), 'icon' => 'ti ti-users'],
        4 => ['label' => __('Service'), 'icon' => 'ti ti-building-church'],
        5 => ['label' => __('Issues'), 'icon' => 'ti ti-alert-triangle'],
        6 => ['label' => __('Plans'), 'icon' => 'ti ti-list-check'],
        7 => ['label' => __('Files'), 'icon' => 'ti ti-paperclip'],
        8 => ['label' => __('Review'), 'icon' => 'ti ti-file-check'],
    ];
@endphp

@push('css')
    <link href="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css') }}" rel="stylesheet">
    <style>
        .report-shell {
            display: grid;
            gap: 1.25rem;
        }

        .report-hero,
        .report-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.06);
        }

        .report-hero {
            padding: 1.5rem;
            background: linear-gradient(135deg, #eef2ff 0%, #ffffff 48%, #f8fafc 100%);
        }

        .report-hero__meta {
            color: #64748b;
            font-size: 0.95rem;
        }

        .report-progress {
            display: grid;
            gap: 1rem;
            padding: 1.5rem;
        }

        .report-progress__bar {
            height: 6px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .report-progress__bar > span {
            display: block;
            width: 12.5%;
            height: 100%;
            background: linear-gradient(90deg, #312e81 0%, #4338ca 100%);
            transition: width 0.25s ease;
        }

        .report-step-list {
            display: flex;
            gap: 0.65rem;
            flex-wrap: wrap;
        }

        .report-step {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 0;
            border-radius: 999px;
            padding: 0.55rem 0.9rem;
            background: #eef2ff;
            color: #4338ca;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .report-step.is-active {
            background: #312e81;
            color: #fff;
            box-shadow: 0 10px 24px rgba(49, 46, 129, 0.25);
        }

        .report-card__header,
        .report-card__footer {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .report-card__footer {
            border-bottom: 0;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .report-card__body {
            padding: 1.5rem;
        }

        .report-pane {
            display: none;
        }

        .report-pane.is-active {
            display: block;
        }

        .report-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .report-stat {
            padding: 1rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 16px;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        }

        .report-stat__value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1;
        }

        .report-stat__label {
            color: #64748b;
            font-size: 0.85rem;
            margin-top: 0.35rem;
        }

        .report-note,
        .report-source {
            border-radius: 16px;
            padding: 1rem 1.1rem;
        }

        .report-note {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .report-source {
            background: #f8fafc;
            border: 1px solid rgba(15, 23, 42, 0.08);
            color: #334155;
        }

        .report-source strong,
        .review-card strong {
            color: #0f172a;
        }

        .report-label {
            color: #334155;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .report-review-grid {
            display: grid;
            gap: 1rem;
        }

        .review-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 18px;
            padding: 1rem 1.1rem;
            background: #fff;
        }

        .review-card__content {
            color: #475569;
            line-height: 1.65;
        }

        .review-card__content p:last-child {
            margin-bottom: 0;
        }

        .report-empty {
            color: #94a3b8;
            font-style: italic;
        }

        @media (max-width: 991px) {
            .report-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .report-progress,
            .report-card__header,
            .report-card__body,
            .report-card__footer,
            .report-hero {
                padding: 1rem;
            }

            .report-stat-grid {
                grid-template-columns: 1fr;
            }

            .report-card__footer {
                flex-direction: column;
            }

            .report-card__footer .btn {
                width: 100%;
            }
        }
    </style>
@endpush

{{ Form::model($feedback ?? null, [
    'route' => $formRoute,
    'method' => $formMethod,
    'enctype' => 'multipart/form-data',
    'id' => 'weekly-report-form',
]) }}

<div class="report-shell">
    <section class="report-hero">
        <div class="d-flex flex-wrap justify-content-between gap-3 align-items-start">
            <div>
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm me-2" style="width:40px;height:40px;">
                    <i class="ti ti-clipboard-list text-primary"></i>
                </div>
                <h4 class="d-inline-block mb-1">{{ $isEditing ? __('Update Weekly Report') : __('Submit Weekly Report') }}</h4>
                <p class="report-hero__meta mb-0">{{ __('Complete each section and review the report before submission. Attendance is linked automatically from existing attendance events or meeting records for the selected week.') }}</p>
            </div>
            <div class="text-end">
                <div class="small text-muted">{{ __('Status') }}</div>
                <div class="fw-semibold">{{ ucfirst($feedback->status ?? 'pending') }}</div>
            </div>
        </div>
    </section>

    <section class="report-card report-progress">
        <div class="d-flex justify-content-between gap-3 align-items-center flex-wrap">
            <div class="fw-semibold" id="report-step-title">{{ __('Step 1 of 8') }}</div>
            <div class="small text-muted" id="report-progress-label">{{ __('13% complete') }}</div>
        </div>
        <div class="report-progress__bar">
            <span id="report-progress-bar"></span>
        </div>
        <div class="report-step-list">
            @foreach($steps as $number => $step)
                <button type="button" class="report-step {{ $number === 1 ? 'is-active' : '' }}" data-step-target="{{ $number }}">
                    <i class="{{ $step['icon'] }}"></i>
                    <span>{{ $step['label'] }}</span>
                </button>
            @endforeach
        </div>
    </section>

    <section class="report-card">
        <div class="report-card__header">
            <h5 class="mb-1" id="report-section-title">{{ __('Week Selection') }}</h5>
            <div class="small text-muted" id="report-section-subtitle">{{ __('Choose the reporting week before the report details are completed.') }}</div>
        </div>

        <div class="report-card__body">
            <div class="report-pane is-active" data-step="1" data-title="{{ __('Week Selection') }}" data-subtitle="{{ __('Choose the reporting week before the report details are completed.') }}">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width:56px;height:56px;">
                                <i class="ti ti-calendar-event text-primary fs-4"></i>
                            </div>
                            <h5 class="mb-2">{{ __('Select Report Week') }}</h5>
                            <p class="text-muted mb-0">{{ __('The report will pull attendance from the latest matching attendance event or meeting created in this week.') }}</p>
                        </div>

                        <div class="form-group">
                            {{ Form::label('week_ending_date', __('Week Ending Date'), ['class' => 'report-label']) }}
                            {{ Form::date('week_ending_date', $weekEndingValue, ['class' => 'form-control', 'id' => 'week_ending_date', 'required']) }}
                            @error('week_ending_date')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-pane" data-step="2" data-title="{{ __('Activities & Achievements') }}" data-subtitle="{{ __('Capture what the department completed and the results achieved in the selected week.') }}">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="report-label">{{ __('Activities Carried Out') }}</label>
                        {{ Form::textarea('activities', old('activities', $reportPayload['activities'] ?? null), ['class' => 'form-control report-richtext', 'rows' => 8, 'data-review-title' => __('Activities')]) }}
                    </div>
                    <div class="col-12">
                        <label class="report-label">{{ __('Results & Achievements') }}</label>
                        {{ Form::textarea('achievements', old('achievements', $reportPayload['achievements'] ?? null), ['class' => 'form-control report-richtext', 'rows' => 8, 'data-review-title' => __('Achievements')]) }}
                    </div>
                </div>
            </div>

            <div class="report-pane" data-step="3" data-title="{{ __('Attendance') }}" data-subtitle="{{ __('Attendance is calculated automatically from the latest matching attendance event or meeting in the chosen week.') }}">
                <div class="report-source mb-3" id="attendance-source-box">
                    <div class="fw-semibold mb-1">{{ __('Attendance Source') }}</div>
                    <div id="attendance-source-label">{{ $attendanceSummary['source_label'] ?? __('Waiting for a week selection.') }}</div>
                    <div class="small text-muted mt-1">
                        {{ __('Mode') }}:
                        <span id="attendance-source-mode">{{ $attendanceSummary['source_mode'] ?? __('Not linked') }}</span>
                    </div>
                </div>

                <div class="report-stat-grid mb-3">
                    <div class="report-stat">
                        <div class="report-stat__value" id="attendance-rate">{{ $attendanceSummary['attendance_rate'] ?? 0 }}%</div>
                        <div class="report-stat__label">{{ __('Attendance Rate') }}</div>
                    </div>
                    <div class="report-stat">
                        <div class="report-stat__value" id="attendance-total">{{ $attendanceSummary['total_members'] ?? 0 }}</div>
                        <div class="report-stat__label">{{ __('Total Members') }}</div>
                    </div>
                    <div class="report-stat">
                        <div class="report-stat__value text-success" id="attendance-present">{{ $attendanceSummary['present_count'] ?? 0 }}</div>
                        <div class="report-stat__label">{{ __('Present') }}</div>
                    </div>
                    <div class="report-stat">
                        <div class="report-stat__value text-danger" id="attendance-absent">{{ $attendanceSummary['absent_count'] ?? 0 }}</div>
                        <div class="report-stat__label">{{ __('Absent / Not Captured') }}</div>
                    </div>
                </div>

                <div class="report-note" id="attendance-note">
                    {{ __('The attendance panel updates automatically when the week ending date changes. If no attendance event or meeting exists for that week yet, the report will stay unlinked until one is created.') }}
                </div>
            </div>

            <div class="report-pane" data-step="4" data-title="{{ __('Service Report') }}" data-subtitle="{{ __('Document the department contribution during the service and key observations.') }}">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="report-label">{{ __('Department Tasks During Service') }}</label>
                        {{ Form::textarea('service_tasks', old('service_tasks', $reportPayload['service_tasks'] ?? null), ['class' => 'form-control report-richtext', 'rows' => 8, 'data-review-title' => __('Service Tasks')]) }}
                    </div>
                    <div class="col-12">
                        <label class="report-label">{{ __('General Observations About the Service') }}</label>
                        {{ Form::textarea('service_observations', old('service_observations', $reportPayload['service_observations'] ?? null), ['class' => 'form-control report-richtext', 'rows' => 8, 'data-review-title' => __('Service Observations')]) }}
                    </div>
                </div>
            </div>

            <div class="report-pane" data-step="5" data-title="{{ __('Challenges & Support') }}" data-subtitle="{{ __('Capture blockers, risks, and the support needed from leadership or other teams.') }}">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="report-label">{{ __('Challenges Faced') }}</label>
                        {{ Form::textarea('challenges', old('challenges', $reportPayload['challenges'] ?? null), ['class' => 'form-control report-richtext', 'rows' => 7, 'data-review-title' => __('Challenges')]) }}
                    </div>
                    <div class="col-12">
                        <label class="report-label">{{ __('Support Needed') }}</label>
                        {{ Form::textarea('support_needed', old('support_needed', $reportPayload['support_needed'] ?? null), ['class' => 'form-control report-richtext', 'rows' => 7, 'data-review-title' => __('Support Needed')]) }}
                    </div>
                </div>
            </div>

            <div class="report-pane" data-step="6" data-title="{{ __('Plans & Suggestions') }}" data-subtitle="{{ __('Record what comes next and note any process or ministry suggestions.') }}">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="report-label">{{ __('Plans for Coming Week') }}</label>
                        {{ Form::textarea('plans', old('plans', $reportPayload['plans'] ?? null), ['class' => 'form-control report-richtext', 'rows' => 8, 'data-review-title' => __('Plans')]) }}
                    </div>
                    <div class="col-12">
                        <label class="report-label">{{ __('Suggestions & Recommendations') }}</label>
                        {{ Form::textarea('recommendations', old('recommendations', $reportPayload['recommendations'] ?? null), ['class' => 'form-control report-richtext', 'rows' => 8, 'data-review-title' => __('Recommendations')]) }}
                    </div>
                </div>
            </div>

            <div class="report-pane" data-step="7" data-title="{{ __('Attachments') }}" data-subtitle="{{ __('Upload any supporting document or image related to the weekly report.') }}">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <label class="report-label">{{ __('Attachment') }}</label>
                        {{ Form::file('attachment', ['class' => 'form-control']) }}
                        <div class="small text-muted mt-2">{{ __('Supported formats: images, PDF, Word, and text files up to 4MB.') }}</div>

                        @if (!empty($feedback?->attachment))
                            <div class="report-source mt-3">
                                <strong>{{ __('Current Attachment') }}:</strong>
                                <div class="mt-1">{{ basename($feedback->attachment) }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="report-pane" data-step="8" data-title="{{ __('Review & Submit') }}" data-subtitle="{{ __('Review each section before the report is saved.') }}">
                <div class="report-review-grid" id="report-review-grid"></div>
            </div>
        </div>

        <div class="report-card__footer">
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-light" id="report-prev">{{ __('Previous') }}</button>
                <a href="{{ route('feedback.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-primary" id="report-next">{{ __('Next') }}</button>
                <button type="submit" class="btn btn-primary d-none" id="report-submit">{{ $isEditing ? __('Update Report') : __('Submit Report') }}</button>
            </div>
        </div>
    </section>
</div>

{{ Form::close() }}

@push('scripts')
    <script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('weekly-report-form');
            const panes = Array.from(document.querySelectorAll('.report-pane'));
            const stepButtons = Array.from(document.querySelectorAll('.report-step'));
            const progressBar = document.getElementById('report-progress-bar');
            const progressLabel = document.getElementById('report-progress-label');
            const stepTitle = document.getElementById('report-step-title');
            const sectionTitle = document.getElementById('report-section-title');
            const sectionSubtitle = document.getElementById('report-section-subtitle');
            const prevButton = document.getElementById('report-prev');
            const nextButton = document.getElementById('report-next');
            const submitButton = document.getElementById('report-submit');
            const weekInput = document.getElementById('week_ending_date');
            const reviewGrid = document.getElementById('report-review-grid');
            let currentStep = 1;

            $('.report-richtext').summernote({
                height: 180,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            const escapeHtml = function (value) {
                const div = document.createElement('div');
                div.textContent = value || '';
                return div.innerHTML;
            };

            const renderAttendanceSummary = function (summary) {
                document.getElementById('attendance-source-label').textContent = summary.source_label || '{{ __('Waiting for a week selection.') }}';
                document.getElementById('attendance-source-mode').textContent = summary.source_mode || '{{ __('Not linked') }}';
                document.getElementById('attendance-rate').textContent = `${summary.attendance_rate ?? 0}%`;
                document.getElementById('attendance-total').textContent = summary.total_members ?? 0;
                document.getElementById('attendance-present').textContent = summary.present_count ?? 0;
                document.getElementById('attendance-absent').textContent = summary.absent_count ?? 0;

                document.getElementById('attendance-note').textContent = summary.is_auto_synced
                    ? '{{ __('Attendance is linked automatically from an existing attendance event or meeting in this week.') }}'
                    : '{{ __('No attendance event or meeting is linked to this week yet. Create or complete one first, then reopen the report to sync attendance.') }}';
            };

            const readFieldHtml = function (name) {
                const node = document.querySelector(`[name="${name}"]`);
                if (!node) {
                    return '';
                }

                if ($(node).next('.note-editor').length) {
                    return $(node).summernote('code');
                }

                return node.value || '';
            };

            const renderReview = function () {
                const sections = [
                    { title: '{{ __('Week Selection') }}', content: escapeHtml(weekInput.value || '') || '<span class="report-empty">{{ __('Not selected') }}</span>' },
                    { title: '{{ __('Activities & Achievements') }}', content: readFieldHtml('activities') + readFieldHtml('achievements') },
                    { title: '{{ __('Attendance') }}', content: `
                        <p><strong>{{ __('Source') }}:</strong> ${escapeHtml(document.getElementById('attendance-source-label').textContent)}</p>
                        <p><strong>{{ __('Rate') }}:</strong> ${escapeHtml(document.getElementById('attendance-rate').textContent)}</p>
                        <p><strong>{{ __('Present / Total') }}:</strong> ${escapeHtml(document.getElementById('attendance-present').textContent)} / ${escapeHtml(document.getElementById('attendance-total').textContent)}</p>
                    ` },
                    { title: '{{ __('Service') }}', content: readFieldHtml('service_tasks') + readFieldHtml('service_observations') },
                    { title: '{{ __('Challenges & Support') }}', content: readFieldHtml('challenges') + readFieldHtml('support_needed') },
                    { title: '{{ __('Plans & Suggestions') }}', content: readFieldHtml('plans') + readFieldHtml('recommendations') }
                ];

                reviewGrid.innerHTML = sections.map(function (section) {
                    const content = section.content && section.content.replace(/^(?:<p><br><\/p>|\s)*$/, '') ? section.content : '<span class="report-empty">{{ __('Not provided') }}</span>';
                    return `
                        <div class="review-card">
                            <strong>${section.title}</strong>
                            <div class="review-card__content mt-2">${content}</div>
                        </div>
                    `;
                }).join('');
            };

            const updateStepState = function () {
                panes.forEach(function (pane) {
                    pane.classList.toggle('is-active', Number(pane.dataset.step) === currentStep);
                });

                stepButtons.forEach(function (button) {
                    button.classList.toggle('is-active', Number(button.dataset.stepTarget) === currentStep);
                });

                const percentage = Math.round((currentStep / panes.length) * 100);
                progressBar.style.width = `${percentage}%`;
                progressLabel.textContent = `${percentage}% {{ __('complete') }}`;
                stepTitle.textContent = `{{ __('Step') }} ${currentStep} {{ __('of') }} ${panes.length}`;

                const activePane = panes.find(function (pane) {
                    return Number(pane.dataset.step) === currentStep;
                });

                sectionTitle.textContent = activePane.dataset.title;
                sectionSubtitle.textContent = activePane.dataset.subtitle;
                prevButton.disabled = currentStep === 1;
                nextButton.classList.toggle('d-none', currentStep === panes.length);
                submitButton.classList.toggle('d-none', currentStep !== panes.length);

                if (currentStep === panes.length) {
                    renderReview();
                }
            };

            const fetchAttendanceSummary = function () {
                if (!weekInput.value) {
                    return;
                }

                fetch(`{{ route('feedback.attendanceSummary') }}?week_ending_date=${encodeURIComponent(weekInput.value)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        renderAttendanceSummary(data);
                        if (currentStep === panes.length) {
                            renderReview();
                        }
                    })
                    .catch(function () {
                        document.getElementById('attendance-note').textContent = '{{ __('Attendance could not be loaded right now. Save the report and try again if the issue persists.') }}';
                    });
            };

            stepButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    currentStep = Number(button.dataset.stepTarget);
                    updateStepState();
                });
            });

            nextButton.addEventListener('click', function () {
                if (currentStep < panes.length) {
                    currentStep += 1;
                    updateStepState();
                }
            });

            prevButton.addEventListener('click', function () {
                if (currentStep > 1) {
                    currentStep -= 1;
                    updateStepState();
                }
            });

            weekInput.addEventListener('change', fetchAttendanceSummary);
            fetchAttendanceSummary();
            updateStepState();
        });
    </script>
@endpush

<?php
    $payload = $feedback->report_payload ?? [];
    $sections = [
        __('Activities & Achievements') => [$payload['activities'] ?? null, $payload['achievements'] ?? null],
        __('Service Report') => [$payload['service_tasks'] ?? null, $payload['service_observations'] ?? null],
        __('Challenges & Support') => [$payload['challenges'] ?? null, $payload['support_needed'] ?? null],
        __('Plans & Suggestions') => [$payload['plans'] ?? null, $payload['recommendations'] ?? null],
    ];
?>

<div class="d-grid gap-3">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0"><?php echo e(__('Report Overview')); ?></h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="text-muted small"><?php echo e(__('Week Ending')); ?></div>
                        <div class="fw-semibold"><?php echo e($feedback->week_ending_formatted); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="text-muted small"><?php echo e(__('Department')); ?></div>
                        <div class="fw-semibold"><?php echo e(optional($feedback->department)->name ?? __('General')); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="text-muted small"><?php echo e(__('Submitted By')); ?></div>
                        <div class="fw-semibold"><?php echo e($feedback->is_anonymous ? __('Anonymous') : ($feedback->name ?? __('Unknown'))); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0"><?php echo e(__('Attendance Snapshot')); ?></h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small"><?php echo e(__('Source')); ?></div>
                        <div class="fw-semibold"><?php echo e($attendanceSummary['source_label'] ?? __('Not linked')); ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small"><?php echo e(__('Attendance Rate')); ?></div>
                        <div class="fw-semibold"><?php echo e($attendanceSummary['attendance_rate'] ?? 0); ?>%</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small"><?php echo e(__('Total')); ?></div>
                        <div class="fw-semibold"><?php echo e($attendanceSummary['total_members'] ?? 0); ?></div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small"><?php echo e(__('Present')); ?></div>
                        <div class="fw-semibold text-success"><?php echo e($attendanceSummary['present_count'] ?? 0); ?></div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small"><?php echo e(__('Absent')); ?></div>
                        <div class="fw-semibold text-danger"><?php echo e($attendanceSummary['absent_count'] ?? 0); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title => $parts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e($title); ?></h5>
            </div>
            <div class="card-body">
                <?php $content = collect($parts)->filter()->implode(''); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($content): ?>
                    <?php echo $content; ?>

                <?php else: ?>
                    <p class="text-muted mb-0"><?php echo e(__('No details provided.')); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feedback->attachment): ?>
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e(__('Attachment')); ?></h5>
            </div>
            <div class="card-body">
                <?php
                    $fileName = basename($feedback->attachment);
                ?>
                <a href="<?php echo e(route('feedback.download', $fileName)); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                    <i class="ti ti-download me-1"></i><?php echo e(__('Open Attachment')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\_report_sections.blade.php ENDPATH**/ ?>
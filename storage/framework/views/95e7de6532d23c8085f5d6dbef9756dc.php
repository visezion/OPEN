<?php $__env->startSection('page-title', __('Report Details')); ?>
<?php $__env->startSection('page-breadcrumb', __('Weekly Reports')); ?>

<?php $__env->startSection('page-action'); ?>
    <?php
        $canEditFeedback = auth()->user()->isAbleTo('feedback edit')
            && (
                auth()->user()->isAbleTo('feedback view all')
                || ((int) $feedback->submitted_by === (int) auth()->id())
            );
    ?>
    <a href="<?php echo e(route('feedback.dashboard')); ?>" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="<?php echo e(__('Weekly Reports Dashboard')); ?>">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
    <a href="<?php echo e(route('feedback.index')); ?>" class="btn btn-sm btn-danger me-1" data-bs-toggle="tooltip" title="<?php echo e(__('Back to Weekly Reports')); ?>">
        <i class="ti ti-arrow-back-up"></i>
    </a>
    <a href="<?php echo e(route('feedback.create')); ?>" class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="<?php echo e(__('Create Weekly Report')); ?>">
        <i class="ti ti-plus"></i>
    </a>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEditFeedback): ?>
        <a href="<?php echo e(route('feedback.edit', \Illuminate\Support\Facades\Crypt::encrypt($feedback->id))); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="<?php echo e(__('Edit Weekly Report')); ?>">
            <i class="ti ti-pencil"></i>
        </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feedback->isReport()): ?>
        <?php echo $__env->make('churchly::feedback._report_sections', ['feedback' => $feedback, 'attendanceSummary' => $attendanceSummary], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e($feedback->title ?? __('Untitled Weekly Report')); ?></h5>
            </div>
            <div class="card-body">
                <div class="mb-3"><strong><?php echo e(__('Submitted By')); ?>:</strong> <?php echo e($feedback->is_anonymous ? __('Anonymous') : ($feedback->name ?? 'N/A')); ?></div>
                <div class="mb-3"><strong><?php echo e(__('Department')); ?>:</strong> <?php echo e(optional($feedback->department)->name ?? 'N/A'); ?></div>
                <div class="mb-3"><strong><?php echo e(__('Submitted At')); ?>:</strong> <?php echo e($feedback->formatted_submitted_at); ?></div>
                <div class="border rounded-3 p-3 bg-light"><?php echo $feedback->message; ?></div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\show.blade.php ENDPATH**/ ?>
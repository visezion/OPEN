<?php $__env->startSection('page-title', __('Maintenance log')); ?>
<?php $__env->startSection('page-breadcrumb', 'Maintenance,LogDetail'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3">
                <h5 class="mb-0"><?php echo e(__('Log for :asset', ['asset' => $log->schedule->asset_name])); ?></h5>
                <a href="<?php echo e(route('maintenance.show', $log->schedule)); ?>" class="btn btn-outline-secondary btn-sm">
                    <?php echo e(__('Back to schedule')); ?>

                </a>
            </div>
            <div class="row mt-4 g-3">
                <div class="col-md-4">
                    <p class="text-muted mb-1"><?php echo e(__('Due date')); ?></p>
                    <strong><?php echo e(optional($log->due_date)->format('Y-m-d')); ?></strong>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1"><?php echo e(__('Status')); ?></p>
                    <span class="badge bg-primary"><?php echo e(ucfirst($log->status)); ?></span>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1"><?php echo e(__('Performed by')); ?></p>
                    <strong><?php echo e($log->performedBy->name ?? __('Pending')); ?></strong>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1"><?php echo e(__('Reported by')); ?></p>
                    <strong><?php echo e($log->reportedBy->name ?? __('System')); ?></strong>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1"><?php echo e(__('Started at')); ?></p>
                    <strong><?php echo e(optional($log->started_at)->format('Y-m-d H:i') ?? __('Not started')); ?></strong>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1"><?php echo e(__('Completed at')); ?></p>
                    <strong><?php echo e(optional($log->completed_at)->format('Y-m-d H:i') ?? __('Pending')); ?></strong>
                </div>
                <div class="col-12">
                    <p class="text-muted mb-1"><?php echo e(__('Notes')); ?></p>
                    <div class="border rounded-2 p-3 bg-light">
                        <?php echo e($log->notes ?? __('No notes recorded')); ?>

                    </div>
                </div>
                <div class="col-12">
                    <p class="text-muted mb-1"><?php echo e(__('Cost incurred')); ?></p>
                    <strong><?php echo e($log->cost_incurred ?? __('N/A')); ?></strong>
                </div>
                <div class="col-12">
                    <p class="text-muted mb-1"><?php echo e(__('Attachments')); ?></p>
                    <strong><?php echo e($log->attachments ?? __('None')); ?></strong>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\maintenance\log.blade.php ENDPATH**/ ?>
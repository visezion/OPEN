<?php $__env->startSection('page-title', __('Review Report')); ?>
<?php $__env->startSection('page-breadcrumb', __('Reports')); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('feedback.dashboard')); ?>" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="<?php echo e(__('Reports Dashboard')); ?>">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
    <a href="<?php echo e(route('feedback.index')); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="<?php echo e(__('Go Back')); ?>">
        <i class="ti ti-arrow-back-up"></i>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feedback->isReport()): ?>
                <?php echo $__env->make('churchly::feedback._report_sections', ['feedback' => $feedback, 'attendanceSummary' => $attendanceSummary], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo e($feedback->title); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="border rounded-3 p-3 bg-light"><?php echo $feedback->message; ?></div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Response to Report')); ?></h5>
                </div>
                <div class="card-body">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feedback->admin_response): ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><?php echo e(__('Previous Response')); ?></label>
                            <div class="border rounded-3 p-3 bg-light"><?php echo nl2br($feedback->admin_response); ?></div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form action="<?php echo e(route('feedback.updateResponse', $feedback->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label for="admin_response" class="form-label fw-semibold"><?php echo e(__('Your Response')); ?></label>
                            <textarea name="admin_response" class="form-control summernote" rows="6" required><?php echo e(old('admin_response', $feedback->admin_response)); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold"><?php echo e(__('Update Status')); ?></label>
                            <select name="status" class="form-select" required>
                                <option value="pending" <?php echo e($feedback->status == 'pending' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                <option value="reviewed" <?php echo e($feedback->status == 'reviewed' ? 'selected' : ''); ?>><?php echo e(__('Reviewed')); ?></option>
                                <option value="resolved" <?php echo e($feedback->status == 'resolved' ? 'selected' : ''); ?>><?php echo e(__('Resolved')); ?></option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100"><?php echo e(__('Save Review')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
    <script>
        $(function () {
            $('.summernote').summernote({
                height: 180,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\review.blade.php ENDPATH**/ ?>
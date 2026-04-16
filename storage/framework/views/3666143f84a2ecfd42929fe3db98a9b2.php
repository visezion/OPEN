

<?php $__env->startSection('page-title', __('Reply to Feedback')); ?>
<?php $__env->startSection('page-breadcrumb', __('Feedback')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e(__('Feedback Details')); ?></h5>
            </div>

            <div class="card-body">
                <p><strong><?php echo e(__('Title')); ?>:</strong> <?php echo e($feedback->title ?? '-'); ?></p>
                <p><strong><?php echo e(__('Type')); ?>:</strong> <?php echo e(ucfirst($feedback->type)); ?></p>
                <p><strong><?php echo e(__('Category')); ?>:</strong> <?php echo e(ucfirst($feedback->category)); ?></p>
                <p><strong><?php echo e(__('Submitted By')); ?>:</strong> <?php echo e($feedback->is_anonymous ? 'Anonymous' : $feedback->name); ?></p>
                <p><strong><?php echo e(__('Email')); ?>:</strong> <?php echo e($feedback->is_anonymous ? '-' : $feedback->email); ?></p>
                <p><strong><?php echo e(__('Message')); ?>:</strong></p>
                <p><?php echo nl2br(e($feedback->message)); ?></p>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feedback->attachment): ?>
                    <p><strong><?php echo e(__('Attachment')); ?>:</strong>
                        <a href="<?php echo e(asset('storage/' . $feedback->attachment)); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <?php echo e(__('View File')); ?>

                        </a>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <hr>

                <form method="POST" action="<?php echo e(route('churchly.feedback.reply.update', $feedback->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-3">
                        <label for="admin_response" class="form-label"><?php echo e(__('Your Response')); ?></label>
                        <textarea name="admin_response" id="admin_response" class="form-control" rows="6" required><?php echo e(old('admin_response', $feedback->admin_response)); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label"><?php echo e(__('Update Status')); ?></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" <?php echo e($feedback->status === 'pending' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                            <option value="reviewed" <?php echo e($feedback->status === 'reviewed' ? 'selected' : ''); ?>><?php echo e(__('Reviewed')); ?></option>
                            <option value="resolved" <?php echo e($feedback->status === 'resolved' ? 'selected' : ''); ?>><?php echo e(__('Resolved')); ?></option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><?php echo e(__('Submit Response')); ?></button>
                        <a href="<?php echo e(route('churchly.feedback.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\reply.blade.php ENDPATH**/ ?>
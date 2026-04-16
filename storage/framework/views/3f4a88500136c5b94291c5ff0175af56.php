<?php $__env->startSection('page-title', __('Communication Log')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header"><h6 class="mb-0"><?php echo e(__('Log Communication')); ?></h6></div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('churchly.care.communications.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Member')); ?></label>
                        <select name="member_id" class="form-select" required>
                            <option value=""><?php echo e(__('Select member')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('member_id') == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Channel')); ?></label>
                        <select name="channel" class="form-select" required>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['email','sms','call','visit','other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($channel); ?>" <?php echo e(old('channel') == $channel ? 'selected' : ''); ?>><?php echo e(ucfirst($channel)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Subject')); ?></label>
                        <input type="text" name="subject" class="form-control" value="<?php echo e(old('subject')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Sent at')); ?></label>
                        <input type="datetime-local" name="sent_at" class="form-control" value="<?php echo e(old('sent_at')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Summary / Notes')); ?></label>
                        <textarea name="body" rows="3" class="form-control"><?php echo e(old('body')); ?></textarea>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary"><?php echo e(__('Save Communication')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Member')); ?></th>
                            <th><?php echo e(__('Channel')); ?></th>
                            <th><?php echo e(__('Subject')); ?></th>
                            <th><?php echo e(__('Sent')); ?></th>
                            <th><?php echo e(__('Sender')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $communications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $communication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(optional($communication->member)->name ?? '-'); ?></td>
                                <td class="text-uppercase"><?php echo e($communication->channel); ?></td>
                                <td><?php echo e($communication->subject ?? '—'); ?></td>
                                <td class="small text-muted"><?php echo e(optional($communication->sent_at ?? $communication->created_at)->format('Y-m-d H:i')); ?></td>
                                <td><?php echo e(optional($communication->sender)->name ?? '—'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted"><?php echo e(__('No communications found.')); ?></td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($communications->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\care\communications\index.blade.php ENDPATH**/ ?>
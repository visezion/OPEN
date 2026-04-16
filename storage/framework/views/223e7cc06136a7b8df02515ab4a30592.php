<?php $__env->startSection('page-title', __('Pastoral Notes')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header"><h6 class="mb-0"><?php echo e(__('Quick Add Note')); ?></h6></div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('churchly.care.notes.store')); ?>">
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
                        <label class="form-label"><?php echo e(__('Title')); ?></label>
                        <input type="text" name="title" value="<?php echo e(old('title')); ?>" class="form-control" placeholder="<?php echo e(__('Optional subject line')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Confidential Note')); ?></label>
                        <textarea name="body" rows="4" class="form-control" required><?php echo e(old('body')); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Visibility')); ?></label>
                        <select name="visibility" class="form-select" required>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['staff','pastoral','leaders','private']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($option); ?>" <?php echo e(old('visibility') == $option ? 'selected' : ''); ?>><?php echo e(ucfirst($option)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="requires_attention" value="1" id="note-attention" <?php echo e(old('requires_attention') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="note-attention"><?php echo e(__('Flag for pastoral attention')); ?></label>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary"><?php echo e(__('Save Note')); ?></button>
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
                            <th><?php echo e(__('Title')); ?></th>
                            <th><?php echo e(__('Visibility')); ?></th>
                            <th><?php echo e(__('When')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(optional($note->member)->name ?? '-'); ?></td>
                                <td><?php echo e($note->title ?? __('Note')); ?></td>
                                <td><span class="badge bg-secondary text-uppercase"><?php echo e($note->visibility); ?></span></td>
                                <td class="small text-muted"><?php echo e($note->created_at->diffForHumans()); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted"><?php echo e(__('No notes found.')); ?></td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($notes->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\care\notes\index.blade.php ENDPATH**/ ?>
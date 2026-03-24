

<?php $__env->startSection('page-title', __('Follow-up Workflow')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header"><h6 class="mb-0"><?php echo e(__('Quick Create Follow-up')); ?></h6></div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('churchly.care.followups.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Member')); ?></label>
                        <select name="member_id" class="form-select" required>
                            <option value=""><?php echo e(__('Select member')); ?></option>
                            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('member_id') == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Subject')); ?></label>
                        <input type="text" name="subject" value="<?php echo e(old('subject')); ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Notes / Instructions')); ?></label>
                        <textarea name="description" rows="3" class="form-control"><?php echo e(old('description')); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Due date')); ?></label>
                        <input type="date" name="due_at" value="<?php echo e(old('due_at')); ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Assign to')); ?></label>
                        <select name="assigned_to" class="form-select">
                            <option value=""><?php echo e(__('Unassigned')); ?></option>
                            <?php $__currentLoopData = $careTeamUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('assigned_to') == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Status')); ?></label>
                        <select name="status" class="form-select" required>
                            <?php $__currentLoopData = ['open','in_progress','completed','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(old('status', 'open') == $status ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_',' ', $status))); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary"><?php echo e(__('Create Follow-up')); ?></button>
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
                            <th><?php echo e(__('Subject')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Due')); ?></th>
                            <th><?php echo e(__('Assignee')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $followups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(optional($followup->member)->name ?? '-'); ?></td>
                                <td><?php echo e($followup->subject); ?></td>
                                <td><span class="badge bg-info text-uppercase"><?php echo e($followup->status); ?></span></td>
                                <td class="small text-muted"><?php echo e(optional($followup->due_at)->format('Y-m-d') ?? '—'); ?></td>
                                <td><?php echo e(optional($followup->assignee)->name ?? '—'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted"><?php echo e(__('No follow-ups found.')); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($followups->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\care\followups\index.blade.php ENDPATH**/ ?>
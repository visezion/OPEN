

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Volunteer Skills')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Skills Library')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <?php if (app('laratrust')->hasPermission('church_volunteer create')) : ?>
        <a href="<?php echo e(route('churchly.volunteer-skills.create')); ?>"
           class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Skill')); ?>

        </a>
    <?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><?php echo e(__('Skill Directory')); ?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Name')); ?></th>
                            <th><?php echo e(__('Category')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Volunteers Tagged')); ?></th>
                            <th class="text-end"><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="fw-semibold"><?php echo e($skill->name); ?></td>
                                <td><?php echo e($skill->category ?? '—'); ?></td>
                                <td>
                                    <span class="badge <?php echo e($skill->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                                        <?php echo e($skill->is_active ? __('Active') : __('Archived')); ?>

                                    </span>
                                </td>
                                <td><?php echo e($skill->volunteers_count); ?></td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <!-- Edit Button -->
                                        <a href="<?php echo e(route('churchly.volunteer-skills.edit', $skill)); ?>"
                                           class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="<?php echo e(__('Edit Skill')); ?>">
                                            <i class="ti ti-pencil"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <?php echo Form::open([
                                            'route' => ['churchly.volunteer-skills.destroy', $skill],
                                            'method' => 'DELETE',
                                            'onsubmit' => "return confirm('".__('Are you sure you want to delete this skill?')."');"
                                        ]); ?>

                                            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="<?php echo e(__('Delete Skill')); ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        <?php echo Form::close(); ?>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5">
                                    <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  <!-- Ensure this view exists -->
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($skills->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\volunteers\skills\index.blade.php ENDPATH**/ ?>


<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Church Members')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Church Members')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <a href="<?php echo e(route('churchly.members.create')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="<?php echo e(__('Add New Member')); ?>">
            <i class="ti ti-plus"></i> 
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Phone')); ?></th>
                                <th><?php echo e(__('DOB')); ?></th>
                                <th><?php echo e(__('Address')); ?></th>
                                <th class="text-end"><?php echo e(__('Actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($member->name); ?></td>
                                    <td><?php echo e($member->email ?? '-'); ?></td>
                                    <td><?php echo e($member->phone ?? '-'); ?></td>
                                    <td><?php echo e($member->dob ?? '-'); ?></td>
                                    <td><?php echo e(\Illuminate\Support\Str::limit($member->address, 30) ?? '-'); ?></td>
                                    <td class="text-end">
                                        <a href="<?php echo e(route('members.show', $member->id)); ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                        <a href="<?php echo e(route('churchly.members.edit', $member->id)); ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>

                                        <form action="<?php echo e(route('churchly.members.destroy', $member->id)); ?>" method="POST" class="d-inline-block">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>">
                                                <i class="ti ti-trash text-white"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted"><?php echo e(__('No members found.')); ?></td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <?php echo e($members->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\old_index.blade.php ENDPATH**/ ?>
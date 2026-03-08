<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Volunteers')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Volunteer Management')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <?php if (app('laratrust')->hasPermission('church_volunteer create')) : ?>
        <a href="<?php echo e(route('churchly.volunteers.create')); ?>"
           class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Volunteer')); ?>

        </a>
    <?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small"><?php echo e(__('Active Volunteers')); ?></div>
                    <div class="display-6 fw-bold"><?php echo e($summary['active'] ?? 0); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small"><?php echo e(__('Inactive')); ?></div>
                    <div class="display-6 fw-bold"><?php echo e($summary['inactive'] ?? 0); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small"><?php echo e(__('Paused / On Hold')); ?></div>
                    <div class="display-6 fw-bold"><?php echo e($summary['paused'] ?? 0); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><?php echo e(__('Volunteer Directory')); ?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Name')); ?></th>
                            <th><?php echo e(__('Departments')); ?></th>
                            <th><?php echo e(__('Skills')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Joined')); ?></th>
                            <th class="text-end"><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $volunteers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $volunteer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?php echo e($volunteer->display_name); ?></div>
                                    <?php if($volunteer->member): ?>
                                        <div class="small text-muted"><?php echo e(__('Member ID:')); ?> <?php echo e($volunteer->member->formatted_member_id ?? $volunteer->member->member_id); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="small">
                                    <?php $__empty_2 = true; $__currentLoopData = $volunteer->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span class="badge bg-light text-dark mb-1">
                                            <?php echo e($department->name); ?>

                                            <?php if(data_get($department, 'pivot.is_primary')): ?>
                                                <span class="text-success ms-1"><?php echo e(__('(Primary)')); ?></span>
                                            <?php endif; ?>
                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span class="text-muted"><?php echo e(__('Unassigned')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="small">
                                    <?php $__empty_2 = true; $__currentLoopData = $volunteer->skills->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span class="badge bg-secondary mb-1">
                                            <?php echo e($skill->name); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span class="text-muted"><?php echo e(__('No skills tagged')); ?></span>
                                    <?php endif; ?>
                                    <?php if($volunteer->skills->count() > 4): ?>
                                        <span class="badge bg-light text-dark mb-1">+<?php echo e($volunteer->skills->count() - 4); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $statusColor = [
                                            'active' => 'success',
                                            'inactive' => 'secondary',
                                            'paused' => 'warning',
                                        ][$volunteer->status] ?? 'light text-dark';
                                    ?>
                                    <span class="badge bg-<?php echo e($statusColor); ?>"><?php echo e(ucfirst($volunteer->status)); ?></span>
                                </td>
                                <td class="small text-muted">
                                    <?php echo e(optional($volunteer->joined_at)->format('d M Y') ?? '—'); ?>

                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="<?php echo e(route('churchly.volunteers.show', $volunteer)); ?>"
                                           class="btn btn-sm btn-light">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <?php if (app('laratrust')->hasPermission('church_volunteer manage')) : ?>
                                            <a href="<?php echo e(route('churchly.volunteers.edit', $volunteer)); ?>"
                                               class="btn btn-sm btn-info text-white">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                        <?php endif; // app('laratrust')->permission ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6">
                                    <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($volunteers->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\volunteers\index.blade.php ENDPATH**/ ?>
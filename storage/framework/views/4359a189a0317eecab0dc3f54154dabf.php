<?php $__env->startSection('page-title', __('Maintenance')); ?>
<?php $__env->startSection('page-breadcrumb', 'Maintenance'); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('maintenance.create')); ?>" class="btn btn-primary">
        <?php echo e(__('New Schedule')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $filters = $filters ?? [];
        $query = request()->query() ?: [];
        $excelQuery = array_merge($query, ['format' => 'excel']);
        $pdfQuery = array_merge($query, ['format' => 'pdf']);
    ?>
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Active schedules')); ?></h6>
                <div class="d-flex align-items-center justify-content-between">
                    <strong class="fs-4"><?php echo e($stats['total_active']); ?></strong>
                    <span class="badge bg-soft-success"><?php echo e(__('Live')); ?></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Overdue tasks')); ?></h6>
                <strong class="fs-4 text-danger"><?php echo e($stats['overdue']); ?></strong>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Due this week')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['due_this_week']); ?></strong>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Completed this month')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['completed_this_month']); ?></strong>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0"><?php echo e(__('Filters')); ?></h5>
                <div class="btn-group" role="group">
                    <a href="<?php echo e(route('maintenance.export', $excelQuery)); ?>" target="_blank" class="btn btn-outline-success btn-sm">
                        <?php echo e(__('Download Excel')); ?>

                    </a>
                    <a href="<?php echo e(route('maintenance.export', $pdfQuery)); ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                        <?php echo e(__('Download PDF')); ?>

                    </a>
                    <a href="<?php echo e(route('maintenance.print', $query)); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                        <?php echo e(__('Printable view')); ?>

                    </a>
                </div>
            </div>
            <form method="get" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label"><?php echo e(__('Status')); ?></label>
                    <select name="status" class="form-select">
                        <option value=""><?php echo e(__('Any status')); ?></option>
                        <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(data_get($filters, 'status') == $value ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label"><?php echo e(__('Priority')); ?></label>
                    <select name="priority" class="form-select">
                        <option value=""><?php echo e(__('All')); ?></option>
                        <?php $__currentLoopData = $priorityOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(data_get($filters, 'priority') == $value ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label"><?php echo e(__('Category')); ?></label>
                    <select name="category" class="form-select">
                        <option value=""><?php echo e(__('Any')); ?></option>
                        <?php $__currentLoopData = $categoryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>" <?php echo e(data_get($filters, 'category') == $category ? 'selected' : ''); ?>>
                                <?php echo e($category); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label"><?php echo e(__('Branch')); ?></label>
                    <select name="branch_id" class="form-select">
                        <option value=""><?php echo e(__('Any branch')); ?></option>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(data_get($filters, 'branch_id') == $id ? 'selected' : ''); ?>>
                                <?php echo e($name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label"><?php echo e(__('Department')); ?></label>
                    <select name="department_id" class="form-select">
                        <option value=""><?php echo e(__('Any department')); ?></option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(data_get($filters, 'department_id') == $id ? 'selected' : ''); ?>>
                                <?php echo e($name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label"><?php echo e(__('From')); ?></label>
                    <input type="date" name="from" class="form-control" value="<?php echo e(data_get($filters, 'from') ?? ''); ?>">
                </div>
                <div class="col-md-1">
                    <label class="form-label"><?php echo e(__('To')); ?></label>
                    <input type="date" name="to" class="form-control" value="<?php echo e(data_get($filters, 'to') ?? ''); ?>">
                </div>
                <div class="col-md-12 text-end">
                    <button class="btn btn-secondary"><?php echo e(__('Apply filters')); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th><?php echo e(__('Asset')); ?></th>
                        <th><?php echo e(__('Category')); ?></th>
                        <th><?php echo e(__('Branch / Department')); ?></th>
                        <th><?php echo e(__('Priority')); ?></th>
                        <th><?php echo e(__('Next due')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Assigned to')); ?></th>
                        <th class="text-end"><?php echo e(__('Actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong><?php echo e($schedule->asset_name); ?></strong><br>
                                <small class="text-muted"><?php echo e($schedule->asset_code); ?></small>
                            </td>
                            <td><?php echo e($schedule->category); ?></td>
                            <td>
                                <?php echo e($schedule->branch->name ?? __('Headquarters')); ?> /
                                <?php echo e($schedule->department->name ?? __('General')); ?>

                            </td>
                            <td>
                                <span class="badge bg-soft-<?php echo e(match ($schedule->priority) {
                                    'critical' => 'danger',
                                    'high' => 'warning',
                                    'low' => 'secondary',
                                    default => 'primary',
                                }); ?>">
                                    <?php echo e(ucfirst($schedule->priority)); ?>

                                </span>
                            </td>
                            <td>
                                <?php echo e(optional($schedule->next_due_date)->format('Y-m-d')); ?>

                                <?php if($schedule->next_due_date && $schedule->next_due_date->isBefore(today())): ?>
                                    <span class="badge bg-danger"><?php echo e(__('Overdue')); ?></span>
                                <?php elseif($schedule->next_due_date && $schedule->next_due_date->isBetween(today(), today()->addDays(3))): ?>
                                    <span class="badge bg-warning"><?php echo e(__('Due soon')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo e($schedule->status === 'active' ? 'success' : 'secondary'); ?>">
                                    <?php echo e($statusOptions[$schedule->status] ?? ucfirst($schedule->status)); ?>

                                </span>
                            </td>
                            <td><?php echo e($schedule->assignedTo->name ?? __('Unassigned')); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('maintenance.show', $schedule)); ?>" class="btn btn-sm btn-outline-primary"><?php echo e(__('View')); ?></a>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('maintenance schedule edit')): ?>
                                    <a href="<?php echo e(route('maintenance.edit', $schedule)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Edit')); ?></a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('maintenance schedule delete')): ?>
                                    <form action="<?php echo e(route('maintenance.destroy', $schedule)); ?>" method="post" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('<?php echo e(__('Are you sure?')); ?>');">
                                            <?php echo e(__('Delete')); ?>

                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4"><?php echo e(__('No maintenance schedules matched the current filters.')); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($schedules->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\maintenance\index.blade.php ENDPATH**/ ?>
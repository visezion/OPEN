<?php $__env->startSection('page-title', __('Maintenance schedules – Print')); ?>
<?php $__env->startSection('page-breadcrumb', __('Maintenance')); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('maintenance.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <?php echo e(__('Back to list')); ?>

    </a>
    <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.print();">
        <?php echo e(__('Print now')); ?>

    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $filters = $filters ?? [];
    ?>
    <div class="card print-card">
        <div class="card-body">
            <h5 class="card-title mb-4"><?php echo e(__('Printable maintenance report')); ?></h5>
            <div class="mb-4">
                <strong class="d-block mb-2"><?php echo e(__('Active filters')); ?></strong>
                <?php
                    $activeFilters = collect($filters)->filter(fn ($value) => !empty($value));
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeFilters->isEmpty()): ?>
                    <p class="text-muted mb-0"><?php echo e(__('None')); ?></p>
                <?php else: ?>
                    <ul class="list-inline mb-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $activeFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-inline-item badge bg-light text-dark border">
                                <?php echo e(ucfirst(str_replace('_', ' ', $key))); ?>: <?php echo e(ucfirst($value)); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><?php echo e(__('Asset')); ?></th>
                            <th><?php echo e(__('Category')); ?></th>
                            <th><?php echo e(__('Branch')); ?></th>
                            <th><?php echo e(__('Department')); ?></th>
                            <th><?php echo e(__('Priority')); ?></th>
                            <th><?php echo e(__('Next due')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Assigned to')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($schedule->asset_name); ?></strong><br>
                                    <small class="text-muted"><?php echo e($schedule->asset_code); ?></small>
                                </td>
                                <td><?php echo e($schedule->category); ?></td>
                                <td><?php echo e($schedule->branch->name ?? __('Headquarters')); ?></td>
                                <td><?php echo e($schedule->department->name ?? __('General')); ?></td>
                                <td><?php echo e(ucfirst($schedule->priority)); ?></td>
                                <td><?php echo e(optional($schedule->next_due_date)->format('Y-m-d')); ?></td>
                                <td><?php echo e(ucfirst($schedule->status)); ?></td>
                                <td><?php echo e($schedule->assignedTo->name ?? __('Unassigned')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4"><?php echo e(__('No records to print.')); ?></td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-card, .print-card * {
                visibility: visible;
            }

            .print-card {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            aside, .sidebar, .navbar, .layout-footer {
                display: none !important;
            }
        }

        .print-card {
            background: #fff;
            border: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => setTimeout(() => window.print(), 200));
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\maintenance\print.blade.php ENDPATH**/ ?>
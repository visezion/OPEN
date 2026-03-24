<?php $__env->startSection('page-title', __('Asset dashboard')); ?>
<?php $__env->startSection('page-breadcrumb', __('Assets')); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Inventory')); ?></a>
        <a href="<?php echo e(route('assets.reports')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Reports')); ?></a>
        <a href="<?php echo e(route('assets.settings.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Settings')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
    .asset-dashboard-page .card {
        border: 1px solid var(--bs-border-color, #d8e2ef) !important;
        box-shadow: none !important;
    }

    .asset-dashboard-page .section-label {
        font-size: 0.74rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 600;
        color: var(--bs-secondary-color);
    }

    .asset-dashboard-page .hero-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--bs-heading-color, #1f2937);
    }

    .asset-dashboard-page .metric-card .metric-value {
        font-size: 1.65rem;
        font-weight: 700;
        line-height: 1.1;
        margin-top: 0.35rem;
    }

    .asset-dashboard-page .metric-card .metric-help {
        margin-top: 0.3rem;
        color: var(--bs-secondary-color);
        font-size: 0.8rem;
    }

    .asset-dashboard-page .panel-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--bs-heading-color, #1f2937);
    }

    .asset-dashboard-page .activity-item {
        border: 1px solid var(--bs-border-color, #d8e2ef);
        border-radius: 10px;
        padding: 0.8rem 0.9rem;
    }

    .asset-dashboard-page .activity-meta {
        color: var(--bs-secondary-color);
        font-size: 0.8rem;
    }

    .asset-dashboard-page .status-chip {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--bs-border-color, #d8e2ef);
        border-radius: 999px;
        padding: 0.18rem 0.6rem;
        font-size: 0.74rem;
        font-weight: 600;
    }

    .asset-dashboard-page .status-ok { color: #0f7a45; }
    .asset-dashboard-page .status-attention { color: #8a6d1e; }
    .asset-dashboard-page .status-critical { color: #b02a37; }

    .asset-dashboard-page .settings-list .list-group-item {
        border-color: var(--bs-border-color, #d8e2ef);
        padding-top: 0.9rem;
        padding-bottom: 0.9rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="asset-dashboard-page">
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-8">
                        <div class="section-label"><?php echo e(__('Asset analytics')); ?></div>
                        <div class="hero-title"><?php echo e(__('Asset Operations Performance Dashboard')); ?></div>
                        <p class="text-muted mb-0">
                            <?php echo e(__('Monitor inventory health, movement activity, and compliance checks from a single operational view.')); ?>

                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?php echo e(route('assets.create')); ?>" class="btn btn-primary"><?php echo e(__('Register New Asset')); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Total items')); ?></div>
                        <div class="metric-value"><?php echo e($stats['total_items']); ?></div>
                        <div class="metric-help"><?php echo e(__('Active inventory records')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Quantity on record')); ?></div>
                        <div class="metric-value"><?php echo e($stats['total_quantity']); ?></div>
                        <div class="metric-help"><?php echo e(__('All tracked units')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Available quantity')); ?></div>
                        <div class="metric-value"><?php echo e($stats['available_quantity']); ?></div>
                        <div class="metric-help"><?php echo e(__('Ready for deployment')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Low stock alerts')); ?></div>
                        <div class="metric-value text-danger"><?php echo e($stats['low_stock']); ?></div>
                        <div class="metric-help"><?php echo e(__('Require immediate review')); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header bg-transparent">
                        <div class="panel-title"><?php echo e(__('Recent Movements')); ?></div>
                        <p class="text-muted mb-0"><?php echo e(__('Latest branch and department transfer activity.')); ?></p>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $recentMovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="activity-item">
                                <div class="fw-semibold"><?php echo e($movement->asset->asset_name ?? __('Unknown asset')); ?></div>
                                <div class="activity-meta">
                                    <?php echo e($movement->quantity); ?> <?php echo e(__('items')); ?> | <?php echo e(optional($movement->moved_at)->diffForHumans() ?? __('N/A')); ?>

                                </div>
                                <div class="activity-meta">
                                    <?php echo e(__('From')); ?> <?php echo e(optional($movement->fromBranch)->name ?? __('N/A')); ?>

                                    <?php echo e(__('to')); ?> <?php echo e(optional($movement->toBranch)->name ?? __('N/A')); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted"><?php echo e(__('No recent movements.')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header bg-transparent">
                        <div class="panel-title"><?php echo e(__('Recent Inspections')); ?></div>
                        <p class="text-muted mb-0"><?php echo e(__('Latest audit outcomes and flagged findings.')); ?></p>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $recentInspections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inspection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <div class="fw-semibold"><?php echo e($inspection->asset->asset_name ?? __('Unknown asset')); ?></div>
                                        <div class="activity-meta">
                                            <?php echo e(optional($inspection->inspected_at)->format('Y-m-d H:i') ?? __('N/A')); ?>

                                        </div>
                                    </div>
                                    <span class="status-chip status-<?php echo e($inspection->status); ?>">
                                        <?php echo e(ucfirst((string) $inspection->status)); ?>

                                    </span>
                                </div>
                                <?php if($inspection->findings): ?>
                                    <div class="activity-meta mt-1"><?php echo e(\Illuminate\Support\Str::limit($inspection->findings, 120)); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted"><?php echo e(__('No inspections logged.')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-transparent">
                <div class="panel-title"><?php echo e(__('Notification Settings Overview')); ?></div>
                <p class="text-muted mb-0"><?php echo e(__('Current delivery and threshold configuration for asset alerts.')); ?></p>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush settings-list">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo e(__('Methods')); ?></span>
                        <span class="fw-semibold">
                            <?php echo e(implode(', ', $settings->notification_methods ?? []) ?: __('Not configured')); ?>

                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo e(__('Low stock threshold')); ?></span>
                        <span class="fw-semibold"><?php echo e($settings->low_stock_threshold); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo e(__('Inspection reminder (days)')); ?></span>
                        <span class="fw-semibold"><?php echo e($settings->inspection_reminder_days); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo e(__('Notification time')); ?></span>
                        <span class="fw-semibold"><?php echo e($settings->notification_time ?? __('Anytime')); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\assets\dashboard.blade.php ENDPATH**/ ?>
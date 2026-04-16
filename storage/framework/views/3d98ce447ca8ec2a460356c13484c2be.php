<?php $__env->startSection('page-title', __('Asset inventory')); ?>
<?php $__env->startSection('page-breadcrumb', 'Assets,Inventory'); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?php echo e(route('assets.dashboard')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Dashboard')); ?></a>
        <a href="<?php echo e(route('assets.reports')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Reports')); ?></a>
        <a href="<?php echo e(route('assets.export', ['format' => 'excel'])); ?>" class="btn btn-outline-secondary"><?php echo e(__('Export Excel')); ?></a>
        <a href="<?php echo e(route('assets.export', ['format' => 'pdf'])); ?>" class="btn btn-outline-secondary"><?php echo e(__('Export PDF')); ?></a>
        <a href="<?php echo e(route('assets.print')); ?>" class="btn btn-outline-secondary" target="_blank"><?php echo e(__('Print')); ?></a>
        <a href="<?php echo e(route('assets.settings.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Settings')); ?></a>
        <a href="<?php echo e(route('assets.create')); ?>" class="btn btn-primary"><?php echo e(__('Add asset')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
    .asset-inventory-page .card {
        border: 1px solid var(--bs-border-color, #d8e2ef) !important;
        box-shadow: none !important;
    }

    .asset-inventory-page .section-label {
        font-size: 0.74rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 600;
        color: var(--bs-secondary-color);
    }

    .asset-inventory-page .hero-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--bs-heading-color, #1f2937);
    }

    .asset-inventory-page .metric-card .metric-value {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1.1;
        margin-top: 0.4rem;
        color: var(--bs-heading-color, #1f2937);
    }

    .asset-inventory-page .metric-card .metric-help {
        font-size: 0.8rem;
        color: var(--bs-secondary-color);
        margin-top: 0.35rem;
    }

    .asset-inventory-page .asset-table thead th {
        font-size: 0.74rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--bs-secondary-color);
        background: var(--bs-tertiary-bg);
        border-top: 0;
        border-bottom-color: var(--bs-border-color, #d8e2ef);
        white-space: nowrap;
    }

    .asset-inventory-page .asset-table tbody td {
        border-bottom-color: var(--bs-border-color, #d8e2ef);
        vertical-align: middle;
    }

    .asset-inventory-page .asset-table tbody tr:hover {
        background: rgba(13, 110, 253, 0.04);
    }

    .asset-inventory-page .asset-meta {
        color: var(--bs-secondary-color);
        font-size: 0.78rem;
        margin-top: 0.15rem;
    }

    .asset-inventory-page .stock-meter {
        min-width: 180px;
    }

    .asset-inventory-page .stock-meter .progress {
        height: 8px;
    }

    .asset-inventory-page .status-pill {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--bs-border-color, #d8e2ef);
        border-radius: 999px;
        padding: 0.2rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .asset-inventory-page .status-operational { color: #0f7a45; }
    .asset-inventory-page .status-in_maintenance { color: #8a6d1e; }
    .asset-inventory-page .status-retired { color: #6c757d; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $activeFilterCount = collect($filters)->filter(fn($value) => filled($value))->count();
    ?>

    <div class="asset-inventory-page">
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-8">
                        <div class="section-label"><?php echo e(__('Asset operations')); ?></div>
                        <div class="hero-title"><?php echo e(__('Enterprise Asset Inventory Control Center')); ?></div>
                        <p class="text-muted mb-0">
                            <?php echo e(__('Track stock levels, ownership, and lifecycle status across branches with full visibility.')); ?>

                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <span class="badge text-bg-light border px-3 py-2">
                            <?php echo e(__('Assets Listed')); ?>: <?php echo e($assets->total()); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Total items')); ?></div>
                        <div class="metric-value"><?php echo e($stats['total_items']); ?></div>
                        <div class="metric-help"><?php echo e(__('Distinct tracked assets')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Total quantity')); ?></div>
                        <div class="metric-value"><?php echo e($stats['total_quantity']); ?></div>
                        <div class="metric-help"><?php echo e(__('All units on record')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Available')); ?></div>
                        <div class="metric-value"><?php echo e($stats['available_quantity']); ?></div>
                        <div class="metric-help"><?php echo e(__('Ready for assignment')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Low stock')); ?></div>
                        <div class="metric-value text-danger"><?php echo e($stats['low_stock']); ?></div>
                        <div class="metric-help"><?php echo e(__('Threshold alerts')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Movements')); ?></div>
                        <div class="metric-value"><?php echo e($stats['movements']); ?></div>
                        <div class="metric-help"><?php echo e(__('Transfers logged')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label"><?php echo e(__('Inspections')); ?></div>
                        <div class="metric-value"><?php echo e($stats['inspections']); ?></div>
                        <div class="metric-help"><?php echo e(__('Audit records')); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-transparent">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h5 class="mb-1"><?php echo e(__('Inventory Filters')); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(__('Refine records by structure, category, and lifecycle status.')); ?></p>
                    </div>
                    <span class="badge text-bg-light border">
                        <?php echo e(__('Active filters')); ?>: <?php echo e($activeFilterCount); ?>

                    </span>
                </div>
            </div>
            <div class="card-body">
                <form method="get" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Branch')); ?></label>
                        <select name="branch_id" class="form-select">
                            <option value=""><?php echo e(__('Any branch')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e((string) $filters['branch_id'] === (string) $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Department')); ?></label>
                        <select name="department_id" class="form-select">
                            <option value=""><?php echo e(__('Any department')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e((string) $filters['department_id'] === (string) $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Category')); ?></label>
                        <select name="category" class="form-select">
                            <option value=""><?php echo e(__('All categories')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categoryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>" <?php echo e($filters['category'] === $category ? 'selected' : ''); ?>>
                                    <?php echo e($category); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Status')); ?></label>
                        <select name="status" class="form-select">
                            <option value=""><?php echo e(__('Any status')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e($filters['status'] === $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-light border"><?php echo e(__('Reset')); ?></a>
                        <button class="btn btn-primary"><?php echo e(__('Apply filters')); ?></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?php echo e(__('Inventory Register')); ?></h5>
                <small class="text-muted"><?php echo e(__('Page')); ?> <?php echo e($assets->currentPage()); ?> / <?php echo e($assets->lastPage()); ?></small>
            </div>
            <div class="table-responsive">
                <table class="table asset-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Asset')); ?></th>
                            <th><?php echo e(__('Classification')); ?></th>
                            <th><?php echo e(__('Location & Owner')); ?></th>
                            <th><?php echo e(__('Stock Health')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th class="text-end"><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $totalQty = max(1, (int) $asset->quantity);
                                $availableQty = max(0, (int) $asset->available_quantity);
                                $availability = min(100, (int) round(($availableQty / $totalQty) * 100));
                                $meterClass = $availability >= 70 ? 'success' : ($availability >= 40 ? 'warning' : 'danger');
                            ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?php echo e($asset->asset_name); ?></div>
                                    <div class="asset-meta">
                                        <?php echo e(__('Code')); ?>: <?php echo e($asset->asset_code ?? __('N/A')); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($asset->asset_tag): ?>
                                            | <?php echo e(__('Tag')); ?>: <?php echo e($asset->asset_tag); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div><?php echo e($asset->category ?? __('General')); ?></div>
                                    <div class="asset-meta">
                                        <?php echo e($asset->asset_type ?? __('Unspecified type')); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($asset->serial_number): ?>
                                            | <?php echo e(__('SN')); ?>: <?php echo e($asset->serial_number); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div><?php echo e($asset->location ?? __('Not set')); ?></div>
                                    <div class="asset-meta">
                                        <?php echo e(optional($asset->branch)->name ?? __('No branch')); ?>

                                        | <?php echo e(optional($asset->department)->name ?? __('No department')); ?>

                                    </div>
                                    <div class="asset-meta">
                                        <?php echo e(__('Assigned')); ?>: <?php echo e(optional($asset->assignedTo)->name ?? __('Unassigned')); ?>

                                    </div>
                                </td>
                                <td>
                                    <div class="stock-meter">
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span><?php echo e($availableQty); ?> / <?php echo e($totalQty); ?> <?php echo e(__('available')); ?></span>
                                            <span><?php echo e($availability); ?>%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-<?php echo e($meterClass); ?>" role="progressbar" style="width: <?php echo e($availability); ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-pill status-<?php echo e($asset->status); ?>">
                                        <?php echo e($statusOptions[$asset->status] ?? ucfirst(str_replace('_', ' ', (string) $asset->status))); ?>

                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('assets.show', $asset)); ?>" class="btn btn-sm btn-light border"><?php echo e(__('View')); ?></a>
                                    <a href="<?php echo e(route('assets.edit', $asset)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Edit')); ?></a>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset inventory delete')): ?>
                                        <form action="<?php echo e(route('assets.destroy', $asset)); ?>" method="post" class="d-inline">
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
                                <td colspan="6" class="text-center text-muted py-5">
                                    <?php echo e(__('No assets recorded yet. Start by adding your first inventory item.')); ?>

                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent">
                <?php echo e($assets->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\assets\index.blade.php ENDPATH**/ ?>
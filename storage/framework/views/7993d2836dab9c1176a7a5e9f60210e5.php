<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('System Analytics')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('System Analytics')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row gy-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small"><?php echo e(__('Requests Today')); ?></h6>
                    <div class="fs-3 fw-bold"><?php echo e(number_format($todayRequests ?? 0)); ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small"><?php echo e(__('Requests This Week')); ?></h6>
                    <div class="fs-3 fw-bold"><?php echo e(number_format($weekRequests ?? 0)); ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small"><?php echo e(__('Requests This Month')); ?></h6>
                    <div class="fs-3 fw-bold"><?php echo e(number_format($monthRequests ?? 0)); ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small"><?php echo e(__('Active Users This Month')); ?></h6>
                    <div class="fs-3 fw-bold"><?php echo e(number_format($uniqueUsersThisMonth ?? 0)); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3"><?php echo e(__('Requests Per Day (Last 30 days)')); ?></h5>
            <div class="d-flex align-items-end gap-2" style="height: 130px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $dailyUsage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex-fill text-center">
                        <div class="bg-primary rounded" style="height: <?php echo e($dailyUsage ? ($count / max(1, max($dailyUsage))) * 100 : 2); ?>%; min-height: 10px;"></div>
                        <small class="text-muted d-block mt-2" style="font-size:.65rem;"><?php echo e(\Illuminate\Support\Str::substr($day, 5)); ?></small>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3"><?php echo e(__('Top Routes')); ?></h5>
                    <div class="list-group list-group-flush">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong><?php echo e($route->route ?? __('(unnamed)')); ?></strong>
                                    <div class="small text-muted"><?php echo e(__('Hits: :count', ['count' => $route->hits])); ?></div>
                                </div>
                                <span class="badge bg-soft-primary text-primary"><?php echo e(number_format($route->hits)); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3"><?php echo e(__('Slowest Routes')); ?></h5>
                    <div class="list-group list-group-flush">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $slowRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong><?php echo e($route->route ?? __('(unnamed)')); ?></strong>
                                </div>
                                <span class="badge bg-soft-danger text-danger"><?php echo e(number_format($route->avg_time ?? 0, 2)); ?>s</span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-0"><?php echo e(__('Top Browsers')); ?></h5>
                    <small class="text-muted"><?php echo e(__('From recent requests')); ?></small>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0">
                            <thead class="text-muted small">
                                <tr>
                                    <th><?php echo e(__('Browser')); ?></th>
                                    <th><?php echo e(__('Usage')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $browserStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($label); ?></td>
                                        <td><?php echo e($count); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted"><?php echo e(__('No browser data yet.')); ?></td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-0"><?php echo e(__('Device Usage')); ?></h5>
                    <small class="text-muted"><?php echo e(__('Device breakdown from agent strings')); ?></small>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0">
                            <thead class="text-muted small">
                                <tr>
                                    <th><?php echo e(__('Device')); ?></th>
                                    <th><?php echo e(__('Usage')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $deviceStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($label); ?></td>
                                        <td><?php echo e($count); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted"><?php echo e(__('No device data yet.')); ?></td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(__('Function Tracking')); ?></h5>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm mb-0">
                            <thead class="text-muted small">
                                <tr>
                                    <th><?php echo e(__('Function')); ?></th>
                                    <th><?php echo e(__('Calls')); ?></th>
                                    <th><?php echo e(__('Avg Time')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $functionStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $func): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($func->name); ?></td>
                                        <td><?php echo e($func->calls); ?></td>
                                        <td><?php echo e(number_format($func->avg_time ?? 0, 3)); ?>s</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(__('Latest Errors')); ?></h5>
                    <ul class="list-group list-group-flush">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $latestErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong><?php echo e($error->route ?? __('Unknown route')); ?></strong>
                                        <div class="small text-muted"><?php echo e($error->message); ?></div>
                                    </div>
                                    <span class="small text-muted"><?php echo e($error->created_at->diffForHumans()); ?></span>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(__('Workspace Activity')); ?></h5>
                    <ul class="list-group list-group-flush">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $workspaceStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><?php echo e($workspaceNames[$workspace->workspace_id] ?? __('Workspace :id', ['id' => $workspace->workspace_id])); ?></span>
                                <strong><?php echo e(number_format($workspace->total_requests)); ?></strong>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(__('Active Users')); ?></h5>
                    <ul class="list-group list-group-flush">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $activeUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><?php echo e($userNames[$user->user_id] ?? __('User :id', ['id' => $user->user_id])); ?></span>
                                <strong><?php echo e(number_format($user->requests)); ?></strong>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-end">
            <a href="<?php echo e(route('superadmin.system.analytics.map')); ?>" class="btn btn-outline-primary">
                <?php echo e(__('View User Location Map')); ?>

            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\superadmin\system_analytics.blade.php ENDPATH**/ ?>
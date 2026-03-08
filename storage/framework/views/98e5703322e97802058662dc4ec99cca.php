

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Troubleshoot')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Troubleshoot')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2">
        <form action="<?php echo e(route('superadmin.troubleshoot.storage-link')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                title="<?php echo e(__('Create public/storage symlink')); ?>">
                <i class="ti ti-link"></i> <?php echo e(__('Create/Repair Storage Symlink')); ?>

            </button>
        </form>

        <form action="<?php echo e(route('superadmin.troubleshoot.cache-clear')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                title="<?php echo e(__('Run cache:clear, config:clear, route:clear, view:clear, optimize:clear')); ?>">
                <i class="ti ti-broom"></i> <?php echo e(__('Clear All Caches')); ?>

            </button>
        </form>

        <form action="<?php echo e(route('superadmin.troubleshoot.cache-build')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip"
                title="<?php echo e(__('Run config:cache, route:cache, view:cache')); ?>">
                <i class="ti ti-rocket"></i> <?php echo e(__('Rebuild Caches')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Seeder Helpers')); ?></h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small"><?php echo e(__('Re-run seeders to restore menu entries, permissions, or the full data bundle when troubleshooting access issues.')); ?></p>
                    <div class="d-flex flex-wrap gap-2">
                        <form action="<?php echo e(route('superadmin.troubleshoot.run-seeders')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="preset" value="menu">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="ti ti-sparkles"></i> <?php echo e(__('Seed Menu + Defaults')); ?>

                            </button>
                        </form>
                        <form action="<?php echo e(route('superadmin.troubleshoot.run-seeders')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="preset" value="permissions">
                            <button type="submit" class="btn btn-outline-success">
                                <i class="ti ti-key"></i> <?php echo e(__('Seed Permissions')); ?>

                            </button>
                        </form>
                        <form action="<?php echo e(route('superadmin.troubleshoot.run-seeders')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="preset" value="full">
                            <button type="submit" class="btn btn-outline-warning">
                                <i class="ti ti-database"></i> <?php echo e(__('Run Full Database Seeder')); ?>

                            </button>
                        </form>
                    </div>
                    <hr/>
                    <div class="alert alert-warning mb-3">
                        <strong><?php echo e(__('Danger:')); ?></strong>
                        <?php echo e(__('This will drop all tables, re-run every migration (including package migrations), and seed all package seeders.')); ?>

                    </div>
                    <form action="<?php echo e(route('superadmin.troubleshoot.migrate-fresh')); ?>" method="POST"
                        onsubmit="return confirm('<?php echo e(__('This will DROP ALL TABLES and re-run all migrations + seeders (including packages). Continue?')); ?>');">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-alert-triangle"></i> <?php echo e(__('Migrate Fresh + Seed All Packages')); ?>

                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><?php echo e(__('Image & Upload Troubleshoot')); ?></h5>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success mb-3"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger mb-3"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold"><?php echo e(__('Public storage link')); ?></div>
                                <div class="text-muted small"><?php echo e($publicStorage); ?></div>
                            </div>
                            <?php if($linkExists): ?>
                                <span class="badge bg-success"><?php echo e(__('Exists')); ?></span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark"><?php echo e(__('Missing')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold"><?php echo e(__('Storage public path')); ?></div>
                                <div class="text-muted small"><?php echo e($storagePublic); ?></div>
                            </div>
                            <?php if($targetExists): ?>
                                <span class="badge bg-success"><?php echo e(__('Exists')); ?></span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark"><?php echo e(__('Missing')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <p class="text-muted mb-2"><?php echo e(__('If images are not visible, create or repair the symbolic link to public/storage. You can also clear and rebuild Laravel caches so new code and views take effect.')); ?></p>
                    <form action="<?php echo e(route('superadmin.troubleshoot.storage-link')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-link"></i> <?php echo e(__('Create/Repair Storage Symlink')); ?>

                        </button>
                    </form>

                    <hr/>
                    <div class="d-flex gap-2">
                        <form action="<?php echo e(route('superadmin.troubleshoot.cache-clear')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning">
                                <i class="ti ti-broom"></i> <?php echo e(__('Clear All Caches')); ?>

                            </button>
                        </form>
                        <form action="<?php echo e(route('superadmin.troubleshoot.cache-build')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-rocket"></i> <?php echo e(__('Rebuild Caches')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Diagnostics')); ?></h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo e(__('.env file present')); ?></span>
                            <span class="badge <?php echo e($envExists ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($envExists ? __('Yes') : __('No')); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo e(__('APP_KEY set')); ?></span>
                            <span class="badge <?php echo e($appKeySet ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($appKeySet ? __('Yes') : __('No')); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo e(__('storage/ writable')); ?></span>
                            <span class="badge <?php echo e($writableStorage ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($writableStorage ? __('Yes') : __('No')); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo e(__('bootstrap/cache writable')); ?></span>
                            <span class="badge <?php echo e($writableBootstrap ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($writableBootstrap ? __('Yes') : __('No')); ?></span>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted"><?php echo e(__('Cache driver')); ?></div>
                            <div class="fw-semibold"><?php echo e($cacheDriver); ?></div>
                            <div>
                                <span class="badge <?php echo e($cacheOk ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($cacheOk ? __('Write OK') : __('Write failed')); ?></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted"><?php echo e(__('Queue connection')); ?></div>
                            <div class="fw-semibold"><?php echo e($queueConnection); ?></div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted"><?php echo e(__('Session driver')); ?></div>
                            <div class="fw-semibold"><?php echo e($sessionDriver); ?></div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted"><?php echo e(__('Database connectivity')); ?></div>
                            <div>
                                <?php if($dbOk): ?>
                                    <span class="badge bg-success"><?php echo e(__('OK')); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><?php echo e(__('Failed')); ?></span>
                                    <div class="text-muted small mt-1"><?php echo e(Str::limit($dbError, 120)); ?></div>
                                <?php endif; ?>
                            </div>
                        </li>
                    </ul>

                    <div class="mt-3 d-flex gap-2">
                        <form action="<?php echo e(route('superadmin.troubleshoot.permissions-fix')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="ti ti-shield-check"></i> <?php echo e(__('Verify/Set Permissions')); ?>

                            </button>
                        </form>
                        <form action="<?php echo e(route('superadmin.troubleshoot.logs-clear')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="ti ti-trash"></i> <?php echo e(__('Clear Log')); ?>

                            </button>
                        </form>
                    </div>

                    <?php if(!empty($logTail)): ?>
                        <hr/>
                        <div class="small text-muted mb-1"><?php echo e(__('Last 100 log lines')); ?></div>
                        <pre class="small" style="max-height:240px;overflow:auto;background:#0f172a;color:#e5e7eb;padding:.75rem;border-radius:.5rem;"><?php echo e($logTail); ?></pre>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/superadmin/troubleshoot/index.blade.php ENDPATH**/ ?>
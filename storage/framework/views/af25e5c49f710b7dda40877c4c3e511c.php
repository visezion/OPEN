<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('CI/CD Pipeline')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('CI/CD Pipeline')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <style>
        .cicd-page .card {
            border: 1px solid #d8e2ef;
            border-radius: 14px;
            box-shadow: none !important;
            background: #ffffff;
        }

        .cicd-page .card-header {
            border-bottom: 1px solid #d8e2ef;
            background: #ffffff;
            padding: 14px 18px;
        }

        .cicd-page .card-body {
            padding: 18px;
        }

        .cicd-page .cicd-top-actions {
            flex-wrap: wrap;
        }

        .cicd-page .table-responsive {
            border: 1px solid #d8e2ef;
            border-radius: 12px;
            background: #ffffff;
        }

        .cicd-page .table {
            margin-bottom: 0;
        }

        .cicd-page .table > thead > tr > th {
            background: #f8fbff;
            border-bottom: 1px solid #d8e2ef !important;
            color: #5f7696;
            font-size: 12px;
            letter-spacing: .04em;
            text-transform: uppercase;
            font-weight: 700;
            white-space: nowrap;
        }

        .cicd-page .table > tbody > tr > td {
            border-bottom: 1px solid #e7edf6 !important;
            color: #1f3a62;
            vertical-align: middle;
        }

        .cicd-page .table > tbody > tr:last-child > td {
            border-bottom: 0 !important;
        }

        .cicd-page .repo-meta {
            border: 1px solid #e3ebf7;
            border-radius: 10px;
            background: #fbfdff;
            padding: 12px 14px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex align-items-center gap-2 cicd-top-actions">
        <a class="btn btn-sm btn-light" href="https://github.com/<?php echo e($owner); ?>/<?php echo e($repo); ?>/actions" target="_blank">
            <i class="ti ti-external-link"></i> <?php echo e(__('Open GitHub Actions')); ?>

        </a>
        <form action="<?php echo e(route('superadmin.cicd.dispatch')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-primary" <?php if(!$tokenPresent): ?> disabled <?php endif; ?>
                data-bs-toggle="tooltip" title="<?php echo e($tokenPresent ? __('Dispatch workflow on main') : __('Set GITHUB_TOKEN in .env')); ?>">
                <i class="ti ti-player-play"></i> <?php echo e(__('Run Deploy')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row cicd-page g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><?php echo e(__('Recent Workflow Runs')); ?></h5>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success mb-3"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger mb-3"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <?php if($error): ?>
                        <div class="alert alert-warning"><?php echo e($error); ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Conclusion')); ?></th>
                                    <th><?php echo e(__('Branch')); ?></th>
                                    <th><?php echo e(__('When')); ?></th>
                                    <th><?php echo e(__('Actor')); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $runs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-wrap"><?php echo e($run['name'] ?? ($run['display_title'] ?? 'workflow')); ?></td>
                                        <td>
                                            <?php $st = $run['status'] ?? 'unknown'; ?>
                                            <span class="badge <?php switch($st): case ('queued'): ?> bg-secondary <?php break; ?> <?php case ('in_progress'): ?> bg-info <?php break; ?> <?php case ('completed'): ?> bg-success <?php break; ?> <?php default: ?> bg-light text-dark <?php endswitch; ?>"><?php echo e($st); ?></span>
                                        </td>
                                        <td>
                                            <?php $cc = $run['conclusion'] ?? ''; ?>
                                            <?php if($cc): ?>
                                                <span class="badge <?php switch($cc): case ('success'): ?> bg-success <?php break; ?> <?php case ('failure'): ?> bg-danger <?php break; ?> <?php case ('cancelled'): ?> bg-secondary <?php break; ?> <?php default: ?> bg-light text-dark <?php endswitch; ?>"><?php echo e($cc); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-dark"><?php echo e($run['head_branch'] ?? ''); ?></span></td>
                                        <td class="small text-muted"><?php echo e(\Illuminate\Support\Carbon::parse($run['created_at'] ?? now())->diffForHumans()); ?></td>
                                        <td class="small"><?php echo e($run['actor']['login'] ?? ''); ?></td>
                                        <td>
                                            <?php if(!empty($run['html_url'])): ?>
                                                <a class="btn btn-sm btn-outline-secondary" href="<?php echo e($run['html_url']); ?>" target="_blank"><?php echo e(__('View')); ?></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted"><?php echo e(__('No runs found')); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Repository')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="repo-meta">
                        <div class="mb-2"><strong><?php echo e($owner); ?>/<?php echo e($repo); ?></strong></div>
                        <div class="small text-muted"><?php echo e(__('Workflow')); ?>: <?php echo e($workflow); ?></div>
                        <div class="small text-muted"><?php echo e(__('Token set')); ?>: <span class="badge <?php echo e($tokenPresent ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($tokenPresent ? __('Yes') : __('No')); ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\superadmin\cicd\index.blade.php ENDPATH**/ ?>
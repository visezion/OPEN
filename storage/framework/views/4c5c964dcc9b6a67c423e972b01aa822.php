<?php $__env->startSection('page-title', __('Reports Management')); ?>
<?php $__env->startSection('page-breadcrumb', __('Reports Dashboard')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('feedback.dashboard')); ?>" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="<?php echo e(__('Reports Dashboard')); ?>">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
    <a href="<?php echo e(route('feedback.create')); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-plus me-1"></i><?php echo e(__('New Report')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body table-responsive">
            <form method="GET" action="<?php echo e(route('feedback.index')); ?>" class="row mb-3 g-2 align-items-end">
                <div class="col-md-2 d-flex align-items-center">
                    <label class="form-label me-2 mb-0" for="per_page"><?php echo e(__('Pages:')); ?></label>
                    <select name="per_page" id="per_page" class="form-control form-control-sm w-auto me-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [10, 15, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($size); ?>" <?php echo e(request('per_page', 15) == $size ? 'selected' : ''); ?>><?php echo e($size); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <span class="form-label mb-0"><?php echo e(__('entries')); ?></span>
                </div>

                <div class="col-md-2">
                    <select name="type" class="form-control form-control-sm">
                        <option value=""><?php echo e(__('All Types')); ?></option>
                        <option value="internal" <?php echo e(request('type') == 'internal' ? 'selected' : ''); ?>><?php echo e(__('Internal')); ?></option>
                        <option value="public" <?php echo e(request('type') == 'public' ? 'selected' : ''); ?>><?php echo e(__('Public')); ?></option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-control form-control-sm">
                        <option value=""><?php echo e(__('All Statuses')); ?></option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                        <option value="reviewed" <?php echo e(request('status') == 'reviewed' ? 'selected' : ''); ?>><?php echo e(__('Reviewed')); ?></option>
                        <option value="resolved" <?php echo e(request('status') == 'resolved' ? 'selected' : ''); ?>><?php echo e(__('Resolved')); ?></option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="<?php echo e(__('Search title or summary')); ?>" value="<?php echo e(request('search')); ?>">
                </div>

                <div class="col-md-1">
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="ti ti-filter"></i>
                    </button>
                </div>
            </form>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th><?php echo e(__('Department')); ?></th>
                        <th><?php echo e(__('Week Ending')); ?></th>
                        <th><?php echo e(__('Report')); ?></th>
                        <th><?php echo e(__('Attendance')); ?></th>
                        <th><?php echo e(__('Submitted By')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($item->department->name ?? __('No Department')); ?></td>
                            <td><?php echo e($item->week_ending_formatted); ?></td>
                            <td>
                                <div class="fw-semibold"><?php echo e($item->title ?? __('Untitled Report')); ?></div>
                                <div class="small text-muted"><?php echo e(\Illuminate\Support\Str::limit(strip_tags($item->message ?? ''), 80)); ?></div>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->attendance_rate !== null): ?>
                                    <span class="badge bg-light text-dark"><?php echo e($item->attendance_rate); ?>%</span>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(__('Not linked')); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td><?php echo e($item->is_anonymous ? __('Anonymous') : ($item->name ?? 'N/A')); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($item->status == 'pending' ? 'warning' : ($item->status == 'reviewed' ? 'primary' : 'success')); ?>">
                                    <?php echo e(ucfirst($item->status)); ?>

                                </span>
                            </td>
                            <td>
                                <?php if (app('laratrust')->hasPermission('feedback review')) : ?>
                                    <a href="<?php echo e(route('feedback.review', Crypt::encrypt($item->id))); ?>" class="btn btn-sm btn-outline-primary" title="<?php echo e(__('Review')); ?>"><i class="ti ti-file"></i></a>
                                <?php endif; // app('laratrust')->permission ?>
                                <a href="<?php echo e(route('feedback.show', Crypt::encrypt($item->id))); ?>" class="btn btn-sm btn-outline-info" title="<?php echo e(__('View')); ?>"><i class="ti ti-eye"></i></a>
                                <?php if (app('laratrust')->hasPermission('feedback edit')) : ?>
                                    <a href="<?php echo e(route('feedback.edit', Crypt::encrypt($item->id))); ?>" class="btn btn-sm btn-outline-primary" title="<?php echo e(__('Edit')); ?>"><i class="ti ti-edit"></i></a>
                                <?php endif; // app('laratrust')->permission ?>
                                <?php if (app('laratrust')->hasPermission('feedback delete')) : ?>
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['feedback.destroy', Crypt::encrypt($item->id)], 'class' => 'd-inline']); ?>

                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="<?php echo e(__('Delete')); ?>">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    <?php echo Form::close(); ?>

                                <?php endif; // app('laratrust')->permission ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4"><?php echo e(__('No reports found.')); ?></td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feedbacks->hasPages()): ?>
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap small text-muted">
                    <div class="mb-2 mb-md-0">
                        <?php echo e(__('Showing')); ?> <strong><?php echo e($feedbacks->firstItem()); ?></strong> <?php echo e(__('to')); ?> <strong><?php echo e($feedbacks->lastItem()); ?></strong> <?php echo e(__('of')); ?> <strong><?php echo e($feedbacks->total()); ?></strong> <?php echo e(__('results')); ?>

                    </div>
                    <div><?php echo e($feedbacks->links('pagination::bootstrap-5')); ?></div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\index.blade.php ENDPATH**/ ?>
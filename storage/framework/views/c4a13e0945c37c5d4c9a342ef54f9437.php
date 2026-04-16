

<?php $__env->startSection('page-title', __('Discipleship Approvals')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="p-4 bg-white shadow rounded-3">
        <h5 class="fw-bold mb-3">
            <i class="ti ti-checks text-success"></i> <?php echo e(__('Requested Approvals')); ?>

        </h5>

        <p class="small text-muted">
            <?php echo e(__('Below are the discipleship requirements submitted by members that need review. Pastors or admins can approve or reject each request.')); ?>

        </p>

        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th><?php echo e(__('Member')); ?></th>
                    <th><?php echo e(__('Stage')); ?></th>
                    <th><?php echo e(__('Requirement')); ?></th>
                    <th><?php echo e(__('Evidence')); ?></th>
                    <th><?php echo e(__('Submitted At')); ?></th>
                    <th><?php echo e(__('Status')); ?></th>
                    <th class="text-center"><?php echo e(__('Action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pendingProgress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $progress): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($progress->member->name); ?></td>
                        <td><?php echo e($progress->stage->name); ?></td>
                        <td><?php echo e($progress->requirement->title); ?></td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($progress->evidence): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Str::startsWith($progress->evidence, 'discipleship/evidence')): ?>
                                    <a href="<?php echo e(asset('storage/'.$progress->evidence)); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="ti ti-file"></i> <?php echo e(__('View File')); ?>

                                    </a>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e($progress->evidence); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td><?php echo e($progress->created_at->format('M d, Y H:i')); ?></td>
                        <td>
                            <span class="badge bg-warning text-dark"><?php echo e(ucfirst($progress->status)); ?></span>
                        </td>
                        <td class="text-center">
                            <form method="POST" action="<?php echo e(route('discipleship.requirement.review', $progress->id)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="approve">
                                <button class="btn btn-success btn-sm">
                                    <i class="ti ti-check"></i> <?php echo e(__('Approve')); ?>

                                </button>
                            </form>
                            <form method="POST" action="<?php echo e(route('discipleship.requirement.review', $progress->id)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="reject">
                                <button class="btn btn-danger btn-sm">
                                    <i class="ti ti-x"></i> <?php echo e(__('Reject')); ?>

                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            <i class="ti ti-inbox"></i> <?php echo e(__('No pending approval requests at the moment.')); ?>

                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\requirements\approval.blade.php ENDPATH**/ ?>
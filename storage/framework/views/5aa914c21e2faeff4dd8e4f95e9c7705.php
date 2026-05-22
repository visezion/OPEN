<?php $__env->startSection('page-title', __('Smart Tags')); ?>
<?php $__env->startSection('page-breadcrumb', __('Smart Tags Automation')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchly.smart-tags.create')); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i> <?php echo e(__('Create Tag')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th><?php echo e(__('Name')); ?></th>
                    <th><?php echo e(__('Status')); ?></th>
                    <th><?php echo e(__('Members matched')); ?></th>
                    <th><?php echo e(__('Last run')); ?></th>
                    <th class="text-end"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $smartTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <strong><?php echo e($tag->name); ?></strong>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tag->description): ?>
                                <div class="small text-muted"><?php echo e($tag->description); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?php echo e($tag->is_active ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($tag->is_active ? __('Active') : __('Disabled')); ?></span>
                        </td>
                        <td><?php echo e($tag->members_count); ?></td>
                        <td class="small text-muted"><?php echo e($tag->last_run_at ? $tag->last_run_at->diffForHumans() : __('Never')); ?></td>
                        <td class="text-end">
                            <form method="POST" action="<?php echo e(route('churchly.smart-tags.run', $tag->id)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-sm btn-outline-primary" type="submit">
                                    <i class="ti ti-refresh"></i> <?php echo e(__('Run')); ?>

                                </button>
                            </form>
                            <a href="<?php echo e(route('churchly.smart-tags.edit', $tag->id)); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?>

                            </a>
                            <form method="POST" action="<?php echo e(route('churchly.smart-tags.destroy', $tag->id)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('<?php echo e(__('Delete this tag?')); ?>')" type="submit">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted"><?php echo e(__('No smart tags defined yet.')); ?></td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <?php echo e($smartTags->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\smart-tags\index.blade.php ENDPATH**/ ?>
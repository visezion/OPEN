

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Group Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('WA Groups')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('wa_group.index')); ?>" class="btn btn-sm btn-danger">
        <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    <div class="col-sm-2">
        <?php echo $__env->make('churchly::layouts.churchly_setup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <div class="col-sm-6">
        
        <div class="card p-4 mb-4">
            <h4 class="mb-2"><i class="ti ti-brand-whatsapp text-success"></i> <?php echo e($group->name); ?></h4>
            <p class="text-muted mb-2">
                <strong><?php echo e(__('Group ID:')); ?></strong> <?php echo e($group->group_id); ?>

            </p>
            <p class="small text-muted">
                <?php echo e(__('This is the unique identifier synced from Zender. It is required for sending automated WhatsApp messages to this group.')); ?>

            </p>

            
            <h6 class="mt-4"><?php echo e(__('Assigned Branches')); ?></h6>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($group->branches->count()): ?>
                <ul class="list-unstyled ps-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $group->branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><i class="ti ti-building text-primary"></i> <?php echo e($branch->name); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted small"><?php echo e(__('No branches have been linked to this group.')); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <h6 class="mt-4"><?php echo e(__('Assigned Departments')); ?></h6>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($group->departments->count()): ?>
                <ul class="list-unstyled ps-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $group->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><i class="ti ti-users text-info"></i> <?php echo e($dept->name); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted small"><?php echo e(__('No departments have been linked to this group.')); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <h6 class="mt-4"><?php echo e(__('Assigned Designations')); ?></h6>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($group->designations->count()): ?>
                <ul class="list-unstyled ps-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $group->designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $des): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><i class="ti ti-id-badge text-warning"></i> <?php echo e($des->name); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted small"><?php echo e(__('No designations have been linked to this group.')); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="col-md-4">
        
        <div class="card p-4">
            <h6 class="mb-3"><i class="ti ti-info-circle text-primary"></i> <?php echo e(__('How WhatsApp Groups Work')); ?></h6>
            <p class="text-muted small mb-3">
                <?php echo e(__('WhatsApp groups allow you to organize communication inside your church system. They are synced from Zender and can be assigned to branches, departments, and designations.')); ?>

            </p>

            <ul class="small text-muted ps-3 mb-3">
                <li><strong><?php echo e(__('Branch Assignment')); ?>:</strong> <?php echo e(__('Link a group to an entire branch (e.g., Main Branch, City Branch). All members of that branch can be reached.')); ?></li>
                <li><strong><?php echo e(__('Department Assignment')); ?>:</strong> <?php echo e(__('Narrow the group to specific departments such as Choir, Ushering, or Youth Ministry.')); ?></li>
                <li><strong><?php echo e(__('Designation Assignment')); ?>:</strong> <?php echo e(__('Target roles within departments, such as Head Usher or Choir Leader.')); ?></li>
            </ul>

            <p class="small text-muted mb-3">
                <?php echo e(__('💡 If you assign a group without selecting a branch, department, or designation, it becomes a global group visible across the entire workspace.')); ?>

            </p>

            <hr>

            <h6 class="mb-2"><?php echo e(__('Best Practices')); ?></h6>
            <ul class="small text-muted ps-3">
                <li><?php echo e(__('Keep group names clear (e.g., "Choir Leaders - Main Branch").')); ?></li>
                <li><?php echo e(__('Avoid assigning the same group to too many entities to prevent confusion.')); ?></li>
                <li><?php echo e(__('Always test group assignment by sending a test WhatsApp message.')); ?></li>
            </ul>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\wa_group\show.blade.php ENDPATH**/ ?>
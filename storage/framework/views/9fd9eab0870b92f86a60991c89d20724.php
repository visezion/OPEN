


<?php $__env->startSection('page-title', __('Discipleship Stage Details')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    

    
    <div class="col-sm-9">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="mb-2"><i class="ti ti-flag text-primary"></i> <?php echo e($stage->name); ?></h5>
                <p class="text-muted small"><?php echo e($stage->description); ?></p>
                <span class="badge bg-secondary"><?php echo e(__('Order:')); ?> <?php echo e($stage->order); ?></span>
            </div>
        </div>

        
        <?php if($stage->requirements->count()): ?>
            <?php $__currentLoopData = $stage->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1"><?php echo e($req->title); ?> <span class="text-muted">(<?php echo e(ucfirst($req->type)); ?>)</span></h6>
                        <p class="text-muted small mb-2"><?php echo e($req->description); ?></p>

                        
                        <div class="mb-2">
                            <?php if($req->is_mandatory): ?>
                                <span class="badge bg-danger"><?php echo e(__('Mandatory')); ?></span>
                            <?php endif; ?>
                            <?php if($req->requires_approval): ?>
                                <span class="badge bg-warning text-dark"><?php echo e(__('Requires Approval')); ?></span>
                            <?php endif; ?>
                            <?php if($req->points): ?>
                                <span class="badge bg-success"><?php echo e($req->points); ?> <?php echo e(__('Points')); ?></span>
                            <?php endif; ?>
                        </div>

                        
                        <?php if($req->checklists && $req->checklists->count()): ?>
                            <ul class="list-group small">
                                <?php $__currentLoopData = $req->checklists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo e($item->item); ?>

                                        <span class="badge <?php echo e($item->is_completed ? 'bg-success' : 'bg-secondary'); ?>">
                                            <?php echo e($item->is_completed ? __('Done') : __('Pending')); ?>

                                        </span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted small"><?php echo e(__('No checklist items for this requirement.')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="alert alert-secondary">
                <?php echo e(__('No requirements defined for this stage yet.')); ?>

            </div>
        <?php endif; ?>

        
        <a href="<?php echo e(route('discipleship.index')); ?>" class="btn btn-outline-secondary mt-2">
            <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to Pathways')); ?>

        </a>
    </div>

    
    <div class="col-sm-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> <?php echo e(__('Stage Overview')); ?></h6>
                <p class="small text-muted">
                    <?php echo e(__('A discipleship stage represents a key milestone in spiritual growth. Each requirement under the stage must be completed before members can move forward.')); ?>

                </p>

                <ul class="small text-muted ps-3">
                    <li>✅ Review all requirements & checklists.</li>
                    <li>👥 Track member progress per requirement.</li>
                    <li>📝 Update or add new requirements via the Edit page.</li>
                </ul>

                <div class="alert alert-info small mt-3">
                    <i class="ti ti-lightbulb"></i> <b>Tip:</b> Use <code>Points</code> to motivate members and <code>Approval</code> for mentor validation.
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\stage.blade.php ENDPATH**/ ?>
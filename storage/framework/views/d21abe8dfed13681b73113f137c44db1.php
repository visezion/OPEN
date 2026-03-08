<div class="p-4 bg-white shadow rounded-3 h-100">
    <h5 class="fw-bold mb-3">
        <i class="ti ti-list-details text-primary"></i> <?php echo e(__('Stage Requirements')); ?>

    </h5>

    <ul class="list-group list-group-flush small">
        <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item">
                <b><?php echo e($stage->order); ?>. <?php echo e($stage->name); ?></b>
                <ul class="text-muted small ps-3 mb-1">
                    <?php $__empty_1 = true; $__currentLoopData = $stage->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <?php echo e($req->title); ?>

                                <span class="badge bg-light text-dark"><?php echo e(ucfirst($req->type)); ?></span>
                                <?php if($req->is_mandatory): ?> <span class="badge bg-danger">Mandatory</span><?php endif; ?>
                                <?php if($req->requires_approval): ?> <span class="badge bg-warning text-dark">Needs Approval</span><?php endif; ?>
                                <?php if($req->points): ?> <span class="badge bg-success"><?php echo e($req->points); ?> pts</span><?php endif; ?>
                            </div>

                            <div>
                                <?php
                                    $progress = $member->progress->where('requirement_id',$req->id)->first();
                                ?>

                                <?php if(!$progress): ?>
                                    <?php echo $__env->make('churchly::discipleship.requirements.form', ['req' => $req], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php else: ?>
                                    <span class="badge bg-<?php echo e($progress->status === 'approved' ? 'success' : 
                                        ($progress->status === 'rejected' ? 'danger' : 
                                        ($progress->status === 'in_review' ? 'warning text-dark' : 'secondary'))); ?>">
                                        <?php echo e(ucfirst($progress->status)); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li><i class="text-muted">No requirements yet.</i></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\requirements\list.blade.php ENDPATH**/ ?>
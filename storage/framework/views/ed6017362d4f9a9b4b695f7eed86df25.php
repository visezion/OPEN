

<?php $__env->startSection('page-title', __('Discipleship Progress Tracking')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    

    
    <div class="col-sm-9">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-users text-primary"></i> <?php echo e(__('Member Progress')); ?></h5>
                <p class="text-muted small mb-3">
                    <?php echo e(__('Track each member’s discipleship journey by stage and requirement.')); ?>

                </p>

                
                <form method="GET" class="row mb-3">
                    <div class="col-md-4">
                        <select name="stage_id" class="form-control">
                            <option value=""><?php echo e(__('-- Stage --')); ?></option>
                            <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($stage->id); ?>" <?php echo e(request('stage_id')==$stage->id?'selected':''); ?>>
                                    <?php echo e($stage->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="member_id" class="form-control">
                            <option value=""><?php echo e(__('-- Member --')); ?></option>
                            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($member->id); ?>" <?php echo e(request('member_id')==$member->id?'selected':''); ?>>
                                    <?php echo e($member->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value=""><?php echo e(__('-- Status --')); ?></option>
                            <option value="pending" <?php echo e(request('status')=='pending'?'selected':''); ?>>Pending</option>
                            <option value="in_progress" <?php echo e(request('status')=='in_progress'?'selected':''); ?>>In Progress</option>
                            <option value="completed" <?php echo e(request('status')=='completed'?'selected':''); ?>>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-sm btn-primary"><i class="ti ti-filter"></i> <?php echo e(__('Filter')); ?></button>
                        <a href="<?php echo e(route('discipleship.progress')); ?>" class="btn btn-sm btn-secondary"><?php echo e(__('Reset')); ?></a>
                    </div>
                </form>

                
                <?php if($progress->count()): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th><?php echo e(__('Member')); ?></th>
                                    <th><?php echo e(__('Stage')); ?></th>
                                    <th><?php echo e(__('Requirement')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Completed At')); ?></th>
                                    <th><?php echo e(__('Reviewed By')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $progress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($p->member->name ?? '-'); ?></td>
                                        <td><?php echo e($p->stage->name ?? '-'); ?></td>
                                        <td><?php echo e($p->requirement->title ?? '-'); ?></td>
                                        <td>
                                            <span class="badge <?php echo e($p->status=='completed'?'bg-success':($p->status=='in_progress'?'bg-warning text-dark':'bg-secondary')); ?>">
                                                <?php echo e(ucfirst($p->status)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($p->completed_at ? $p->completed_at->format('d M Y') : '-'); ?></td>
                                        <td><?php echo e($p->reviewedBy->name ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted"><?php echo e(__('No progress records found.')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-sm-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> <?php echo e(__('Progress Tracking Help')); ?></h6>
                <p class="small text-muted">
                    <?php echo e(__('Use this page to monitor member discipleship progress. You can filter by stage, member, or status.')); ?>

                </p>
                <ul class="small text-muted ps-3">
                    <li>👥 See which stage each member is in</li>
                    <li>✅ Track requirement completion</li>
                    <li>📝 Check approvals by mentors</li>
                </ul>
                <div class="alert alert-info small mt-3">
                    <i class="ti ti-lightbulb"></i> <b>Tip:</b> Export progress for quarterly discipleship reports.
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\progress.blade.php ENDPATH**/ ?>
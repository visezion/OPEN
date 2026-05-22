
<?php
    $company_settings = getCompanyAllSetting();
?>

<?php $__env->startSection('page-title', __('My Discipleship Journey')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    

    
    <div class="col-sm-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">
                    <i class="ti ti-road text-primary"></i> <?php echo e(__('My Discipleship Journey')); ?>

                </h5>
                <p class="text-muted small">
                    <?php echo e(__('Track your spiritual growth, complete requirements, and move through each stage of discipleship.')); ?>

                </p>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $stageProgress   = $member->progress->where('stage_id', $stage->id);
                        $completedCount  = $stageProgress->where('status','completed')->count();
                        $totalCount      = $stage->requirements->count();
                        $percentage      = $totalCount > 0 ? round(($completedCount/$totalCount)*100) : 0;

                        $prevStage       = $stages->where('order', $stage->order - 1)->first();
                        $prevCompleted   = !$prevStage || $member->progress->where('stage_id', $prevStage->id)->where('status', 'completed')->count() == $prevStage->requirements->count();
                        $currentCompleted= $member->progress->where('stage_id', $stage->id)->where('status', 'completed')->count() == $stage->requirements->count();
                    ?>

                    <div class="card mb-4 border">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h6 class="mb-0 fw-bold">
                                <?php echo e($stage->order); ?>. <?php echo e($stage->name); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentCompleted): ?>
                                    <span class="badge bg-primary">Completed</span>
                                <?php elseif(!$prevCompleted): ?>
                                    <span class="badge bg-secondary">🔒 Locked</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </h6>
                            <span class="badge bg-info"><?php echo e($percentage); ?>% <?php echo e(__('Completed')); ?></span>
                        </div>

                        <div class="card-body">
                            <p class="text-muted small"><?php echo e($stage->description); ?></p>

                            
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar bg-primary" style="width: <?php echo e($percentage); ?>%;"></div>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$prevCompleted): ?>
                                <p class="text-muted"><i class="ti ti-lock"></i> <?php echo e(__('Complete the previous stage to unlock this one.')); ?></p>
                            <?php elseif($currentCompleted): ?>
                                <ul>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stage->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($req->title); ?> <span class="badge bg-success">Completed</span></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            <?php else: ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stage->requirements->count()): ?>
                                    <ul class="list-group">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stage->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $progress = $member->progress->firstWhere('requirement_id', $req->id);
                                            ?>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <b><?php echo e($req->title); ?></b>
                                                        <span class="badge bg-light text-dark"><?php echo e(ucfirst($req->type)); ?></span>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->is_mandatory): ?> <span class="badge bg-danger">Mandatory</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->requires_approval): ?> <span class="badge bg-warning text-dark">Approval</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->points): ?> <span class="badge bg-success"><?php echo e($req->points); ?> pts</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <p class="text-muted small mb-1"><?php echo e($req->description); ?></p>

                                                        
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($progress): ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($progress->status == 'completed'): ?>
                                                                <span class="badge bg-primary"> Completed</span>
                                                            <?php elseif($progress->status == 'in_review'): ?>
                                                                <span class="badge bg-warning text-dark">⏳ In Review</span>
                                                            <?php elseif($progress->status == 'pending'): ?>
                                                                <span class="badge bg-secondary">🕒 Pending</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php else: ?>
                                                            <span class="badge bg-light text-dark">Not Started</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>

                                                    
                                                    <div>
                                                        <form action="<?php echo e(route('discipleship.requirement.submit', $req->id)); ?>" method="POST" enctype="multipart/form-data" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="member_id" value="<?php echo e($member->id); ?>">

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->type == 'self_check'): ?>
                                                                <button class="btn btn-sm btn-outline-primary">Mark as Done</button>
                                                            <?php elseif($req->type == 'file_upload'): ?>
                                                                <input type="file" name="evidence" class="form-control form-control-sm mb-1" required>
                                                                <button class="btn btn-sm btn-outline-primary">Upload</button>
                                                            <?php elseif($req->type == 'custom_text'): ?>
                                                                <input type="text" name="evidence" class="form-control form-control-sm mb-1" placeholder="Write your testimony..." required>
                                                                <button class="btn btn-sm btn-outline-primary">Submit</button>
                                                            <?php elseif($req->type == 'quiz'): ?>
                                                                <a href="<?php echo e(route('quiz.start', $req->id)); ?>" class="btn btn-sm btn-outline-info">Take Quiz</a>
                                                            <?php elseif($req->type == 'attendance'): ?>
                                                                <span class="badge bg-secondary">Auto-tracked</span>
                                                            <?php elseif($req->type == 'mentor_approval'): ?>
                                                                <span class="badge bg-secondary">Awaiting Mentor Approval</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted"><?php echo e(__('No requirements added yet.')); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\my_journey.blade.php ENDPATH**/ ?>
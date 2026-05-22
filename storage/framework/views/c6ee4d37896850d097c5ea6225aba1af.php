
<?php
    $company_settings = getCompanyAllSetting();   
?>

<?php $__env->startSection('page-action'); ?>
    <?php if (app('laratrust')->hasPermission('discipleship create')) : ?>
        <a href="<?php echo e(route('discipleship.setup')); ?>" class="btn btn-sm btn-primary" title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"> Create Pathways</i>
        </a>
        <a href="<?php echo e(route('discipleship.progress')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-eye"></i> <?php echo e(__('See Member Progress')); ?>

        </a>
    <?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-title', __('Discipleship Pathways Setup')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
   

    
    <div class="col-sm-9">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-route text-primary"></i> <?php echo e(__('All Discipleship Stages')); ?></h5>
                <p class="text-muted small mb-4">
                    <?php echo e(__('Stages represent a member’s spiritual growth journey. Each stage contains requirements that must be completed to progress.')); ?>

                </p>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stages->count()): ?>
                    <div class="list-group">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item border rounded mb-3 shadow-sm">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold"><?php echo e($stage->order); ?>. <?php echo e($stage->name); ?></h6>
                                        <p class="text-muted small mb-2"><?php echo e($stage->description); ?></p>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stage->requirements->count()): ?>
                                            <ul class="small ps-3 mb-2">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stage->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <b><?php echo e($req->title); ?></b>
                                                        <span class="badge bg-light text-dark"><?php echo e(ucfirst($req->type)); ?></span>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->is_mandatory): ?> <span class="badge bg-danger">Mandatory</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->requires_approval): ?> <span class="badge bg-warning text-dark">Approval</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->points): ?> <span class="badge bg-success"><?php echo e($req->points); ?> pts</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="text-muted small"><i><?php echo e(__('No requirements added yet.')); ?></i></p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div class="text-end">
                                        <a href="<?php echo e(route('discipleship.edit', $stage->id)); ?>" class="btn btn-sm btn-outline-primary mb-1" title="Edit">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('discipleship.destroy', $stage->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger mb-1" onclick="return confirm('Are you sure you want to delete this stage?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                        <a href="<?php echo e(route('discipleship.show', $stage->id)); ?>" class="btn btn-sm btn-outline-secondary" title="View">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-light text-muted small">
                        <i class="ti ti-info-circle"></i> <?php echo e(__('No discipleship pathways have been created yet.')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-sm-3">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> <?php echo e(__('Managing Pathways')); ?></h6>
                <p class="small text-muted mb-2">
                    <?php echo e(__('Each pathway represents a stage of discipleship. From this page you can:')); ?>

                </p>
                <ul class="small text-muted ps-3">
                    <li>👀 View stage requirements</li>
                    <li>✏️ Edit stage details</li>
                    <li>➕ Add new stages</li>
                    <li>🗑️ Delete stages</li>
                </ul>

                <div class="alert alert-info small mt-3">
                    <i class="ti ti-lightbulb"></i> <b>Tip:</b> <?php echo e(__('Think of discipleship as a journey. Each stage is a milestone leading to the next.')); ?>

                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="ti ti-map text-success"></i> <?php echo e(__('Pathway Diagram')); ?>

                </h6>
                <p class="small text-muted mb-3">
                    <?php echo e(__('This diagram shows your discipleship journey as a flow. Hover over each stage to see requirements.')); ?>

                </p>

                <div class="mermaid text-center" style="overflow-x:auto;">
                    graph LR
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        stage<?php echo e($stage->id); ?>["<?php echo e($stage->order); ?>. <?php echo e($stage->name); ?>"]:::stage
                        <?php $next = $stages->where('order', $stage->order+1)->first(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($next): ?>
                            stage<?php echo e($stage->id); ?> --> stage<?php echo e($next->id); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    classDef stage fill:#4e73df,stroke:#2e59d9,color:#fff,font-weight:bold,rx:15,ry:15;
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold"><i class="ti ti-list-details text-primary"></i> <?php echo e(__('Stage Requirements')); ?></h6>
                    <ul class="list-group small">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item">
                                <b><?php echo e($stage->order); ?>. <?php echo e($stage->name); ?></b>
                                <ul class="text-muted small ps-3 mb-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $stage->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li>
                                            <?php echo e($req->title); ?>

                                            <span class="badge bg-light text-dark"><?php echo e(ucfirst($req->type)); ?></span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->is_mandatory): ?> <span class="badge bg-danger">Mandatory</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->requires_approval): ?> <span class="badge bg-warning text-dark">Approval</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($req->points): ?> <span class="badge bg-success"><?php echo e($req->points); ?> pts</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li><i class="text-muted">No requirements yet.</i></li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    mermaid.initialize({
        startOnLoad:true,
        theme: 'base',
        themeVariables: {
            primaryColor: '#4e73df',
            primaryBorderColor: '#2e59d9',
            fontSize: '14px',
            fontFamily: 'Inter, sans-serif'
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\index.blade.php ENDPATH**/ ?>
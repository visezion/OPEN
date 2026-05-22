<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Proposal')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Proposal')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div>
        <a href="<?php echo e(route('proposal.index')); ?>"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('All Proposal')); ?>" class="btn btn-sm btn-primary btn-icon">
            <i class="ti ti-filter"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $statues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $proposals = App\Models\Proposal::where('workspace', getActiveWorkSpace())
                            ->where('status', $key)
                            ->get();
                        $countstatus = $proposals->count();

                        $total = $countstatus != 0 ? number_format($countstatus / $total_proposals, 4) : 0;
                        $totalpercentage = $total*100;
                    ?>

                    <div class="col-lg-4" id="<?php echo e($key); ?>">
                        <div class="card hover-shadow-lg">
                            <div class="card-header">
                                <div class="float-end">
                                    <button class="btn btn-sm btn-primary btn-icon count">
                                        <?php echo e($countstatus); ?>

                                    </button>
                                </div>
                                <h4 class="mb-0"><?php echo e($status); ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="p-3">
                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-6">
                                            <h6 class="mb-0"><?php echo e($countstatus); ?></h6>
                                            <span class="text-sm text-muted"><?php echo e(__('Total')); ?></span>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <h6 class="mb-0"><?php echo e($totalpercentage); ?><?php echo e(__('%')); ?>

                                            </h6>
                                            <span class="text-sm text-muted"><?php echo e(__('Total Percentage')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\proposal\statsreport.blade.php ENDPATH**/ ?>
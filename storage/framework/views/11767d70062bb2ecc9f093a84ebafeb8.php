<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Invoices')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Invoices')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div>

        <a href="<?php echo e(route('invoice.index')); ?>"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('All Invoice')); ?>" class="btn btn-sm btn-primary btn-icon">
            <i class="ti ti-filter"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <?php $__currentLoopData = $statues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $invoices = App\Models\Invoice::where('workspace', getActiveWorkSpace())
                            ->where('status', $key)
                            ->get();
                        $countstatus = $invoices->count();
                        $totalAmount = 0;
                        foreach ($invoices as $invoice) {
                            $totalAmount += $invoice->getDue();
                        }

                        $total = $totalDueAmount != 0 ? number_format($totalAmount / $totalDueAmount, 4) : 0;
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
                                            <h6 class="mb-0"><?php echo e(currency_format_with_sym($totalAmount)); ?></h6>
                                            <span class="text-sm text-muted"><?php echo e(__('Total Amount')); ?></span>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <h6 class="mb-0"><?php echo e($total * 100); ?><?php echo e(__('%')); ?>

                                            </h6>
                                            <span class="text-sm text-muted"><?php echo e(__('Total Percentage')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\invoice\statusreport.blade.php ENDPATH**/ ?>
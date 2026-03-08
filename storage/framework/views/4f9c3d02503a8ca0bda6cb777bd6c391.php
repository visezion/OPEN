<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Product Stock')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Report')); ?>,
    <?php echo e(__('Product Stock Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Product Name')); ?></th>
                                    <th><?php echo e(__('Quantity')); ?></th>
                                    <th><?php echo e(__('Type')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="font-style"><?php echo e(company_date_formate($stock->created_at)); ?></td>
                                        <?php if(module_is_active('ProductService')): ?>
                                            <td><?php echo e(!empty($stock->name) ? $stock->name : ''); ?></td>
                                        <?php else: ?>
                                            <td class="text-info"><?php echo e(__('Product & Service Module is Off')); ?></td>
                                        <?php endif; ?>
                                        <td class="font-style"><?php echo e($stock->quantity); ?></td>
                                        <td class="font-style"><?php echo e(ucfirst($stock->type)); ?></td>
                                        <td class="font-style"><?php echo e($stock->description); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\report\product_stock_report.blade.php ENDPATH**/ ?>
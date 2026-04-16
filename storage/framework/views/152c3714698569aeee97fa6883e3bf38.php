<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Coupon Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <?php echo e(__('Coupon Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table  mb-0 pc-dt-simple" id="user-coupon">
                            <thead>
                            <tr>
                                <th> <?php echo e(__('User')); ?></th>
                                <th> <?php echo e(__('Date')); ?></th>
                                <th> <?php echo e(__('Plan Name')); ?></th>
                                <th><?php echo e(__('Payment Type')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $userCoupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userCoupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="font-style">
                                    <td><?php echo e(!empty($userCoupon->userDetail)?$userCoupon->userDetail->name:''); ?></td>
                                    <td><?php echo e($userCoupon->created_at); ?></td>
                                    <?php
                                        $order = \App\Models\Order::where('order_id',$userCoupon->order)->first();
                                    ?>
                                    <td><?php echo e(!empty($order->plan_name) ? $order->plan_name : 'Basic Package'); ?></td>
                                    <td><?php echo e(!empty($order->payment_type) ? $order->payment_type : '--'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\coupon\view.blade.php ENDPATH**/ ?>
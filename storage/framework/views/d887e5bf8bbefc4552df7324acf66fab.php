<?php $__currentLoopData = $userOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($user->active_plan == $order->plan_id && $order->order_id == $userOrder->order_id && $order->is_refund == 0): ?>
         <div class="action-btn">
            <?php echo Form::open([
                'method' => 'get',
                'route' => ['order.refund', [$order->id, $order->user_id]],
                'id' => 'refund-form-' . $order->id,
            ]); ?>

            <a href="#" class="btn btn-sm  align-items-center bs-pass-para show_confirm bg-warning"
                data-text="<?php echo e(__('You want to confirm refund the plan. Press Yes to continue or No to go back')); ?>"
                data-bs-toggle="tooltip" title="" data-bs-original-title="<?php echo e(__('Refund')); ?>"
                aria-label="<?php echo e(__('Refund')); ?>" data-confirm-yes="refund-form-<?php echo e($order->id); ?>"><i
                    class="ti ti-refresh text-white"></i></a>
            <?php echo e(Form::close()); ?>

        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\plan_order\action.blade.php ENDPATH**/ ?>
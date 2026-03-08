<?php $__env->startSection('title', __('Thank you')); ?>
<?php $__env->startSection('content'); ?>
    <div class="note mb-3">
        <h2><?php echo e(__('Thank you!')); ?></h2>
        <p class="text-muted">
            <?php echo e($mode === 'donation' ? __('Your generosity has been recorded and we will coordinate pickup within 24 hours.') : __('Your request is now in the queue and we will reach out soon with the next steps.')); ?>

        </p>
    </div>
    <div class="grid">
        <div class="field">
            <label><?php echo e(__('Share link')); ?></label>
            <input type="text" readonly value="<?php echo e($mode === 'request' ? route('foodbank.public.request', ['token' => $token]) : route('foodbank.public.donate', ['token' => $token])); ?>">
        </div>
        <div class="field">
            <label><?php echo e(__('Back to')); ?></label>
            <a class="btn-wide" href="<?php echo e($mode === 'request' ? route('foodbank.public.request', ['token' => $token]) : route('foodbank.public.donate', ['token' => $token])); ?>">
                <?php echo e($mode === 'request' ? __('Submit another request') : __('Record another donation')); ?>

            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('foodbank::public.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\public\thankyou.blade.php ENDPATH**/ ?>
<div class="payment-method">
    <div class="payment-title d-flex align-items-center justify-content-between">
        <h4><?php echo e(__('PayPal')); ?></h4>
        <div class="payment-image extra-size d-flex align-items-center">
            <img src="<?php echo e(get_module_img('Paypal')); ?>" alt="">
        </div>
    </div>
    <p><?php echo e(__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase.')); ?>

    </p>
    <form method="POST" action="<?php echo e(route('course.pay.with.paypal', $store->slug)); ?>"
        class="payment-method-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="product_id">
        <div class="form-group text-right">
            <button type="submit" class="btn"><?php echo e(__('Pay Now')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\payment\course_payment.blade.php ENDPATH**/ ?>
<div class="payment-method">
    <div class="payment-title d-flex align-items-center justify-content-between">
        <h2 class="h5"><?php echo e(__('PayPal')); ?></h2>
        <div class="payment-image">
            <img src="<?php echo e(get_module_img('Paypal')); ?>" alt="">
        </div>
    </div>
    <p><?php echo e(__('Pay your order using the most known and secure platform for online money transfers. You will be redirected to PayPal to finish complete your purchase.')); ?>

    </p>
    <form method="POST" action="<?php echo e(route('content.pay.with.paypal', $store->slug)); ?>" class="payment-method-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="product_id">
        <div class="pay-btn text-right">
            <button class="btn" type="submit"><?php echo e(__('Pay Now')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\payment\content_payment.blade.php ENDPATH**/ ?>
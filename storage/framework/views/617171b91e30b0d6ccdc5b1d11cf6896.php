<?php if(!empty($cardPayment_content) && isset($cardPayment_content->stripe) && $cardPayment_content->stripe->status === 'on'): ?>
<div class="payment-div">
    <a href="<?php echo e(route('vcard.pay.with.stripe', $business->id)); ?>">
        <img src="<?php echo e(asset('packages/workdo/VCard/src/Resources/assets/custom/img/payments/stripe.png')); ?>"
            alt="social" class="img-fluid">
        <?php echo e(__('Stripe')); ?>

    </a>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\vcard_payment_booking.blade.php ENDPATH**/ ?>
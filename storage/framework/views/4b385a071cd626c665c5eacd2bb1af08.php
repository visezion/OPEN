<?php if(!empty($cardPayment_content) && isset($cardPayment_content->paypal) && $cardPayment_content->paypal->status == 'on'): ?>
<div class="payment-div">
    <a href="<?php echo e(route('vcard.pay.with.paypal', $business->id)); ?>">
        <img src="<?php echo e(asset('packages/workdo/VCard/src/Resources/assets/custom/img/payments/paypal.png')); ?>"
            alt="social" class="img-fluid">
        <?php echo e(__('payPal')); ?>

    </a>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\payment\vcard_payment_booking.blade.php ENDPATH**/ ?>
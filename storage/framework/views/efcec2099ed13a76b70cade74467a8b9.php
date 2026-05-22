
<div class="single-option">
    <div class="option-input-box">
        <div class="option-inner d-flex">
            <div class="option-icon">
                <img src="<?php echo e(get_module_img('Paypal')); ?>" alt="Payment Logo" class="img-user">
            </div>
            <div>
                <label for="paypal-payment">
                    <p class="mb-0 text-capitalize pointer"><?php echo e(Module_Alias_Name('Paypal')); ?></p>
                </label>
            </div>
        </div>
        <div class="form-check">
            <input class="form-check-input payment_method" name="payment_method" id="paypal-payment"
                type="radio" data-payment-action="<?php echo e(route('event.show.booking.pay.with.paypal',[$slug])); ?>">
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\payment\eventshowbooking_payment.blade.php ENDPATH**/ ?>
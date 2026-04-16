

<div class="single-option">
    <div class="radio-group">
        <input class="form-check-input payment_method" id="payment-2" name="payment"
                type="radio" data-payment-action="<?php echo e(route('property.booking.pay.with.paypal',[$slug])); ?>">
        <label for="payment-2">
            <div class="option-image">
                <img src="<?php echo e(get_module_img('Paypal')); ?>" alt="Payment Logo" class="img-user">
            </div>
            <p class="mb-0 text-capitalize pointer"><?php echo e(Module_Alias_Name('Paypal')); ?></p>
        </label>
    </div>
</div>





<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\payment\property_booking_payment.blade.php ENDPATH**/ ?>
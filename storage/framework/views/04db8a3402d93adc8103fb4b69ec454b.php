

<div class="single-option">
    <div class="radio-group">
        <input class="form-check-input payment_method" id="payment-1" name="payment"
                type="radio" data-payment-action="<?php echo e(route('property.booking.pay.with.stripe',[$slug])); ?>">
        <label for="payment-1">
            <div class="option-image">
                <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="Payment Logo" class="img-user">
            </div>
            <p class="mb-0 text-capitalize pointer"><?php echo e(Module_Alias_Name('Stripe')); ?></p>
        </label>
    </div>
</div>





<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\property_booking_payment.blade.php ENDPATH**/ ?>
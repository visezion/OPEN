<div class="single-option">
    <div class="option-input-box">
        <div class="option-inner d-flex">
            <div class="option-icon">
                <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="Payment Logo" class="img-user">
            </div>
            <div>   
                <label for="stripe-payment">
                    <p class="mb-0 text-capitalize pointer"><?php echo e(Module_Alias_Name('Stripe')); ?></p>
                </label>
            </div>
        </div>
        <div class="form-check">
            <input class="form-check-input payment_method" name="payment_method" id="stripe-payment"
                type="radio" data-payment-action="<?php echo e(route('event.show.booking.pay.with.stripe',[$slug])); ?>">
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\eventshowbooking_payment.blade.php ENDPATH**/ ?>
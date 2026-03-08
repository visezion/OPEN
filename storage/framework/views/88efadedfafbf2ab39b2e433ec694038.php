<li class="radio-btn">
    <input name="payment" id="stripe-payment" type="radio" class="payment_method"
        data-payment-action="<?php echo e(route('sports.club.pay.with.stripe', [$slug])); ?>">

    <label for="stripe-payment" class="radio-btn-label d-flex align-items-center gap-3 p-3 justify-content-center">
        <span class="fs-5 f-w-600"><?php echo e(Module_Alias_Name('Stripe')); ?></span>
        <div class="radio-img">
            <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="" class="img-user" style="max-width: 100%">
        </div>
    </label>
</li>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\sports_and_club_payment.blade.php ENDPATH**/ ?>
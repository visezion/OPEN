<li class="radio-btn">
    <input name="membership-payment" id="stripe-plan-payment" type="radio" class="plan_payment_method"
        data-payment-action="<?php echo e(route('sports.club.plan.pay.with.stripe', [$slug])); ?>">

    <label for="stripe-plan-payment" class="radio-btn-label d-flex align-items-center gap-3 p-3 justify-content-center">
        <span class="fs-5 f-w-600"><?php echo e(Module_Alias_Name('Stripe')); ?></span>
        <div class="radio-img">
            <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="" class="img-user" style="max-width: 100%">
        </div>
    </label>
</li>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\sports_and_club_membership_payment.blade.php ENDPATH**/ ?>
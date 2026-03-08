
<div class="payment-item border-b">
    <input type="radio" value="stripe" name="payment" id="stripe-payment" class="form-check-input payment-option hidden"  data-payment-action="<?php echo e(route('brand.deposit.pay.payment.with.stripe',[$slug])); ?>">
    <label for="stripe-payment" class="flex items-center cursor-pointer">
        <div class="p-4 flex justify-between items-center flex-grow gap-2">
            <span class="font-medium"><?php echo e(Module_Alias_Name('Stripe')); ?></span>
            <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="" class="max-w-12" >
        </div>
    </label>
</div>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\brand_deposit_payment.blade.php ENDPATH**/ ?>
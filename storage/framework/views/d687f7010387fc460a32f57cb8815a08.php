<div class="payment-method">
    <input type="radio" id="payment-stripe" name="payment-method" value="stripe"
           class="peer hidden payment-option"
           data-payment-action="<?php echo e(route('ngo.donation.pay.with.stripe', [$slug])); ?>">
    <label for="payment-stripe"
           class="border-2 border-gray-200 peer-checked:border-secondary peer-checked:bg-secondary/5 hover:border-secondary hover:bg-secondary/5 rounded-lg p-3 cursor-pointer transition-all duration-300 block">
        <div class="flex flex-col items-center text-center">
            <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="Stripe" class="w-8 h-8 mb-1">
            <span class="text-xs font-medium"><?php echo e(Module_Alias_Name('Stripe')); ?></span>
        </div>
    </label>
</div><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\ngo_donation_payment.blade.php ENDPATH**/ ?>
<label class="flex items-center p-3 border cursor-pointer hover:bg-gray-50 transition duration-300">
    <div class="relative me-3">
        <input type="radio" name="payment" value="stripe" id="stripe-payment" class="sr-only peer payment_method"
            data-payment-action="<?php echo e(route('artwork.pay.with.stripe', [$slug])); ?>">
        <div
            class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-secondary peer-checked:bg-secondary flex items-center justify-center">
            <div class="w-2 h-2 bg-white rounded-full">
            </div>
        </div>
    </div>
    <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="" class="w-5 h-5 me-2" style="max-width: 100%">
    <?php echo e(Module_Alias_Name('Stripe')); ?>

</label><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\art_showcase_payment.blade.php ENDPATH**/ ?>
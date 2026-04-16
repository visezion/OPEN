<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type == 'membership'): ?>
    <input type="hidden" name="type" value="membership">
<?php elseif($type == 'booking'): ?>
    <input type="hidden" name="type" value="booking">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<div class="col-sm-6 col-lg-6 col-md-6">
    <div class="card">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="theme-avtar ">
                        <img src="<?php echo e(get_module_img('Paypal')); ?>" alt="" class="img-user" style="max-width: 100%">
                    </div>
                    <div class="ms-3">
                        <label for="paypal-payment">
                            <h5 class="mb-0 text-capitalize pointer"><?php echo e(Module_Alias_Name('Paypal')); ?></h5>
                        </label>
                    </div>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input payment_method" value="paypal" name="payment_method" id="paypal-payment"
                    data-payment-action="<?php echo e(route('coworking.pay.with.paypal',[$slug])); ?>">
                </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\payment\coworking_payment.blade.php ENDPATH**/ ?>
<div class="col-sm-6 col-lg-6 col-md-6">
    <div class="card">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="theme-avtar ">
                        <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="" class="img-user" style="max-width: 100%">
                    </div>
                    <div class="ms-3">
                        <label for="stripe-payment">
                            <h5 class="mb-0 text-capitalize pointer"><?php echo e(Module_Alias_Name('Stripe')); ?></h5>
                        </label>
                    </div>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input payment_method" value="stripe" name="payment_method" id="stripe-payment"
                    data-payment-action="<?php echo e(route('boutique.pay.payment.with.stripe',[$slug])); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\boutique_payment.blade.php ENDPATH**/ ?>
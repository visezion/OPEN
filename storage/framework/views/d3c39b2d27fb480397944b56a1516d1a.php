<div class="card" id="stripe-sidenav">
    <?php echo e(Form::open(['route' => 'stripe.setting.store', 'enctype' => 'multipart/form-data'])); ?>


    <div class="card-header p-3">
        <div class="row align-items-center">
            <div class="col-sm-10 col-9">
                <h5 class=""><?php echo e(__('Stripe')); ?></h5>
                <small><?php echo e(__('These details will be used to collect subscription plan payments.Each subscription plan will have a payment button based on the below configuration.')); ?></small>
            </div>
            <div class="col-sm-2 col-3 text-end">
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <input type="checkbox" name="stripe_is_on" class="form-check-input input-primary" id="stripe_is_on"
                        <?php echo e((isset($settings['stripe_is_on']) ? $settings['stripe_is_on'] : 'off') == 'on' ? ' checked ' : ''); ?>>
                    <label class="form-check-label" for="stripe_is_on"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-3 pb-0">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="stripe_key" class="form-label"><?php echo e(__('Stripe Key')); ?></label>
                    <input class="form-control stripe_webhook" placeholder="<?php echo e(__('Stripe Key')); ?>" name="stripe_key"
                        type="text" value="<?php echo e(isset($settings['stripe_key']) ? $settings['stripe_key'] : ''); ?>"
                        <?php echo e((isset($settings['stripe_is_on']) ? $settings['stripe_is_on'] : 'off')  == 'on' ? '' : ' disabled'); ?> id="stripe_key">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="stripe_secret" class="form-label"><?php echo e(__('Stripe Secret Key')); ?></label>
                    <input class="form-control stripe_webhook" placeholder="<?php echo e(__('Stripe Secret Key')); ?>"
                        name="stripe_secret" type="text" value="<?php echo e(isset($settings['stripe_secret']) ? $settings['stripe_secret'] : ''); ?>"
                        <?php echo e((isset($settings['stripe_is_on']) ? $settings['stripe_is_on'] : 'off')  == 'on' ? '' : ' disabled'); ?> id="stripe_secret">
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer text-end p-3">
        <input class="btn btn-print-invoice  btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
    </div>
    <?php echo e(Form::close()); ?>

</div>
<script>
    $(document).on('click', '#stripe_is_on', function() {
        if ($('#stripe_is_on').prop('checked')) {
            $(".stripe_webhook").removeAttr("disabled");
        } else {
            $('.stripe_webhook').attr("disabled", "disabled");
        }
    });
</script>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\super-admin\settings\index.blade.php ENDPATH**/ ?>
<div class="tab-pane fade" id="paypal-payment" role="tabpanel" aria-labelledby="paypal-payment">
    <form method="post" action="<?php echo e(route('invoice.pay.with.paypal')); ?>" class="require-validation" id="payment-form">
        <?php echo csrf_field(); ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type == 'invoice'): ?>
            <input type="hidden" name="type" value="invoice">
        <?php elseif($type == 'retainer'): ?>
            <input type="hidden" name="type" value="retainer">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="amount"><?php echo e(__('Amount')); ?></label>
                <div class="input-group">
                    <span class="input-group-prepend"><span
                            class="input-group-text"><?php echo e(!empty($company_settings['defult_currancy']) ? $company_settings['defult_currancy'] : '$'); ?></span>
                    </span>

                    <input class="form-control" required="required" min="0"
                        name="amount" type="number"
                        value="<?php echo e($invoice->getDue()); ?>" min="0"
                        step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                        id="amount">
                    <input type="hidden" value="<?php echo e($invoice->id); ?>"
                        name="invoice_id">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="error" style="display: none;">
                    <div class='alert-danger alert'>
                        <?php echo e(__('Please correct the errors and try again.')); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button type="button" class="btn  btn-secondary me-1"
                data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            <button class="btn btn-primary"
                type="submit"><?php echo e(__('Make Payment')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\payment\nav_containt_div.blade.php ENDPATH**/ ?>
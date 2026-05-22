

<div class="card" id="bank-transfer-sidenav">
    <?php echo e(Form::open(['route' => ['bank.transfer.setting'], 'id' => 'payment-form'])); ?>

    <div class="card-header p-3">
        <div class="row align-items-center">
            <div class="col-md-10 col-9">
                <h5 class=""><?php echo e(__('Bank Transfer')); ?></h5>
                <small class="" ><?php echo e(__('These details will be used to collect subscription, invoice, retainer, etc. payments.')); ?></small>
            </div>
            <div class="col-md-2 col-3 text-end">
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <input type="checkbox" name="bank_transfer_payment_is_on" class="form-check-input input-primary" id="bank_transfer_payment_is_on" <?php echo e((isset($settings['bank_transfer_payment_is_on']) && $settings['bank_transfer_payment_is_on'] =='on') ?' checked ':''); ?> >
                    <label class="form-check-label" for="bank_transfer_payment_is_on"></label>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-3 pb-0">
        <div class="col-xxl-6">
            <div class="form-group">
                <div class="d-flex  flex-column flex-sm-row  gap-2 mb-2">
                    <label class="form-label mb-0"><?php echo e(__('Bank Details')); ?></label>
                    <textarea type="text" name="bank_number" id="bank_number" class="form-control bank_transfer_text flex-1" <?php echo e((isset($settings['bank_transfer_payment_is_on']) && $settings['bank_transfer_payment_is_on']  == 'on') ? '' : ' disabled'); ?> rows="3" placeholder="<?php echo e(__('Bank Transfer Number')); ?>"><?php echo e(!empty(company_setting('bank_number'))?company_setting('bank_number'):''); ?></textarea>
                </div>
                <?php if (isset($component)) { $__componentOriginal196cabbf5fb9f59797b6c88c3b904481 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea-setting-validation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-setting-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $attributes = $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $component = $__componentOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body p-3">
                        <p class="mb-0"><?php echo e(__('Example : Bank : bank name </br> Account Number : 0000 0000 </br>')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body p-3">
                        <p class="mb-0"><?php echo e(__('Preview : ')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body p-3">
                        <p class="mb-0"><?php echo e(__('Bank : bank name')); ?></small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body p-3">
                        <p class="mb-0"><?php echo e(__('Account Number : 0000 0000')); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end p-3">
        <input class="btn btn-print-invoice btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
    </div>
    <?php echo e(Form::close()); ?>


</div>

<script>
    $(document).on('click', '#bank_transfer_payment_is_on', function() {
        if ($('#bank_transfer_payment_is_on').prop('checked')) {
            $(".bank_transfer_text").removeAttr("disabled");
        } else {
            $('.bank_transfer_text').attr("disabled", "disabled");
        }
    });
</script>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\bank_transfer\setting.blade.php ENDPATH**/ ?>
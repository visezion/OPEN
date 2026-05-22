<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($vendor)): ?>
    <div class="row">
        <div class="col-md-5 col-sm-6 col-12">
            <h6><?php echo e(__('Bill to')); ?></h6>
            <div class="bill-to">
                <p>
                    <span><?php echo e($vendor['billing_name']); ?></span><br>
                    <span><?php echo e($vendor['billing_address']); ?></span><br>
                    <span><?php echo e($vendor['billing_city'].' , '.$vendor['billing_state'].' ,'. $vendor['billing_zip']); ?></span><br>
                    <span><?php echo e($vendor['billing_country']); ?></span><br>
                    <span><?php echo e($vendor['billing_phone']); ?></span><br>
                </p>
            </div>
        </div>
        <div class="col-md-5 col-sm-6 col-12">
            <h6><?php echo e(__('Ship to')); ?></h6>
            <div class="bill-to">
                <p>
                    <span><?php echo e($vendor['shipping_name']); ?></span><br>
                    <span><?php echo e($vendor['shipping_address']); ?></span><br>
                    <span><?php echo e($vendor['shipping_city'].' , '.$vendor['shipping_state'].' ,'. $vendor['shipping_zip']); ?></span><br>
                    <span><?php echo e($vendor['shipping_country']); ?></span><br>
                    <span><?php echo e($vendor['shipping_phone']); ?></span><br>
                </p>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove" class="text-sm btn btn-danger"><?php echo e(__(' Remove')); ?></a>
        </div>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bill\vender_detail.blade.php ENDPATH**/ ?>
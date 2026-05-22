<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account') && !empty($bankaccounts)): ?>
    <div class="row">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($bankaccounts['bank_name'])): ?>
            <div class="col-md-8">
                <h6><?php echo e(__('Bank Details')); ?></h6>
                <div class="bill-to">

                        <span><?php echo e(__('Bank Name')); ?> : <?php echo e($bankaccounts['bank_name']); ?></span><br>
                        <span><?php echo e(__('Account Number')); ?> : <?php echo e($bankaccounts['account_number']); ?></span><br>
                        <span><?php echo e(__('Current Balance')); ?> : <?php echo e($bankaccounts['opening_balance']); ?></span><br>
                        <span><?php echo e(__('Contact Number')); ?> : <?php echo e($bankaccounts['contact_number']); ?></span><br>
                        <span><?php echo e(__('Bank Branch')); ?> : <?php echo e($bankaccounts['bank_branch']); ?></span><br>

                </div>
            </div>
        <?php else: ?>
         <div class="col-md-10">
            <h6 class=""><?php echo e(__('Please On Your Bank Account!')); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account')): ?>
                    <a href="<?php echo e(route('settings.index')); ?>"><?php echo e(__('Click Here')); ?></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </h6>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="col-md-2">
            <a href="#" id="remove" class="text-sm"><?php echo e(__(' Remove')); ?></a>
        </div>
    </div>
<?php else: ?>
<div class="row">

    <div class="col-md-2 mt-5">
        <a href="#" id="remove" class="text-sm"><?php echo e(__(' Remove')); ?></a>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bankaccount_detail.blade.php ENDPATH**/ ?>
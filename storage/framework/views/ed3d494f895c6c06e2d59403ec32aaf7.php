<?php echo e(Form::model($bankAccount, ['route' => ['bank-account.update', $bankAccount->id], 'method' => 'PUT', 'class'=>'needs-validation', 'novalidate'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <label class="require form-label"><?php echo e(__('Bank Type')); ?></label>
            <select class="form-control" name="bank_type" id="bank_type">
                <option value=""><?php echo e(__('Select Type')); ?></option>
                <option value="bank" <?php if($bankAccount->bank_type =='bank'): ?> selected <?php endif; ?>  ><?php echo e(__('Bank')); ?></option>
                <option value="wallet" <?php if($bankAccount->bank_type =='wallet'): ?> selected <?php endif; ?> ><?php echo e(__('Wallet')); ?></option>
            </select>
        </div>

    </div>
    <div class="row bank_type_wallet <?php echo e($bankAccount->bank_type == 'wallet' ? '' : 'd-none'); ?>">
        <div class="form-group col-md-12">
            <label class="require form-label"><?php echo e(__('Wallet')); ?></label>
            <select class="form-control" name="wallet_type" id="wallet_type">
                <option value=""><?php echo e(__('Select Type')); ?></option>
                <option value="paypal" <?php if($bankAccount->wallet_type =='paypal'): ?> selected <?php endif; ?> ><?php echo e(__('Paypal')); ?></option>
                <option value="stripe" <?php if($bankAccount->wallet_type =='stripe'): ?> selected <?php endif; ?> ><?php echo e(__('Stripe')); ?></option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('chart_account_id', __('Account'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
            <select name="chart_account_id" class="form-control" required="required">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $chartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chartAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" class="subAccount" <?php echo e($bankAccount->chart_account_id == $key ? 'selected' : ''); ?>><?php echo e($chartAccount); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($key == $subAccount['account']): ?>
                            <option value="<?php echo e($subAccount['id']); ?>" class="ms-5" <?php echo e($bankAccount->chart_account_id == $subAccount['id'] ? 'selected' : ''); ?>> &nbsp; &nbsp;&nbsp; <?php echo e($subAccount['code']); ?> - <?php echo e($subAccount['name']); ?></option>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('payment_name', __('Payment Gateway'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <select name="payment_name" class="form-control" required="required">
                    <option value="Bank Transfer" <?php echo e($bankAccount->payment_name == 'Bank Transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                        <?php echo $__env->yieldPushContent('bank_payments'); ?>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('holder_name', __('Bank Holder Name'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::text('holder_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Bank Holder Name')])); ?>

            </div>
        </div>
        <div class="col-md-6 bank  <?php echo e($bankAccount->bank_type == 'wallet' ? 'd-none' : ''); ?> ">
            <div class="form-group">
                <?php echo e(Form::label('bank_name', __('Bank Name'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::text('bank_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Bank Name') ,  $bankAccount->bank_type == 'wallet' ? '' : 'required' => 'required' ])); ?>

            </div>
        </div>
        <div class="col-md-6 bank  <?php echo e($bankAccount->bank_type == 'wallet' ? 'd-none' : ''); ?> ">
            <div class="form-group">
                <?php echo e(Form::label('account_number', __('Account Number'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::text('account_number', null, ['class' => 'form-control',  $bankAccount->bank_type == 'wallet' ? '' : 'required' => 'required' , 'placeholder' => __('Enter Account Number')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('opening_balance', __('Opening Balance'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::number('opening_balance', null, ['class' => 'form-control', 'required' => 'required', 'min' => '0','step'=>'0.1','placeholder' => __('Enter Opening Balance')])); ?>

            </div>
        </div>

        <?php if (isset($component)) { $__componentOriginal5d1845474bd0b0647eed674e26ea3910 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d1845474bd0b0647eed674e26ea3910 = $attributes; } ?>
<?php $component = App\View\Components\Mobile::resolve(['divClass' => 'col-lg-6 col-md-6 col-sm-6 '.e($bankAccount->bank_type == 'wallet' ? 'd-none' : '').' ','name' => 'contact_number','label' => ''.e(__('Contact Number')).'','placeholder' => ''.e(__('Enter Contact Number')).'','value' => ''.e(!empty($bankAccount->contact_number) ? $bankAccount->contact_number : null).'','id' => 'contact_number','required' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mobile'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Mobile::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5d1845474bd0b0647eed674e26ea3910)): ?>
<?php $attributes = $__attributesOriginal5d1845474bd0b0647eed674e26ea3910; ?>
<?php unset($__attributesOriginal5d1845474bd0b0647eed674e26ea3910); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5d1845474bd0b0647eed674e26ea3910)): ?>
<?php $component = $__componentOriginal5d1845474bd0b0647eed674e26ea3910; ?>
<?php unset($__componentOriginal5d1845474bd0b0647eed674e26ea3910); ?>
<?php endif; ?>

        <div class="col-md-6 bank  <?php echo e($bankAccount->bank_type == 'wallet' ? 'd-none' : ''); ?> ">
            <div class="form-group">
                <?php echo e(Form::label('bank_branch', __('Bank Branch'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::text('bank_branch', null, array('class' => 'form-control', $bankAccount->bank_type == 'wallet' ? '' : 'required' => 'required' , "min"=>"0",'placeholder' => __('Enter Bank Branch')))); ?>

            </div>
        </div>
        <div class="col-md-6 bank  <?php echo e($bankAccount->bank_type == 'wallet' ? 'd-none' : ''); ?> ">
            <div class="form-group">
                <?php echo e(Form::label('swift', __('SWIFT'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('swift', null, ['class' => 'form-control', 'placeholder' => __('Enter Swift Number')])); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('bank_address', __('Bank Address'), ['class' => 'form-label '])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::textarea('bank_address', null, ['class' => 'form-control', 'placeholder' => __('Enter Bank Address'), 'rows' => '3', 'required' => 'required'])); ?>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <?php echo e(Form::submit(__('Update'), ['class' => 'btn  btn-primary'])); ?>

</div>
<?php echo e(Form::close()); ?>

<script>
    $(document).ready(function() {
        $('#bank_type').on('change', function() {
            if ($(this).val() === 'bank') {
                $('.bank_type_wallet').addClass('d-none')
                $('.bank').removeClass('d-none')
                $('#swift').prop('required',true);
                $('#bank_name').prop('required',true);
                $('#account_number').prop('required',true);
                $('#bank_branch').prop('required',true);
                $('.bank').addClass('d-block');
            } else {
                $('#swift').prop('required',false);
                $('#bank_name').prop('required',false);
                $('#account_number').prop('required',false);
                $('#bank_branch').prop('required',false);
                $('.bank_type_wallet').removeClass('d-none')
                $('.bank_type_wallet').addClass('d-block');
            }
        });
    });


    $(document).ready(function() {
        $('#bank_type').on('change', function() {
            if ($(this).val() === 'wallet') {
                $('.bank_type_wallet').removeClass('d-none')
                $('.bank').addClass('d-none');
            } else {
                $('.bank').removeClass('d-none')
                $('.bank_type_wallet').addClass('d-block');
            }
        });
    });
</script>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bankAccount\edit.blade.php ENDPATH**/ ?>
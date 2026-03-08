<?php echo e(Form::open(array('url' => 'bank-transfer', 'class'=>'needs-validation', 'novalidate'))); ?>

<div class="modal-body">
    <div class="text-end">
        <?php if(module_is_active('AIAssistant')): ?>
            <?php echo $__env->make('aiassistant::ai.generate_ai_btn',['template_module' => 'transfer','module'=>'Account'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>
    <div class="row mt-2">
        <div class="form-group col-md-6">
            <label class="require form-label"><?php echo e(__('From Type')); ?></label>
            <select class="form-control"
                name="from_type" id="from_type">
                <option value=""><?php echo e(__('Select Type')); ?></option>
                <option value="bank"><?php echo e(__('Bank')); ?></option>
                <option value="wallet"><?php echo e(__('Wallet')); ?></option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label class="require form-label"><?php echo e(__('To Type')); ?></label>
            <select class="form-control"
                name="to_type" id="to_type">
                <option value=""><?php echo e(__('Select Type')); ?></option>
                <option value="bank"><?php echo e(__('Bank')); ?></option>
                <option value="wallet"><?php echo e(__('Wallet')); ?></option>
            </select>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('from_account', __('From Account'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                <?php echo e(Form::select('from_account', $bankAccount,null, array('class' => 'form-control ','required'=>'required','placeholder' => 'Select Account','id' => 'from_account'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('to_account', __('To Account'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                <?php echo e(Form::select('to_account', $bankAccount,null, array('class' => 'form-control ','required'=>'required','placeholder' => 'Select Account'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('amount', __('Amount'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                <?php echo e(Form::number('amount', '', array('class' => 'form-control bank_amount','required'=>'required',"min"=>"0",'placeholder' => __('Enter Amount')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('date', __('Date'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                <?php echo e(Form::date('date',null, ['class' => 'form-control ','required'=>'required','placeholder' => 'Select Date'])); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('reference', __('Reference'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('reference', '', array('class' => 'form-control','placeholder' => 'Enter Reference'))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description'),'rows'=>'3'])); ?>

            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn  btn-primary'])); ?>

</div>
<?php echo e(Form::close()); ?>


<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\transfer\create.blade.php ENDPATH**/ ?>
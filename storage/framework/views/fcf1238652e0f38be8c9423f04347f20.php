<?php if($productService == []): ?>
<div class="form-group col-md-6">
    <?php echo e(Form::label('sale_chartaccount_id', __('Income Account'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
    <select name="sale_chartaccount_id" class="form-control" required>
        <option value="">Select Chart of Account</option>
        <?php $__currentLoopData = $incomeChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeName => $subtypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <optgroup label="<?php echo e($typeName); ?>">
                <?php $__currentLoopData = $subtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtypeId => $subtypeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option disabled style="color: #000; font-weight: bold;"><?php echo e($subtypeData['account_name']); ?></option>
                    <?php $__currentLoopData = $subtypeData['chart_of_accounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartOfAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($chartOfAccount['id']); ?>">
                            &nbsp;&nbsp;&nbsp;<?php echo e($chartOfAccount['account_name']); ?>

                        </option>
                        <?php $__currentLoopData = $subtypeData['subAccounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($chartOfAccount['id'] == $subAccount['parent']): ?>
                            <option value="<?php echo e($subAccount['id']); ?>" class="ms-5"> &nbsp; &nbsp;&nbsp;&nbsp; <?php echo e(' - '. $subAccount['account_name']); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </optgroup>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group col-md-6">
    <?php echo e(Form::label('expense_chartaccount_id', __('Expense Account'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
    <select name="expense_chartaccount_id" class="form-control" required>
        <option value="">Select Chart of Account</option>
        <?php $__currentLoopData = $expenseChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeName => $subtypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <optgroup label="<?php echo e($typeName); ?>">
                <?php $__currentLoopData = $subtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtypeId => $subtypeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option disabled style="color: #000; font-weight: bold;"><?php echo e($subtypeData['account_name']); ?></option>
                    <?php $__currentLoopData = $subtypeData['chart_of_accounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartOfAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($chartOfAccount['id']); ?>">
                            &nbsp;&nbsp;&nbsp;<?php echo e($chartOfAccount['account_name']); ?>

                        </option>
                        <?php $__currentLoopData = $subtypeData['subAccounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($chartOfAccount['id'] == $subAccount['parent']): ?>
                            <option value="<?php echo e($subAccount['id']); ?>" class="ms-5"> &nbsp; &nbsp;&nbsp;&nbsp; <?php echo e(' - '. $subAccount['account_name']); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </optgroup>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<?php else: ?>
<div class="form-group col-md-6">
    <?php echo e(Form::label('sale_chartaccount_id', __('Income Account'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
    <select name="sale_chartaccount_id" class="form-control" required>
        <option value="">Select Chart of Account</option>
        <?php $__currentLoopData = $incomeChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeName => $subtypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <optgroup label="<?php echo e($typeName); ?>">
                <?php $__currentLoopData = $subtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtypeId => $subtypeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option disabled style="color: #000; font-weight: bold;"><?php echo e($subtypeData['account_name']); ?></option>
                    <?php $__currentLoopData = $subtypeData['chart_of_accounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartOfAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($chartOfAccount['id']); ?>" <?php echo e($productService->sale_chartaccount_id == $chartOfAccount['id'] ? 'selected' : ''); ?>>
                            &nbsp;&nbsp;&nbsp;<?php echo e($chartOfAccount['account_name']); ?>

                        </option>
                        <?php $__currentLoopData = $subtypeData['subAccounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($chartOfAccount['id'] == $subAccount['parent']): ?>
                            <option value="<?php echo e($subAccount['id']); ?>" class="ms-5" <?php echo e($productService->sale_chartaccount_id == $subAccount['id'] ? 'selected' : ''); ?>> &nbsp; &nbsp;&nbsp;&nbsp; <?php echo e(' - '. $subAccount['account_name']); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </optgroup>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group col-md-6">
    <?php echo e(Form::label('expense_chartaccount_id', __('Expense Account'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
    <select name="expense_chartaccount_id" class="form-control" required>
        <option value="">Select Chart of Account</option>
        <?php $__currentLoopData = $expenseChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeName => $subtypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <optgroup label="<?php echo e($typeName); ?>">
                <?php $__currentLoopData = $subtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtypeId => $subtypeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option disabled style="color: #000; font-weight: bold;"><?php echo e($subtypeData['account_name']); ?></option>
                    <?php $__currentLoopData = $subtypeData['chart_of_accounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartOfAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($chartOfAccount['id']); ?>" <?php echo e($productService->expense_chartaccount_id == $chartOfAccount['id'] ? 'selected' : ''); ?>>
                            &nbsp;&nbsp;&nbsp;<?php echo e($chartOfAccount['account_name']); ?>

                        </option>
                        <?php $__currentLoopData = $subtypeData['subAccounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($chartOfAccount['id'] == $subAccount['parent']): ?>
                            <option value="<?php echo e($subAccount['id']); ?>" class="ms-5" <?php echo e($productService->expense_chartaccount_id == $subAccount['id'] ? 'selected' : ''); ?>> &nbsp; &nbsp;&nbsp;&nbsp; <?php echo e(' - '. $subAccount['account_name']); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </optgroup>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\setting\add_column_table.blade.php ENDPATH**/ ?>
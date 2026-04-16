<?php $__env->startSection('page-title', __('Add asset')); ?>
<?php $__env->startSection('page-breadcrumb', 'Assets,Create'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('assets.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Asset name')); ?></label>
                        <input type="text" name="asset_name" value="<?php echo e(old('asset_name')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Asset code')); ?></label>
                        <input type="text" name="asset_code" value="<?php echo e(old('asset_code')); ?>" class="form-control">
                        <small class="text-muted"><?php echo e(__('Leave empty to auto generate')); ?></small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Asset tag')); ?></label>
                        <input type="text" name="asset_tag" value="<?php echo e(old('asset_tag')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Category')); ?></label>
                        <select name="category" class="form-select">
                            <option value=""><?php echo e(__('Select')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categoryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>" <?php echo e(old('category') == $category ? 'selected' : ''); ?>>
                                    <?php echo e($category); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Asset type')); ?></label>
                        <input type="text" name="asset_type" value="<?php echo e(old('asset_type')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Serial number')); ?></label>
                        <input type="text" name="serial_number" value="<?php echo e(old('serial_number')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Location')); ?></label>
                        <input type="text" name="location" value="<?php echo e(old('location')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Condition')); ?></label>
                        <input type="text" name="condition" value="<?php echo e(old('condition')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Acquired at')); ?></label>
                        <input type="date" name="acquired_at" value="<?php echo e(old('acquired_at')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Warranty expires')); ?></label>
                        <input type="date" name="warranty_expires_at" value="<?php echo e(old('warranty_expires_at')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Quantity')); ?></label>
                        <input type="number" name="quantity" value="<?php echo e(old('quantity', 0)); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Available quantity')); ?></label>
                        <input type="number" name="available_quantity" value="<?php echo e(old('available_quantity')); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Branch')); ?></label>
                        <select name="branch_id" class="form-select">
                            <option value=""><?php echo e(__('Any')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('branch_id') == $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Department')); ?></label>
                        <select name="department_id" class="form-select">
                            <option value=""><?php echo e(__('Any')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('department_id') == $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Status')); ?></label>
                        <select name="status" class="form-select">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e(old('status') == $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Assigned to')); ?></label>
                        <select name="assigned_to" class="form-select">
                            <option value=""><?php echo e(__('None')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $assignableUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('assigned_to') == $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo e(__('Notes')); ?></label>
                        <textarea name="notes" rows="3" class="form-control"><?php echo e(old('notes')); ?></textarea>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary"><?php echo e(__('Save asset')); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\assets\create.blade.php ENDPATH**/ ?>
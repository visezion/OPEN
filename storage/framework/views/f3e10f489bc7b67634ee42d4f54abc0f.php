<?php $__env->startSection('page-title', __('Edit maintenance schedule')); ?>
<?php $__env->startSection('page-breadcrumb', 'Maintenance,Edit'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('maintenance.update', $schedule)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Asset name')); ?></label>
                        <input type="text" name="asset_name" value="<?php echo e(old('asset_name', $schedule->asset_name)); ?>"
                            class="form-control <?php $__errorArgs = ['asset_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['asset_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Asset code')); ?></label>
                        <input type="text" name="asset_code" value="<?php echo e(old('asset_code', $schedule->asset_code)); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Category')); ?></label>
                        <select name="category" class="form-select">
                            <?php $__currentLoopData = $categoryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>" <?php echo e(old('category', $schedule->category) == $category ? 'selected' : ''); ?>>
                                    <?php echo e($category); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Branch')); ?></label>
                        <select name="branch_id" class="form-select">
                            <option value=""><?php echo e(__('Headquarters')); ?></option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('branch_id', $schedule->branch_id) == $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Department')); ?></label>
                        <select name="department_id" class="form-select">
                            <option value=""><?php echo e(__('General')); ?></option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('department_id', $schedule->department_id) == $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Priority')); ?></label>
                        <select name="priority" class="form-select">
                            <?php $__currentLoopData = $priorityOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e(old('priority', $schedule->priority) == $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Frequency')); ?></label>
                        <select name="frequency_type" class="form-select">
                            <?php $__currentLoopData = $frequencyOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e(old('frequency_type', $schedule->frequency_type) == $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Frequency value')); ?></label>
                        <input type="number" name="frequency_value" class="form-control"
                            value="<?php echo e(old('frequency_value', $schedule->frequency_value)); ?>">
                        <small class="text-muted"><?php echo e(__('Number of units for the selected frequency')); ?></small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Start date')); ?></label>
                        <input type="date" name="start_date" class="form-control"
                            value="<?php echo e(old('start_date', optional($schedule->start_date)->toDateString())); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('End date')); ?></label>
                        <input type="date" name="end_date" class="form-control"
                            value="<?php echo e(old('end_date', optional($schedule->end_date)->toDateString())); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Estimated duration (minutes)')); ?></label>
                        <input type="number" name="estimated_duration_minutes" class="form-control"
                            value="<?php echo e(old('estimated_duration_minutes', $schedule->estimated_duration_minutes)); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Estimated cost')); ?></label>
                        <input type="number" step="0.01" name="estimated_cost" class="form-control"
                            value="<?php echo e(old('estimated_cost', $schedule->estimated_cost)); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Location')); ?></label>
                        <input type="text" name="location" class="form-control"
                            value="<?php echo e(old('location', $schedule->location)); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Assigned to')); ?></label>
                        <select name="assigned_to" class="form-select">
                            <option value=""><?php echo e(__('Unassigned')); ?></option>
                            <?php $__currentLoopData = $assignableUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('assigned_to', $schedule->assigned_to) == $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Status')); ?></label>
                        <select name="status" class="form-select">
                            <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e(old('status', $schedule->status) == $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary"><?php echo e(__('Update schedule')); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\maintenance\edit.blade.php ENDPATH**/ ?>
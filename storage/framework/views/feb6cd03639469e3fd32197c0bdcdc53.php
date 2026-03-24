<?php
    $isEdit = $smartTag->exists;
    $action = $isEdit
        ? route('churchly.smart-tags.update', $smartTag->id)
        : route('churchly.smart-tags.store');
    $definition = old(
        'definition_json',
        $smartTag->definition ? json_encode($smartTag->definition, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : "[\n    {\n        \"type\": \"attendance_count\",\n        \"operator\": \">=\",\n        \"value\": 3,\n        \"days\": 30\n    }\n]"
    );
?>

<?php $__env->startSection('page-title', $isEdit ? __('Edit Smart Tag') : __('Create Smart Tag')); ?>
<?php $__env->startSection('page-breadcrumb', __('Smart Tags')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchly.smart-tags.index')); ?>" class="btn btn-sm btn-light">
        <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to list')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="<?php echo e($action); ?>">
                    <?php echo csrf_field(); ?>
                    <?php if($isEdit): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Name')); ?></label>
                        <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $smartTag->name)); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Description')); ?></label>
                        <textarea name="description" class="form-control" rows="2"><?php echo e(old('description', $smartTag->description)); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Definition (JSON)')); ?></label>
                        <textarea name="definition_json" class="form-control" rows="12" required><?php echo e($definition); ?></textarea>
                        <small class="text-muted d-block mt-2">
                            <?php echo e(__('Each rule is an object within the JSON array. Supported types:')); ?>

                            <ul class="small mb-0">
                                <li><code>attendance_count</code> – <?php echo e(__('Fields: operator, value, days, status')); ?></li>
                                <li><code>giving_gap_days</code> – <?php echo e(__('Fields: operator, value')); ?></li>
                                <li><code>in_department</code> – <?php echo e(__('Fields: department_ids[]')); ?></li>
                                <li><code>in_branch</code> – <?php echo e(__('Fields: branch_ids[]')); ?></li>
                                <li><code>membership_status</code> – <?php echo e(__('Fields: statuses[]')); ?></li>
                            </ul>
                        </small>
                        <?php $__errorArgs = ['definition_json'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', $smartTag->is_active ?? true) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_active"><?php echo e(__('Tag is active')); ?></label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary"><?php echo e($isEdit ? __('Save changes') : __('Create tag')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\smart-tags\form.blade.php ENDPATH**/ ?>
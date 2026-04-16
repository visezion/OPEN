

<?php $__env->startSection('page-title'); ?>
    Edit Custom Field
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('formsetup.index')); ?>">Custom Fields</a></li>
    <li class="breadcrumb-item active">Edit</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-3">
        <?php echo $__env->make('churchly::layouts.churchly_setup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <div class="col-sm-9">
<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('formsetup.update', $field->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label>Field Key</label>
                <input type="text" name="field_key" class="form-control" value="<?php echo e($field->field_key); ?>" required>
            </div>

            <div class="mb-3">
                <label>Field Label</label>
                <input type="text" name="field_label" class="form-control" value="<?php echo e($field->field_label); ?>" required>
            </div>

            <div class="mb-3">
                <label>Field Type</label>
                <select name="field_type" class="form-control" required>
                    <option value="text" <?php if($field->field_type=='text'): ?> selected <?php endif; ?>>Text</option>
                    <option value="textarea" <?php if($field->field_type=='textarea'): ?> selected <?php endif; ?>>Textarea</option>
                    <option value="date" <?php if($field->field_type=='date'): ?> selected <?php endif; ?>>Date</option>
                    <option value="drupdown" <?php if($field->field_type=='drupdown'): ?> selected <?php endif; ?>>Drupdown</option>
                    <option value="file" <?php if($field->field_type=='file'): ?> selected <?php endif; ?>>File Upload</option>
                    <option value="checkbox" <?php if($field->field_type=='checkbox'): ?> selected <?php endif; ?>>Checkbox</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Default Value (Optional)</label>
                <input type="text" name="field_value" class="form-control" value="<?php echo e($field->field_value); ?>">
                <small class="form-text text-muted">For select/checkbox, use comma-separated options (e.g., Male,Female)</small>
            </div>

            <div class="mb-3">
                <label>Display Order</label>
                <input type="number" name="order" class="form-control" value="<?php echo e($field->order ?? 0); ?>">
            </div>

            <button type="submit" class="btn btn-success">Update Field</button>
            <a href="<?php echo e(route('formsetup.index')); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\setup\editfield.blade.php ENDPATH**/ ?>
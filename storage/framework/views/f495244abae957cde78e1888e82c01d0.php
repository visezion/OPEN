

<?php
    $isEdit = $skill->exists;
    $route = $isEdit
        ? ['churchly.volunteer-skills.update', $skill->id]
        : ['churchly.volunteer-skills.store'];
    $method = $isEdit ? 'PUT' : 'POST';
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e($isEdit ? __('Edit Skill') : __('Add Skill')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <a href="<?php echo e(route('churchly.volunteer-skills.index')); ?>"><?php echo e(__('Skills')); ?></a> /
    <?php echo e($isEdit ? __('Edit') : __('Create')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchly.volunteer-skills.index')); ?>"
       class="btn btn-sm btn-light">
        <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to list')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <?php echo e($isEdit ? __('Update Skill') : __('Create Skill')); ?>

                    </h5>
                </div>
                <div class="card-body">
                    <?php echo Form::model($skill, ['route' => $route, 'method' => $method]); ?>

                        <div class="mb-3">
                            <?php echo Form::label('name', __('Skill name'), ['class' => 'form-label']); ?>

                            <?php echo Form::text('name', old('name', $skill->name), ['class' => 'form-control', 'required' => true]); ?>

                        </div>
                        <div class="mb-3">
                            <?php echo Form::label('category', __('Category'), ['class' => 'form-label']); ?>

                            <?php echo Form::text('category', old('category', $skill->category), ['class' => 'form-control', 'placeholder' => __('Vocals, Media, Children...')]); ?>

                        </div>
                        <div class="mb-3">
                            <?php echo Form::label('description', __('Description'), ['class' => 'form-label']); ?>

                            <?php echo Form::textarea('description', old('description', $skill->description), ['class' => 'form-control', 'rows' => 3]); ?>

                        </div>
                        <div class="form-check form-switch mb-4">
                            <?php echo Form::checkbox('is_active', 1, old('is_active', $skill->is_active ?? true), ['class' => 'form-check-input', 'id' => 'is_active']); ?>

                            <?php echo Form::label('is_active', __('Skill is active'), ['class' => 'form-check-label']); ?>

                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('churchly.volunteer-skills.index')); ?>" class="btn btn-light"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-primary">
                                <?php echo e($isEdit ? __('Save changes') : __('Create skill')); ?>

                            </button>
                        </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\volunteers\skills\form.blade.php ENDPATH**/ ?>
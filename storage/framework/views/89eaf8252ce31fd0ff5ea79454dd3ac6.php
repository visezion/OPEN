

<?php $__env->startSection('page-title', __('Edit Church Document Type')); ?>
<?php $__env->startSection('page-breadcrumb', __('Edit Church Document Type')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-body">
                <?php echo Form::model($documentType, ['route' => ['church.document_types.update', $documentType->id], 'method' => 'PUT', 'class' => 'needs-validation']); ?>

                    <div class="form-group mb-3">
                        <?php echo Form::label('name', __('Document Name'), ['class' => 'form-label']); ?>

                        <?php echo Form::text('name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => __('Enter document type name')]); ?>

                    </div>

                    <div class="form-group mb-3">
                        <?php echo Form::label('is_required', __('Is Required'), ['class' => 'form-label']); ?>

                        <?php echo Form::select('is_required', ['1' => __('Yes'), '0' => __('No')], $documentType->is_required, ['class' => 'form-control select']); ?>

                    </div>

                    <div class="text-end">
                        <a href="<?php echo e(route('church.document_types.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                        <button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
                    </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\document_types\edit.blade.php ENDPATH**/ ?>
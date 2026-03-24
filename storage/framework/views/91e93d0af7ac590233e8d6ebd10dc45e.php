
                <?php echo e(Form::open(['route' => 'churchly.departments.store', 'method' => 'POST', 'class' => 'needs-validation', 'novalidate'])); ?>

                <div class="modal-body">        
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <?php echo e(Form::label('name', __('Department Name'), ['class' => 'form-label'])); ?> <?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter Department Name')])); ?>

                        </div>

                        <div class="form-group mb-3">
                            <?php echo e(Form::label('branch_id', __('Branch'), ['class' => 'form-label'])); ?> <?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::select('branch_id', $branches, null, ['class' => 'form-control select', 'required', 'placeholder' => __('Select Branch')])); ?>

                         </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="text-end">
                    <a href="<?php echo e(route('churchly.departments.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Create Department')); ?></button>
              
            </div>
        </div>

                <?php echo e(Form::close()); ?>

            <?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\departments\create.blade.php ENDPATH**/ ?>
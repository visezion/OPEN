<div class="<?php echo e($divClass); ?>">
    <div class="form-group">
        <?php echo e(Form::label($name,$label,['class'=>'form-label'])); ?><?php if($required): ?> <?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
<?php endif; ?> <?php endif; ?>
        <?php echo e(Form::text($name,$value,array('class'=>$class,'placeholder'=>$placeholder,'pattern' => '^\+\d{1,3}\d{9,13}$','id'=>$id,'required'=>$required))); ?>

        <div class=" text-sm text-danger mt-1">
            <?php echo e(__('Please use with country code. (ex. +91)')); ?>

        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\components\mobile.blade.php ENDPATH**/ ?>
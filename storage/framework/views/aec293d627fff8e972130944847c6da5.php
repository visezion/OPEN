

<?php echo e(Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT'))); ?>


    <div class="form-group">
        <?php echo e(Form::label('name',__('Name'),array('class'=>'col-form-label'))); ?>

        <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Permission Name')))); ?>

        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="form-group">
        <?php echo e(Form::label('name',__('Module'),array('class'=>'col-form-label'))); ?>

        <select class="form-control" data-trigger name="module" id="choices-single-default" placeholder="This is a search placeholder">
            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($module); ?>"><?php echo e($module); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="text-end">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <?php echo e(Form::submit(__('Create'),array('class'=>'btn  btn-primary'))); ?>

    </div>
<?php echo e(Form::close()); ?>

<script>
 var multipleCancelButton = new Choices(
        '#choices-single-defaultlq', {
            removeItemButton: true,
        }
        );

</script>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\permission\edit.blade.php ENDPATH**/ ?>


<?php $__env->startSection('page-title', __('Link Events to Discipleship Stage')); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm p-4">
    <form method="POST" action="<?php echo e(route('churchly.discipleship.stage_events.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label"><?php echo e(__('Select Stage')); ?></label>
            <select name="stage_id" class="form-control" required>
                <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"><?php echo e(__('Select Event')); ?></label>
            <select name="event_id" class="form-control" required>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($event->id); ?>"><?php echo e($event->title); ?> (<?php echo e($event->date); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success"><?php echo e(__('Link Event')); ?></button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\stage_events\create.blade.php ENDPATH**/ ?>
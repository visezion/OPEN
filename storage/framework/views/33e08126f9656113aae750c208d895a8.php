<?php $__env->startSection('page-title', __('Maintenance calendar')); ?>
<?php $__env->startSection('page-breadcrumb', 'Maintenance,Calendar'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card mb-3">
        <div class="card-body d-flex flex-wrap gap-3">
            <div>
                <h5 class="mb-1"><?php echo e(__('Upcoming maintenance')); ?></h5>
                <p class="text-muted"><?php echo e(__('Events plotted by due date and status')); ?></p>
            </div>
            <a href="<?php echo e(route('maintenance.index')); ?>" class="btn btn-outline-secondary ms-auto"><?php echo e(__('Back to list')); ?></a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-3">
        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-secondary">
                    <div class="card-body">
                        <h6 class="card-title"><?php echo e($event['title']); ?></h6>
                        <p class="card-text">
                            <strong><?php echo e(\Carbon\Carbon::parse($event['start'])->format('M d, Y')); ?></strong><br>
                            <span class="text-muted"><?php echo e(ucfirst($event['status'])); ?></span>
                        </p>
                        <a href="<?php echo e($event['url']); ?>" class="stretched-link"><?php echo e(__('View schedule')); ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($events->isEmpty()): ?>
        <div class="text-center text-muted mt-4">
            <?php echo e(__('No events scheduled yet. Begin by creating a maintenance plan.')); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\maintenance\calendar.blade.php ENDPATH**/ ?>
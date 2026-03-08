

<?php $__env->startSection('page-title', __('Attendance Analytics Dashboard')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">


<?php if($member->qr_code): ?>
    <div class="text-center">
        <img src="<?php echo e(asset('storage/' . $member->qr_code)); ?>" 
             alt="QR Code for <?php echo e($member->name); ?>" 
             class="img-fluid rounded shadow-sm" style="max-width:200px;">
        <p class="small text-muted mt-2"><?php echo e(__('Scan this code to check in')); ?></p>
    </div>
<?php else: ?>
    <form method="POST" action="<?php echo e(route('churchly.members.generate_qr', $member->id)); ?>">
        <?php echo csrf_field(); ?>
        <button class="btn btn-outline-primary btn-sm">
            <i class="ti ti-qrcode"></i> <?php echo e(__('Generate QR Code')); ?>

        </button>
    </form>
<?php endif; ?>


    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h6><?php echo e(__('Attendance Trend')); ?></h6>
            <canvas id="trendChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h6><?php echo e(__('Absentee Alerts (Last 3 Weeks)')); ?></h6>
            <ul>
                <?php $__currentLoopData = $absentees->where('recent_absences','>=',3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($m->name); ?> - <?php echo e($m->recent_absences); ?> absences</li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('trendChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($trend->pluck('day')); ?>,
            datasets: [{
                label: 'Attendance',
                data: <?php echo json_encode($trend->pluck('total')); ?>,
                borderColor: 'blue',
                fill: false
            }]
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\attendance\reports\dashboard.blade.php ENDPATH**/ ?>
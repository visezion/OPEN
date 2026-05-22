

<?php $__env->startSection('page-title', 'SMS Gateways'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Add SMS Gateway</div>
    <div class="card-body">
        <form action="<?php echo e(route('sms-gateway.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-2">
                <div class="col-md-3">
                    <input name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-3">
                    <select name="driver" class="form-control" required>
                        <option value="twilio">Twilio</option>
                        <option value="zender">Zender</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input name="api_key" class="form-control" placeholder="API Key">
                </div>
                <div class="col-md-3">
                    <input name="url" class="form-control" placeholder="Zender URL">
                </div>
                <div class="col-12 mt-2">
                    <button class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">Gateways</div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th>Name</th><th>Driver</th><th>Actions</th></tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($g->name); ?></td>
                    <td><?php echo e(ucfirst($g->driver)); ?></td>
                    <td>
                        <form action="<?php echo e(route('sms-gateway.destroy', $g->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\sms\index.blade.php ENDPATH**/ ?>
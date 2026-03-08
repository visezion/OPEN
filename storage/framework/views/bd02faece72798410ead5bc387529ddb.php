

<?php $__env->startSection('page-title', __('Discipleship Approvers')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Assign Approver Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="ti ti-user-check text-primary"></i> <?php echo e(__('Assign New Approver')); ?>

            </h5>

            <form method="POST" action="<?php echo e(route('discipleship.approvers.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <!-- Scope -->
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Scope')); ?></label>
                        <select name="scope" id="scopeSelect" class="form-select" required>
                            <option value="branch"><?php echo e(__('Branch')); ?></option>
                            <option value="department"><?php echo e(__('Department')); ?></option>
                            <option value="stage"><?php echo e(__('Stage')); ?></option>
                        </select>
                    </div>

                    <!-- Reference -->
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Reference')); ?></label>
                        <select name="reference_id" id="referenceSelect" class="form-select" required>
                            
                        </select>
                    </div>

                    <!-- Approver User -->
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Approver')); ?></label>
                        <select name="user_id" class="form-select" required>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Submit -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="ti ti-plus"></i> <?php echo e(__('Assign')); ?>

                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Approvers List -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="ti ti-users text-success"></i> <?php echo e(__('Assigned Approvers')); ?>

            </h5>

            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th><?php echo e(__('Scope')); ?></th>
                        <th><?php echo e(__('Reference')); ?></th>
                        <th><?php echo e(__('Approver')); ?></th>
                        <th><?php echo e(__('Actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $approvers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $approver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(ucfirst($approver->scope)); ?></td>
                            <td>
                                <?php if($approver->scope == 'branch'): ?>
                                    <?php echo e(optional($branches->where('id',$approver->reference_id)->first())->name ?? $approver->reference_id); ?>

                                <?php elseif($approver->scope == 'department'): ?>
                                    <?php echo e(optional($departments->where('id',$approver->reference_id)->first())->name ?? $approver->reference_id); ?>

                                <?php elseif($approver->scope == 'stage'): ?>
                                    <?php echo e(optional($stages->where('id',$approver->reference_id)->first())->name ?? $approver->reference_id); ?>

                                <?php endif; ?>
                            </td>
                            <td><?php echo e($approver->user->name); ?></td>
                            <td>
                                <form method="POST" action="<?php echo e(route('discipleship.approvers.destroy', $approver->id)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i> <?php echo e(__('Remove')); ?>

                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                <i class="ti ti-inbox"></i> <?php echo e(__('No approvers assigned yet.')); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scopeSelect = document.getElementById('scopeSelect');
        const referenceSelect = document.getElementById('referenceSelect');

        const branches = <?php echo json_encode($branches, 15, 512) ?>;
        const departments = <?php echo json_encode($departments, 15, 512) ?>;
        const stages = <?php echo json_encode($stages, 15, 512) ?>;

        function populateReferences(scope) {
            referenceSelect.innerHTML = '';

            let options = [];
            if (scope === 'branch') {
                options = branches.map(b => ({id: b.id, name: b.name}));
            } else if (scope === 'department') {
                options = departments.map(d => ({id: d.id, name: d.name}));
            } else if (scope === 'stage') {
                options = stages.map(s => ({id: s.id, name: s.name}));
            }

            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt.id;
                option.textContent = opt.name;
                referenceSelect.appendChild(option);
            });
        }

        scopeSelect.addEventListener('change', function () {
            populateReferences(this.value);
        });

        // init with branch
        populateReferences(scopeSelect.value);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\approvers\index.blade.php ENDPATH**/ ?>
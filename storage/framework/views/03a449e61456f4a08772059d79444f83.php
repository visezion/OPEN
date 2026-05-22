
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <i class="ti ti-check me-1"></i> <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <i class="ti ti-alert-circle me-1"></i> <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->startSection('page-title', 'Preview Imported Members'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Preview Cleaned Data</h4>
        <span class="text-muted small">
            <span class="badge bg-success">Green = Exact</span>
            <span class="badge bg-warning">Yellow = Alias / Fuzzy</span>
            <span class="badge bg-danger">Red = Unknown</span>
        </span>
    </div>

    <div class="card-body">
        <form action="<?php echo e(route('members.import.confirm')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Branch</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Role</th>
                            <th>Date Joined</th>
                            <th>Emergency Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cleanRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php echo e($row['name']); ?>

                                    <input type="hidden" name="rows[<?php echo e($i); ?>][name]" value="<?php echo e($row['name']); ?>">
                                </td>
                                <td>
                                    <?php echo e($row['email']); ?>

                                    <input type="hidden" name="rows[<?php echo e($i); ?>][email]" value="<?php echo e($row['email']); ?>">
                                </td>
                                <td>
                                    <?php echo e($row['phone']); ?>

                                    <input type="hidden" name="rows[<?php echo e($i); ?>][phone]" value="<?php echo e($row['phone']); ?>">
                                </td>

                                
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row['branch']['name'] === 'Unknown'): ?>
                                        <select name="rows[<?php echo e($i); ?>][branch_id]" class="form-select form-select-sm" required>
                                            <option value="">-- Select Branch --</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                        <span class="badge bg-danger">Unknown</span>
                                    <?php else: ?>
                                        <?php echo e($row['branch']['name']); ?>

                                        <input type="hidden" name="rows[<?php echo e($i); ?>][branch_id]" value="<?php echo e($row['branch']['id']); ?>">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                
                                <td>
                                    <?php echo e($row['department']['name']); ?>

                                    <input type="hidden" name="rows[<?php echo e($i); ?>][department_id]" value="<?php echo e($row['department']['id']); ?>">
                                    <span class="badge 
                                        <?php if($row['department']['confidence'] == 100): ?> bg-success
                                        <?php elseif($row['department']['confidence'] >= 70): ?> bg-warning
                                        <?php else: ?> bg-danger <?php endif; ?>">
                                        <?php echo e(ucfirst($row['department']['matchType'])); ?>

                                    </span>
                                </td>

                                
                                <td>
                                    <?php echo e($row['designation']['name']); ?>

                                    <input type="hidden" name="rows[<?php echo e($i); ?>][designation_id]" value="<?php echo e($row['designation']['id']); ?>">
                                    <span class="badge 
                                        <?php if($row['designation']['confidence'] == 100): ?> bg-success
                                        <?php elseif($row['designation']['confidence'] >= 70): ?> bg-warning
                                        <?php else: ?> bg-danger <?php endif; ?>">
                                        <?php echo e(ucfirst($row['designation']['matchType'])); ?>

                                    </span>
                                </td>

                                
                                <td>
                                    <select name="rows[<?php echo e($i); ?>][role_id]" 
                                            class="form-select form-select-sm" required>
                                        <option value="">-- Select Role --</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!in_array($name, ['Super Admin', 'Company'])): ?>
                                                <option value="<?php echo e($id); ?>" 
                                                    <?php echo e($row['role']['id'] == $id ? 'selected' : ''); ?>>
                                                    <?php echo e($name); ?>

                                                </option>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row['role']['name'] === 'Unknown'): ?>
                                        <span class="badge bg-danger">Unknown</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                
                                <td>
                                    <?php echo e($row['church_doj']); ?>

                                    <input type="hidden" name="rows[<?php echo e($i); ?>][church_doj]" value="<?php echo e($row['church_doj']); ?>">
                                </td>

                                
                                <td>
                                    <?php echo e($row['emergency_contact']); ?> <br>
                                    <small class="text-muted"><?php echo e($row['emergency_phone']); ?></small>
                                    <input type="hidden" name="rows[<?php echo e($i); ?>][emergency_contact]" value="<?php echo e($row['emergency_contact']); ?>">
                                    <input type="hidden" name="rows[<?php echo e($i); ?>][emergency_phone]" value="<?php echo e($row['emergency_phone']); ?>">
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="<?php echo e(route('members.import.modal')); ?>" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Back
                </a>
                <div>
                    <a href="<?php echo e(route('members.index')); ?>" class="btn btn-light me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> Confirm & Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\import_preview.blade.php ENDPATH**/ ?>
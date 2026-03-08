

<?php $__env->startSection('page-title', 'Preview Imported Members'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h4>Preview Cleaned Data</h4>
        <p class="text-muted">Check mappings. "Unknown" means not found in DB.</p>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('members.import.confirm')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th><th>Email</th><th>Phone</th>
                        <th>Branch</th><th>Department</th><th>Designation</th><th>Role</th>
                        <th>Date Joined</th><th>Emergency Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cleanRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row['name']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td><?php echo e($row['phone']); ?></td>

                            
                            <td class="<?php echo e($row['branch_name'] === 'Unknown' ? 'table-danger' : ''); ?>">
                                <?php echo e($row['branch_name']); ?>

                            </td>
                            <td class="<?php echo e($row['department_name'] === 'Unknown' ? 'table-danger' : ''); ?>">
                                <?php echo e($row['department_name']); ?>

                            </td>
                            <td class="<?php echo e($row['designation_name'] === 'Unknown' ? 'table-danger' : ''); ?>">
                                <?php echo e($row['designation_name']); ?>

                            </td>
                            <td class="<?php echo e($row['role_name'] === 'Unknown' ? 'table-danger' : ''); ?>">
                                <?php echo e($row['role_name']); ?>

                            </td>

                            <td><?php echo e($row['church_doj']); ?></td>
                            <td><?php echo e($row['emergency_contact']); ?> (<?php echo e($row['emergency_phone']); ?>)</td>
                        </tr>

                        
                        <input type="hidden" name="rows[]" value="<?php echo e(json_encode($row)); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Confirm & Upload</button>
            <a href="<?php echo e(route('members.file')); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\import_preview2.blade.php ENDPATH**/ ?>
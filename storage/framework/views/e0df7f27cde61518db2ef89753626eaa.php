

<?php $__env->startSection('page-title', __('Church Members')); ?>

<?php $__env->startSection('page-action'); ?>
<div class="d-flex flex-wrap gap-2">
     <?php if (app('laratrust')->hasPermission('user manage')) : ?>
            <a href="<?php echo e(route('users.list.view')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Verify Member')); ?>"
                class="btn btn-sm btn-primary btn-icon me-2">
                <i class="ti ti-user-check"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('user logs history')) : ?>
        <a href="<?php echo e(route('users.userlog.history')); ?>" class="btn btn-sm btn-primary me-2" data-bs-toggle="tooltip"
            data-bs-placement="top" title="<?php echo e(__('User Logs History')); ?>">
              <i class="ti ti-list"></i>
          
        </a>
    <?php endif; // app('laratrust')->permission ?>

    
    <button class="btn btn-sm btn-primary me-2" id="openImportModal" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Import Members')); ?>">
        <i class="ti ti-file-import"></i>
    </button>


    
    <?php if (app('laratrust')->hasPermission('church_member create')) : ?>
        <a href="<?php echo e(route('churchly.members.create')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Add Members')); ?>">
            <i class="ti ti-plus"></i> 
        </a>
    <?php endif; // app('laratrust')->permission ?>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ti ti-users text-primary"></i> <?php echo e(__('Church Members')); ?>

                </h5>
            </div>
            <div class="card-body">
                
                <form method="GET" action="<?php echo e(route('members.index')); ?>" class="row g-2 mb-3">
                    <div class="col-md-5">
                        <select name="branch_id" class="form-select">
                            <option value=""><?php echo e(__('All Branches')); ?></option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(request('branch_id') == $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                            class="form-control" placeholder="<?php echo e(__('Search by Name or Phone')); ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i> <?php echo e(__('Filter')); ?>

                        </button>
                    </div>
                </form>

                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><?php echo e(__('No')); ?></th>
                                <th><?php echo e(__('Member ID')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Phone')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Departments')); ?></th>
                                <th><?php echo e(__('Date of Joining')); ?></th>
                                <th class="text-center"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($loop->iteration + ($members->firstItem() - 1)); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('members.show', Crypt::encrypt($member->id))); ?>"
                                           class="btn btn-outline-primary btn-sm">
                                           #<?php echo e($member->member_id); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($member->name ?? '-'); ?></td>
                                    <td><?php echo e($member->phone ?? '-'); ?></td>
                                    <td><?php echo e($member->email ?? '-'); ?></td>
                                    <td><?php echo e($member->branch?->name ?? '-'); ?></td>
                                    <td><?php echo e($member->departments->pluck('name')->implode(', ') ?: '-'); ?></td>
                                    <td><?php echo e($member->church_doj?->format('d M Y') ?? '-'); ?></td>
                                    <td class="text-center">
                                        <?php echo $__env->make('churchly::members.button', ['member' => $member], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        <?php echo e(__('No members found.')); ?>

                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($members->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>


<div id="importModalContainer"></div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('openImportModal').addEventListener('click', function() {
    fetch("<?php echo e(route('members.import.modal')); ?>")
        .then(response => response.text())
        .then(html => {
            // Insert modal HTML into container
            document.getElementById('importModalContainer').innerHTML = html;

            // Initialize Bootstrap modal
            const modal = new bootstrap.Modal(document.getElementById('importModal'));
            modal.show();
        })
        .catch(error => console.error('Error loading modal:', error));
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\index.blade.php ENDPATH**/ ?>


<?php
    $company_settings = getCompanyAllSetting();
    $designation_name = $company_settings['churchly_designation_name'] ?? __('Designation');
    $branch_name = $company_settings['churchly_branch_name'] ?? __('Branch');
    $department_name = $company_settings['churchly_department_name'] ?? __('Department');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e($designation_name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Church Designation')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <?php if (app('laratrust')->hasPermission('church_designation create')) : ?>
        <a href="javascript:void(0)"
           class="btn btn-sm btn-primary"
           data-ajax-popup="true"
           data-size="md"
           data-title="<?php echo e(__('Create ' . $designation_name)); ?>"
           data-url="<?php echo e(route('churchdesignation.create')); ?>"
           data-toggle="tooltip"
           title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
<a href="<?php echo e(route('churchdesignation.create')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Go Back">
    <i class="ti ti-arrow-back-up me-2"></i>
</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-3">
        <?php echo $__env->make('churchly::layouts.churchly_setup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th><?php echo e($designation_name); ?></th>
                                <th><?php echo e($department_name); ?></th>
                                <th><?php echo e($branch_name); ?></th>
                                <th width="120px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($designation->name ?? '-'); ?></td>
                                    <td><?php echo e($designation->department->name ?? '-'); ?></td>
                                    <td><?php echo e($designation->branch->name ?? '-'); ?></td>
                                    <td class="Action text-center">
                                        <div class="d-flex justify-content-center">
                                            <?php if (app('laratrust')->hasPermission('church_designation edit')) : ?>
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm bg-info text-white mx-1"
                                                   data-url="<?php echo e(route('churchdesignation.edit', $designation->id)); ?>"
                                                   data-ajax-popup="true"
                                                   data-size="md"
                                                   data-title="<?php echo e(__('Edit ' . $designation_name)); ?>"
                                                   data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                            <?php endif; // app('laratrust')->permission ?>

                                            <?php if (app('laratrust')->hasPermission('church_designation delete')) : ?>
                                                <?php echo Form::open([
                                                    'route' => ['churchdesignation.destroy', $designation->id],
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline m-0 p-0',
                                                    'id' => 'delete-form-' . $designation->id
                                                ]); ?>

                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm bg-danger text-white mx-1 show_confirm"
                                                       data-bs-toggle="tooltip"
                                                       title="<?php echo e(__('Delete')); ?>"
                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                       data-text="<?php echo e(__('This action cannot be undone. Do you want to continue?')); ?>"
                                                       data-confirm-yes="delete-form-<?php echo e($designation->id); ?>">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                <?php echo Form::close(); ?>

                                            <?php endif; // app('laratrust')->permission ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
    <div class="card">
      <div class="container"><br>
        <h4>Create New Designation</h4>

        <?php echo Form::open(['route' => 'churchdesignation.store', 'method' => 'POST']); ?>

            <div class="row">
                <div class="col-md-12">

                    
                    <div class="form-group mb-3">
                        <?php echo Form::label('name', __('Designation Name')); ?>

                        <?php echo Form::text('name', old('name'), [
                            'class' => 'form-control',
                            'required' => true,
                            'placeholder' => __('Enter designation name')
                        ]); ?>

                    </div>

                    
                    <div class="form-group mb-3">
                        <?php echo Form::label('branch_id', __('Branch')); ?>

                        <?php echo Form::select('branch_id', $branches, null, [
                            'class' => 'form-control',
                            'required' => true,
                            'placeholder' => __('Select Branch'),
                            'id' => 'branch-select'
                        ]); ?>

                    </div>

                    
                    <div class="form-group mb-3">
                        <?php echo Form::label('department_id', __('Department')); ?>

                        <?php echo Form::select('department_id', [], null, [
                            'class' => 'form-control',
                            'required' => true,
                            'placeholder' => __('Select Department'),
                            'id' => 'department-select',
                            'disabled' => true
                        ]); ?>

                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="<?php echo e(route('churchdesignation.index')); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        <?php echo Form::close(); ?>

    </div> <br>
    </div>
    </div>
    <br>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const getDepartmentsUrl = "<?php echo e(route('departments.byBranch')); ?>";
        const branchSelect = document.getElementById('branch-select');
        const departmentSelect = document.getElementById('department-select');

        branchSelect.addEventListener('change', function () {
            const branchId = this.value;

            // Reset
            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            departmentSelect.disabled = true;

            if (!branchId) return;

            fetch(`${getDepartmentsUrl}?branch=${branchId}`)
                .then(res => res.json())
                .then(data => {
                    console.log("Departments response:", data);

                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        departmentSelect.appendChild(option);
                    });

                    if (Object.keys(data).length > 0) {
                        departmentSelect.disabled = false;
                    }
                })
                .catch(err => console.error("Error loading departments:", err));
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\designation\index.blade.php ENDPATH**/ ?>
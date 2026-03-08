

<?php
    $company_settings = getCompanyAllSetting();
    $branch_name      = $company_settings['churchly_branch_name'] ?? __('Branch');
    $department_name  = $company_settings['churchly_department_name'] ?? __('Department');
    $designation_name = $company_settings['churchly_designation_name'] ?? __('Designation');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('WhatsApp Groups')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('WA Groups')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
   

    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Go Back">
        <i class="ti ti-arrow-back-up me-2"></i>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    <div class="col-sm-2">
        <?php echo $__env->make('churchly::layouts.churchly_setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    
    <div class="col-sm-7">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Group Name')); ?></th>
                                <!--<th><?php echo e(__('Group ID')); ?></th>-->
                                <th><?php echo e($branch_name); ?></th>
                                <th><?php echo e($department_name); ?></th>
                                <th><?php echo e($designation_name); ?></th>
                                <th width="120px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($group->name ?? '-'); ?></td>
                                    <!--<td><?php echo e($group->group_id ?? '-'); ?></td>-->
                                    <td><?php echo e($group->branches->pluck('name')->join(', ') ?: '-'); ?></td>
                                    <td><?php echo e($group->departments->pluck('name')->join(', ') ?: '-'); ?></td>
                                    <td><?php echo e($group->designations->pluck('name')->join(', ') ?: '-'); ?></td>
                                    <td class="Action text-center">
                                        <div class="d-flex justify-content-center">
                                            <?php if (app('laratrust')->hasPermission('connect_whatsApp view')) : ?>
                                                <a href="<?php echo e(route('wa_group.show', $group->id)); ?>"
                                                   class="btn btn-sm bg-info text-white mx-1"
                                                   data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('View')); ?>">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            <?php endif; // app('laratrust')->permission ?>

                                            <?php if (app('laratrust')->hasPermission('connect_whatsApp delete')) : ?>
                                                <?php echo Form::open([
                                                    'route' => ['wa_group.destroy', $group->id],
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline m-0 p-0',
                                                    'id' => 'delete-form-' . $group->id
                                                ]); ?>

                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm bg-danger text-white mx-1 show_confirm"
                                                       data-bs-toggle="tooltip"
                                                       title="<?php echo e(__('Delete')); ?>"
                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                       data-text="<?php echo e(__('This action cannot be undone. Do you want to continue?')); ?>"
                                                       data-confirm-yes="delete-form-<?php echo e($group->id); ?>">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                <?php echo Form::close(); ?>

                                            <?php endif; // app('laratrust')->permission ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-sm-3">
        <div class="card p-3">
            <h6 class="mb-3"><?php echo e(__('Assign New WhatsApp Group')); ?></h6>
            <p class="text-muted small">
            <?php echo e(__('Follow these steps to assign a WhatsApp group:')); ?>

            </p>
            <ul class="text-muted small ps-3">
                <li><?php echo e(__('First, select the WhatsApp group you want to link from the dropdown. Only groups synced from Zender will appear here.')); ?></li>
                <li><?php echo e(__('(Optional) Choose a branch if this group should only apply to one church branch.')); ?></li>
                <li><?php echo e(__('(Optional) After selecting a branch, filter down further by department (e.g., Ushering, Choir, Youth).')); ?></li>
                <li><?php echo e(__('(Optional) If needed, assign the group to a specific designation within the department (e.g., Head Usher, Lead Vocalist).')); ?></li>
                <li><?php echo e(__('Finally, click Assign Group to save. The selected WhatsApp group will now be linked to the chosen branch, department, or designation.')); ?></li>
            </ul>
            <p class="text-muted small">
                <?php echo e(__('💡 Tip: If you leave Branch, Department, and Designation empty, the WhatsApp group will be assigned globally to all members in the workspace.')); ?>

            </p>
            <br>

            <?php if (app('laratrust')->hasPermission('connect_whatsApp create')) : ?>

       
            <?php echo Form::open(['route' => 'wa_group.store']); ?>


            
            <div class="mb-3">
                <?php echo e(Form::label('group_id', __('WhatsApp Group'))); ?> <?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::select('group_id', $groupOptions, null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('Select WhatsApp Group'),
                    'id' => 'group-select',
                    'required' => true,
                ])); ?>

            </div>
            <?php echo e(Form::hidden('group_name', null, ['id' => 'group-name'])); ?>


            
            <div class="mb-3">
                <?php echo e(Form::label('branch_id', __('Select Branch'))); ?>

                <?php echo e(Form::select('branch_id', $branches, null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('Select Branch'),
                    'id' => 'branch-select'
                ])); ?>

            </div>

            
            <div class="mb-3">
                <?php echo e(Form::label('department_id', __('Select Department'))); ?>

                <?php echo e(Form::select('department_id', [], null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('Select Department'),
                    'id' => 'department-select'
                ])); ?>

            </div>

            
            <div class="mb-3">
                <?php echo e(Form::label('designation_id', __('Select Designation'))); ?>

                <?php echo e(Form::select('designation_id', [], null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('Select Designation'),
                    'id' => 'designation-select'
                ])); ?>

            </div>

            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Assign Group')); ?>

            </button>

            <?php echo Form::close(); ?>

        
        <?php endif; // app('laratrust')->permission ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>





<?php $__env->startPush('scripts'); ?>
<script>
    const getDepartmentsUrl = "<?php echo e(route('departments.byBranch')); ?>";
    const getDesignationsUrl = "<?php echo e(route('designations.byDepartment')); ?>";

document.addEventListener('DOMContentLoaded', function () {
    const groupSelect = document.getElementById('group-select');
    const groupNameInput = document.getElementById('group-name');
    const branchSelect = document.getElementById('branch-select');
    const departmentSelect = document.getElementById('department-select');
    const designationSelect = document.getElementById('designation-select');

    const groupOptions = <?php echo json_encode($groupOptions, 15, 512) ?>;

    // Update hidden group_name on group select
    if (groupSelect) {
        groupSelect.addEventListener('change', function () {
            groupNameInput.value = groupOptions[this.value] || '';
        });
    }

    // Fetch departments when branch changes
    if (branchSelect) {
        branchSelect.addEventListener('change', function () {
            const branchId = this.value;
            // Always reset with placeholder first
                    departmentSelect.innerHTML = '<option value="" disabled selected><?php echo e(__("Select Department")); ?></option>';
                    designationSelect.innerHTML = '<option value="" disabled selected><?php echo e(__("Select Designation")); ?></option>';

            if (!branchId) return;

            fetch(`${getDepartmentsUrl}?branch=${branchId}`)
                .then(res => res.json())
                .then(data => {
                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        departmentSelect.appendChild(option);
                    });
                });
        });
    }

   // Fetch designations when department changes
    if (departmentSelect) {
        departmentSelect.addEventListener('change', function () {
            const departmentId = this.value;

            // Reset with placeholder
            designationSelect.innerHTML = '<option value="" disabled selected><?php echo e(__("Select Designation")); ?></option>';

            if (!departmentId) return;

            fetch(`${getDesignationsUrl}?department=${departmentId}`)
                .then(res => res.json())
                .then(data => {
                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        designationSelect.appendChild(option);
                    });
                });
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\wa_group\index.blade.php ENDPATH**/ ?>
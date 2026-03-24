<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Role')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Edit Role')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="mt-4">
        <?php echo e(Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PUT','class'=>'needs-validation','novalidate'])); ?>

        <div class="row ">
            <!-- Sidebar -->
            <div class="col-xl-3 col-12">
                <div class="card">
                    <div class="card-body pt-1">
                        <div class="">
                            <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php if(in_array($role->name, \App\Models\User::$not_edit_role)): ?>
                                <?php echo e(Form::text('role_name', $role->name, ['class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => __('Enter Role Name')])); ?>

                                <?php echo e(Form::hidden('name', $role->name, ['class' => 'form-control'])); ?>

                            <?php else: ?>
                                <?php echo e(Form::text('name', null, ['class' => 'form-control','required'=>'required','placeholder' => __('Enter Role Name')])); ?>

                            <?php endif; ?>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                </small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
                <div class="card sticky-top roles-sidebar">
                    <div class="list-group rounded" id="pills-tab" role="tablist">
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(module_is_active($module) || $module == 'General'): ?>
                                <button
                                    class="nav-link p-3 d-flex align-items-center justify-content-between w-100 text-capitalize text-black text-start gap-2 border-0 <?php echo e($loop->index == 0 ? 'active' : ''); ?>"
                                    id="pills-<?php echo e(strtolower($module)); ?>-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-<?php echo e(strtolower($module)); ?>" type="button">
                                    <?php echo e(Module_Alias_Name($module)); ?>

                                    <i class="ti ti-chevron-right"></i>
                                </button>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php if(!empty($permissions)): ?>
                <!-- Main Content -->
                <div class="col-xl-9 col-12 setting-menu-div roles-menu mb-4">
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card tab-pane h-100 mb-0 fade <?php echo e($loop->index == 0 ? 'show active' : ''); ?>"
                            id="pills-<?php echo e(strtolower($module)); ?>" role="tabpanel"
                            aria-labelledby="pills-<?php echo e(strtolower($module)); ?>-tab">
                            <div class="card-header p-3">
                                <h5><?php echo e(Module_Alias_Name($module)); ?></h5>
                            </div>
                            <div class="card-body  p-3">
                                <div class="tab-content" id="pills-tabContent">
                                    <?php if(module_is_active($module) || $module == 'General'): ?>
                                        <div>
                                            <!-- Tab Content -->
                                            <input type="checkbox" class="form-check-input pointer"
                                                name="checkall-<?php echo e(strtolower($module)); ?>"
                                                id="checkall-<?php echo e(strtolower($module)); ?>"
                                                onclick="Checkall('<?php echo e(strtolower($module)); ?>')">
                                            <small class="text-muted mx-2">
                                                <?php echo e(Form::label('checkall-' . strtolower($module), 'Assign ' . Module_Alias_Name($module) . ' Permission to Roles', ['class' => 'form-check-label pointer'])); ?>

                                            </small>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-roles mb-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-primary"></th>
                                                            <th class="bg-primary text-white"><?php echo e(__('Module')); ?></th>
                                                            <th class="bg-primary text-white"><?php echo e(__('Permissions')); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $permissions = get_permission_by_module($module);
                                                            $m_permissions = array_column($permissions->toArray(), 'name');
                                                            $module_list = [];
                                                            foreach ($m_permissions as $key => $value) {
                                                                array_push($module_list, strtok($value, ' '));
                                                            }
                                                            $module_list = array_unique($module_list);
                                                        ?>
                                                        <?php $__currentLoopData = $module_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox"
                                                                        class="form-check-input ischeck pointer"
                                                                        onclick="CheckModule('module_checkbox_<?php echo e($key); ?>_<?php echo e($list); ?>')"
                                                                        id="module_checkbox_<?php echo e($key); ?>_<?php echo e($list); ?>">
                                                                </td>
                                                                <td>
                                                                    <?php echo e(Form::label('module_checkbox_' . $key . '_' . $list, str_replace('_', ' ', $list), ['class' => 'form-check-label pointer', 'style' => 'word-break: break-word;'])); ?>

                                                                </td>
                                                                <td
                                                                    class="module_checkbox_<?php echo e($key); ?>_<?php echo e($list); ?> ps-4">
                                                                    <div class="row">
                                                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $prermission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php
                                                                                $check = strtok($prermission->name, ' ');
                                                                                $name = str_replace(
                                                                                    $check,
                                                                                    '',
                                                                                    $prermission->name,
                                                                                );
                                                                            ?>
                                                                            <?php if($list == $check): ?>
                                                                                <div class="col-xl-3 col-sm-6 form-check mb-2">
                                                                                    <?php echo e(Form::checkbox('permissions[]', $prermission->id,$role->permission,['class' => 'form-check-input pointer checkbox-' . strtolower($module), 'id' => 'permission_' . $key . '_' . $prermission->id])); ?>

                                                                                    <?php echo e(Form::label('permission_' . $key . '_' . $prermission->id, $name, ['class' => 'form-check-label pointer', 'style' => 'white-space: normal; word-break: break-word;'])); ?>

                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-footer p-3 d-flex justify-content-end gap-2">
                                <input type="button" value="<?php echo e(__('Cancel')); ?>" onclick="location.href = '<?php echo e(route('roles.index')); ?>';"
                                    class="btn btn-secondary text-white" data-bs-dismiss="modal">
                                <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

        </div>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>
<script>
    function Checkall(module = null) {
        console.log(module);

        var ischecked = $("#checkall-" + module).prop('checked');
        if (ischecked == true) {
            $('.checkbox-' + module).prop('checked', true);
        } else {
            $('.checkbox-' + module).prop('checked', false);
        }
    }
</script>
<script type="text/javascript">
    function CheckModule(cl = null) {
        var ischecked = $("#" + cl).prop('checked');
        if (ischecked == true) {
            $('.' + cl).find("input[type=checkbox]").prop('checked', true);
        } else {
            $('.' + cl).find("input[type=checkbox]").prop('checked', false);
        }
    }
</script>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\role\edit.blade.php ENDPATH**/ ?>
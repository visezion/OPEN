<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Roles')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Roles')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <?php if (app('laratrust')->hasPermission('roles create')) : ?>
        <div>
            <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-sm btn-primary"
                data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    <?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
                $permissions = $role->permissions()->get();
        ?>
        <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card h-100 mb-0">
                <div class="roles-content-top h-100 p-3 border-1 border-bottom">
                    <div class="roles-title btn btn-primary mb-3"><?php echo e($role->name); ?></div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php $__currentLoopData = $permissions->take(9); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(module_is_active($permission->module) || $permission->module == 'General'): ?>
                                <span class="badge p-2  px-3 text-black"><?php echo e($permission->name); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="roles-content-bottom p-3 d-flex align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center flex-wrap gap-2 roles-image">
                        <?php $__currentLoopData = $role->users->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img alt="image" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                            src="<?php echo e(get_file($users->avatar)); ?>"
                            class="border-1 border border-white rounded-circle" data-bs-original-title="<?php echo e($users->name); ?>"
                            aria-label="<?php echo e($users->name); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <span class=""><?php echo e(__('Members')); ?></span>
                    </div>
                    <div class="d-flex align-items-center">

                        <?php if (app('laratrust')->hasPermission('roles edit')) : ?>
                        <div class="action-btn me-2">
                            <a href="<?php echo e(route('roles.edit',$role->id)); ?>" class="btn btn-sm  align-items-center bg-info me-2" data-size="xl"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo e(__('Edit')); ?>" aria-describedby="tooltip434956"
                                > <span class="text-white"> <i
                                        class="ti ti-pencil"></i></span></a>
                        </div>
                        <?php endif; // app('laratrust')->permission ?>
                        <?php if(!in_array($role->name,\App\Models\User::$not_edit_role)): ?>
                            <?php if (app('laratrust')->hasPermission('roles delete')) : ?>
                                <div class="action-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" aria-describedby="tooltip434956">
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'id'=>'delete-form-'.$role->id]); ?>


                                <a type="submit" class="mx-2 btn btn-sm align-items-center show_confirm bg-danger" data-toggle="tooltip" title="" data-original-title="<?php echo e(__('Delete')); ?>">
                                        <i class="ti ti-trash text-white"></i>
                                    </a>
                                    <?php echo Form::close(); ?>

                                </div>
                            <?php endif; // app('laratrust')->permission ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php echo $roles->links('vendor.pagination.global-pagination'); ?>


    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        function Checkall(module = null) {
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\role\index.blade.php ENDPATH**/ ?>
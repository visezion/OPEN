<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Permissions')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e(__('Users')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="#" class="btn btn-sm btn-primary" data-url="<?php echo e(route('permissions.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Permission')); ?>" data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
    </a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
   <div class="col-xl-3">
      <div class="card sticky-top" style="top:30px">
         <div class="list-group list-group-flush" id="useradd-sidenav">
             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <a class="list-group-item list-group-item-action <?php if($loop->index == 0): ?> active <?php endif; ?>" id="v-pills-<?php echo e(Str::slug($module)); ?>-tab" data-bs-toggle="pill" href="#v-pills-<?php echo e(Str::slug($module)); ?>" role="tab" aria-controls="v-pills-<?php echo e(Str::slug($module)); ?>" aria-selected="true"><?php echo e(__($module)); ?></a></li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
             <?php echo $__env->yieldPushContent('permission-'); ?>
         </div>
      </div>
   </div>
   <div class="col-xl-9">

      <div class="tab-content  card" id="base-permission ">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div id="v-pills-<?php echo e(Str::slug($module)); ?>" class="card tab-pane fade  <?php if($loop->index == 0): ?> active show <?php endif; ?> mb-0" role="tabpanel" aria-labelledby="v-pills-<?php echo e(Str::slug($module)); ?>-tab">
            <div class="card-header">
                <h5><?php echo e(__($module)); ?></h5>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <table class="table table-flush" id="dataTable">
                    <thead>
                        <tr>
                            <th> <?php echo e(__('Permissions')); ?></th>
                            <th class="text-right" width="200px"> <?php echo e(__('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $permissions = get_permission_by_module($module)
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($permission->name); ?></td>
                            <td class="action">



                                <span>

                                    <div class="action-btn btn-primary ms-2">
                                        <a  data-url="<?php echo e(route('permissions.edit',$permission->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Update permission')); ?>" class="btn btn-outline btn-xs blue-madison" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>
                                </span>



                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
                </div>
            </div>
         </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>

      <!-- [ sample-page ] end -->
   </div>
   <!-- [ Main Content ] end -->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\permission\index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Category')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Category')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div>
        <?php if (app('laratrust')->hasPermission('helpdesk ticketcategory create')) : ?>
            <a data-url="<?php echo e(route('helpdeskticket-category.create')); ?>" data-ajax-popup="true"
                data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" title="<?php echo e(__('Create')); ?>"
                data-title="<?php echo e(__('Create Category')); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/jscolor.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="helpdesk-ticketcategory">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"><?php echo e(__('Name')); ?></th>
                                    <th scope="col"><?php echo e(__('Color')); ?></th>
                                    <?php if(Laratrust::hasPermission('helpdesk ticketcategory edit') || Laratrust::hasPermission('helpdesk ticketcategory delete')): ?>
                                        <th class="text-end"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <th scope="row"><?php echo e(++$index); ?></th>
                                        <td><?php echo e($category->name); ?></td>
                                        <td><span class="badge"
                                                style="background: <?php echo e($category->color); ?>">&nbsp;&nbsp;&nbsp;</span></td>
                                        <?php if(Laratrust::hasPermission('helpdesk ticketcategory edit') || Laratrust::hasPermission('helpdesk ticketcategory delete')): ?>
                                            <td>
                                                <span class="float-end">
                                                    <?php if (app('laratrust')->hasPermission('helpdesk ticketcategory edit')) : ?>
                                                        <div class="action-btn me-2">
                                                            <a class="mx-3 btn btn-sm align-items-center bg-info"
                                                                data-url="<?php echo e(route('helpdeskticket-category.edit', $category->id)); ?>"
                                                                data-ajax-popup="true"
                                                                data-title="<?php echo e(__('Edit Product Category')); ?>"
                                                                data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"
                                                                data-original-title="<?php echo e(__('Edit')); ?>">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; // app('laratrust')->permission ?>
                                                    <?php if (app('laratrust')->hasPermission('helpdesk ticketcategory delete')) : ?>
                                                        <div class="action-btn  ">
                                                            <form method="POST"
                                                                action="<?php echo e(route('helpdeskticket-category.destroy', $category->id)); ?>"
                                                                id="user-form-<?php echo e($category->id); ?>">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                <button type="button"
                                                                    class="mx-3 btn btn-sm  align-items-center show_confirm bg-danger"
                                                                    data-bs-toggle="tooltip" title='Delete'>
                                                                    <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    <?php endif; // app('laratrust')->permission ?>
                                                </span>
                                            </td>
                                        <?php endif; ?>
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
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\ticket_category\index.blade.php ENDPATH**/ ?>
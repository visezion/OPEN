<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on("click",".cp_link",function() {
            var value = $(this).attr('data-link');
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(value).select();
                document.execCommand("copy");
                $temp.remove();
                toastrs('success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
<div class="d-flex">
    <?php echo $__env->yieldPushContent('addButtonHook'); ?>
    <a href="<?php echo e(route('purchases.index')); ?>" class="btn btn-sm btn-primary me-2" data-bs-toggle="tooltip"title="<?php echo e(__('List View')); ?>">
        <i class="ti ti-list text-white"></i>
    </a>
    <?php if(module_is_active('ProductService')): ?>
    <a href="<?php echo e(route('category.index')); ?>"data-size="md"  class="btn btn-sm btn-primary me-2" data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>"><i class="ti ti-settings"></i></a>
        <?php if (app('laratrust')->hasPermission('purchase create')) : ?>
            <a href="<?php echo e(route('purchases.create',0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-sm-12">
    <div class="row mb-4 project-wrp d-flex">
        <?php if(isset($purchases)): ?>
        <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 ">
                    <div class="project-card">
                        <div class="project-card-inner">
                            <div class="project-card-header d-flex justify-content-between">
                                <?php if($purchase->status == 0): ?>
                                    <span class="purchase_status badge bg-info p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                <?php elseif($purchase->status == 1): ?>
                                    <span class="purchase_status badge bg-primary p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                <?php elseif($purchase->status == 2): ?>
                                    <span class="purchase_status badge bg-secondary p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                <?php elseif($purchase->status == 3): ?>
                                    <span class="purchase_status badge bg-warning p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                <?php elseif($purchase->status == 4): ?>
                                    <span class="purchase_status badge bg-success p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                <?php endif; ?>

                                    <button type="button"
                                        class="btn btn-light dropdown-toggle d-flex align-items-center justify-content-center"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti ti-dots-vertical text-black"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end pointer">
                                        <a href="#"  data-link="<?php echo e(route('purchases.link.copy', \Crypt::encrypt($purchase->id))); ?>" class="dropdown-item cp_link" >
                                            <i class="ti ti-file me-1"></i> <?php echo e(__('Click To Copy Purchase Link')); ?>

                                        </a>
                                        <?php if (app('laratrust')->hasPermission('purchase show')) : ?>
                                            <a href="<?php echo e(route('purchases.show',\Crypt::encrypt($purchase->id))); ?>" data-size="md"class="dropdown-item" data-bs-toggle="tooltip"  data-title="<?php echo e(__('Details')); ?>">
                                                <i class="ti ti-eye me-1"></i> <?php echo e(__('View')); ?>

                                            </a>
                                        <?php endif; // app('laratrust')->permission ?>
                                        <?php if($purchase->status != 4): ?>
                                            <?php if (app('laratrust')->hasPermission('purchase edit')) : ?>
                                            <a href="<?php echo e(route('purchases.edit',\Crypt::encrypt($purchase->id))); ?>" class="dropdown-item" data-bs-toggle="tooltip" data-title="<?php echo e(__('Edit Purchase')); ?>"><i class="ti ti-pencil me-1"></i> <?php echo e(__('Edit')); ?></a>
                                            <?php endif; // app('laratrust')->permission ?>

                                            <?php if (app('laratrust')->hasPermission('purchase delete')) : ?>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' =>['purchases.destroy', $purchase->id]]); ?>

                                                    <a href="#!" class="text-danger dropdown-item show_confirm" data-bs-toggle="tooltip">
                                                        <i class="ti ti-trash me-1"></i> <?php echo e(__('Delete')); ?>

                                                    </a>
                                                <?php echo Form::close(); ?>

                                            <?php endif; // app('laratrust')->permission ?>
                                        <?php endif; ?>
                                </div>
                            </div>
                            <div class="project-card-content">
                                <div class="project-content-top">
                                    <div class="user-info  d-flex align-items-center">
                                        <a href="<?php echo e(route('purchases.show',\Crypt::encrypt($purchase->id))); ?>"><?php echo e(App\Models\Purchase::purchaseNumberFormat($purchase->purchase_id)); ?></a>
                                    </div>
                                    <div class="row align-items-center mt-3">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-break"><?php echo e(currency_format_with_sym($purchase->getTotal())); ?></h6>
                                            <span class="text-sm text-muted"><?php echo e(__('Total Amount')); ?></span>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="mb-0 text-break"><?php echo e(currency_format_with_sym($purchase->getDue())); ?></h6>
                                            <span class="text-sm text-muted"><?php echo e(__('Due Amount')); ?></span>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-3">
                                        <div class="col-6">
                                            <h6 class="mb-0 text-break"><?php echo e(currency_format_with_sym($purchase->getTotalTax())); ?></h6>
                                            <span class="text-sm text-muted"><?php echo e(__('Total Tax')); ?></span>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="mb-0 text-break"><?php echo e(company_date_formate($purchase->purchase_date)); ?></h6>
                                            <span class="text-sm text-muted"><?php echo e(__('Purchase Date')); ?></span>
                                         </div>
                                    </div>
                                </div>
                                <div
                                    class="project-content-bottom d-flex align-items-center justify-content-between gap-2">
                                    <div class="d-flex align-items-center gap-2 user-image">
                                        <?php if(\Auth::user()->type != 'vendor'): ?>
                                            <div class="user-group pt-2">
                                                    <img alt="image" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    <?php if($purchase->user != NUll): ?> title="<?php echo e($purchase->user->name); ?>" <?php else: ?> title="<?php echo e($purchase->vender_name); ?>"<?php endif; ?>
                                                        <?php if($purchase->user != NUll): ?> src="<?php echo e(get_file($purchase->user->avatar)); ?>" <?php else: ?> src="<?php echo e(get_file('uploads/users-avatar/avatar.png')); ?>" <?php endif; ?>
                                                        class="rounded-circle " width="25" height="25">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="comment d-flex align-items-center gap-2">
                                        <?php if (app('laratrust')->hasPermission('purchase show')) : ?>
                                            <a class="btn btn-sm btn-warning" href="<?php echo e(route('purchases.show',\Crypt::encrypt($purchase->id))); ?>" data-size="md"class="dropdown-item" data-bs-toggle="tooltip"  title="<?php echo e(__('View')); ?>">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        <?php endif; // app('laratrust')->permission ?>
                                        <?php if($purchase->status != 4): ?>
                                            <?php if (app('laratrust')->hasPermission('purchase edit')) : ?>
                                                <a class="btn btn-sm btn-info" href="<?php echo e(route('purchases.edit',\Crypt::encrypt($purchase->id))); ?>" class="dropdown-item" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"><i class="ti ti-pencil"></i></a>
                                            <?php endif; // app('laratrust')->permission ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if(auth()->guard('web')->check()): ?>
            <?php if (app('laratrust')->hasPermission('purchase create')) : ?>
                <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 ">
                    <div class="project-card-inner">
                        <a href="<?php echo e(route('purchases.create', 0)); ?>" class="btn-addnew-project " data-size="md"
                            data-title="<?php echo e(__('Create New Purchase')); ?>">
                            <div class="badge bg-primary proj-add-icon">
                                <i class="ti ti-plus"></i>
                            </div>
                            <h6 class="my-2 text-center"><?php echo e(__('New Purchase')); ?></h6>
                            <p class="text-muted text-center"><?php echo e(__('Click here to add New Purchase')); ?></p>
                        </a>
                    </div>
                </div>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?>
    </div>
</div>
<?php echo $purchases->links('vendor.pagination.global-pagination'); ?>

</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\purchases\grid.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Bills')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Bill')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <?php echo $__env->yieldPushContent('addButtonHook'); ?>
        <a href="<?php echo e(route('bill.index')); ?>" class="btn btn-sm btn-primary me-2" data-bs-toggle="tooltip"
            title="<?php echo e(__('List View')); ?>">
            <i class="ti ti-list text-white"></i>
        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService')): ?>
            <?php if (app('laratrust')->hasPermission('bill create')) : ?>
                <a href="<?php echo e(route('category.index')); ?>"data-size="md" class="btn btn-sm btn-primary me-2"
                    data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>"><i
                        class="ti ti-settings"></i></a>

                <a href="<?php echo e(route('bills.create', 0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Create')); ?>">
                    <i class="ti ti-plus"></i>
                </a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <style>
        .bill_status {
            min-width: 94px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="mt-2" id="multiCollapseExample1">

            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['bill.grid'], 'method' => 'GET', 'id' => 'frm_submit'])); ?>

                    <div class="row d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2 month">
                            <div class="btn-box">
                                <?php echo e(Form::label('bill_date', __('Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::date('bill_date', isset($_GET['bill_date']) ? $_GET['bill_date'] : null, ['class' => 'form-control form-control flatpickr-to-input', 'placeholder' => 'Select Date'])); ?>

                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'vendor'): ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2 date">
                                <div class="btn-box">
                                    <?php echo e(Form::label('vendor', __('Vendor'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::select('vendor', $vendor, isset($_GET['vendor']) ? $_GET['vendor'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Vendor'])); ?>

                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="btn-box">
                                <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('status', $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Status'])); ?>

                            </div>
                        </div>
                        <div class="col-auto float-end mt-4">
                            <a class="btn btn-sm btn-primary me-1"
                                onclick="document.getElementById('frm_submit').submit(); return false;"
                                data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                data-original-title="<?php echo e(__('apply')); ?>">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="<?php echo e(route('bill.grid')); ?>" class="btn btn-sm btn-danger"
                                data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>"
                                data-original-title="<?php echo e(__('Reset')); ?>">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>


                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row mb-4 project-wrp d-flex">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($bills)): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 ">
                            <div class="project-card">
                                <div class="project-card-inner">
                                    <div class="project-card-header d-flex justify-content-between h-100">

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status == 0): ?>
                                            <span
                                                class="badge bg-info p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php elseif($bill->status == 1): ?>
                                            <span
                                                class="badge bg-primary p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php elseif($bill->status == 2): ?>
                                            <span
                                                class="badge bg-secondary p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php elseif($bill->status == 3): ?>
                                            <span
                                                class="badge bg-warning p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php elseif($bill->status == 4): ?>
                                            <span
                                                class="badge bg-success p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <button type="button"
                                            class="btn btn-light dropdown-toggle d-flex align-items-center justify-content-center"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ti ti-dots-vertical text-black"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-end pointer">
                                            <a href="#"
                                                data-link="<?php echo e(route('pay.billpay', \Illuminate\Support\Facades\Crypt::encrypt($bill->id))); ?>"
                                                class="dropdown-item cp_link">
                                                <i class="ti ti-file me-1"></i> <?php echo e(__('Click to copy bill link')); ?>

                                            </a>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status != 4): ?>
                                            <?php if (app('laratrust')->hasPermission('bill edit')) : ?>
                                                <a
                                                    href="<?php echo e(route('bill.edit', \Crypt::encrypt($bill->id))); ?>"class="dropdown-item">
                                                    <i class="ti ti-pencil me-1"></i> <?php echo e(__('Edit')); ?>

                                                </a>
                                            <?php endif; // app('laratrust')->permission ?>
                                            <?php if (app('laratrust')->hasPermission('bill delete')) : ?>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['bill.destroy', $bill->id]]); ?>

                                                <a href="#!" class="show_confirm dropdown-item">
                                                    <span class="text-danger"><i class="ti ti-trash me-1"></i> <?php echo e(__('Delete')); ?></span>
                                                </a>
                                                <?php echo Form::close(); ?>

                                            <?php endif; // app('laratrust')->permission ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="project-card-content">
                                        <div class="project-content-top">
                                            <div class="user-info  d-flex align-items-center">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Laratrust::hasPermission('bill show')): ?>
                                                    <a
                                                        href="<?php echo e(route('bill.show', \Crypt::encrypt($bill->id))); ?>"><?php echo e(Workdo\Account\Entities\Bill::billNumberFormat($bill->bill_id)); ?></a>
                                                <?php else: ?>
                                                    <a><?php echo e(Workdo\Account\Entities\Bill::billNumberFormat($bill->bill_id)); ?></a>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-break"><?php echo e(currency_format_with_sym($bill->getTotal())); ?></h6>
                                                    <span class="text-sm text-muted"><?php echo e(__('Total Amount')); ?></span>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-break"><?php echo e(currency_format_with_sym($bill->getDue())); ?></h6>
                                                    <span class="text-sm text-muted"><?php echo e(__('Due Amount')); ?></span>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-break"><?php echo e(company_date_formate($bill->bill_date)); ?></h6>
                                                    <span class="text-sm text-muted"><?php echo e(__('Issue Date')); ?></span>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-break"><?php echo e(company_date_formate($bill->due_date)); ?></h6>
                                                    <span class="text-sm text-muted"><?php echo e(__('Due Date')); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="project-content-bottom d-flex align-items-center justify-content-between gap-2">
                                            <div class="d-flex align-items-center gap-2 user-image">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'vendor'): ?>
                                                    <div class="user-group">
                                                        <img alt="image" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="<?php echo e(!empty($bill->vendor_name) ? $bill->vendor_name : ''); ?>"
                                                            <?php if(!empty($bill->avatar) ? $bill->avatar : ''): ?> src="<?php echo e(get_file(!empty($bill->avatar) ? $bill->avatar : '')); ?>" <?php else: ?> src="<?php echo e('uploads/users-avatar/avatar.png'); ?>" <?php endif; ?>
                                                            class="rounded-circle " width="25" height="25">
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div class="comment d-flex align-items-center gap-2">
                                                <?php if (app('laratrust')->hasPermission('bill show')) : ?>
                                                    <a class="btn btn-sm btn-warning" href="<?php echo e(route('bill.show', \Crypt::encrypt($bill->id))); ?>"
                                                class="dropdown-item" data-toggle="tooltip" title="<?php echo e(__('View')); ?>"
                                                        data-original-title="<?php echo e(__('View')); ?>">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('bill duplicate')) : ?>
                                                    <?php echo Form::open([
                                                        'method' => 'get',
                                                        'route' => ['bill.duplicate', $bill->id],
                                                        'id' => 'duplicate-form-' . $bill->id,
                                                    ]); ?>

                                                    <a href="#!" class="show_confirm btn btn-sm bg-secondary"
                                                    data-text="<?php echo e(__('You want to confirm duplicate this bill. Press Yes to continue or Cancel to go back')); ?>" title="<?php echo e(__('Duplicate')); ?>" data-toggle="tooltip"
                                                        data-confirm-yes="duplicate-form-<?php echo e($bill->id); ?>">
                                                        <i class="ti ti-copy text-white"></i>
                                                    </a>
                                                    <?php echo Form::close(); ?>

                                                <?php endif; // app('laratrust')->permission ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('web')->check()): ?>
                    <?php if (app('laratrust')->hasPermission('bill create')) : ?>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 ">
                            <div class="project-card-inner">
                                <a href="<?php echo e(route('bills.create', 0)); ?>" class="btn-addnew-project " data-size="md"
                                    data-title="<?php echo e(__('Create New Bill')); ?>">
                                    <div class="badge bg-primary proj-add-icon">
                                        <i class="ti ti-plus"></i>
                                    </div>
                                    <h6 class="my-2 text-center"><?php echo e(__('New Bill')); ?></h6>
                                    <p class="text-muted text-center"><?php echo e(__('Click here to add New Bill')); ?></p>
                                </a>
                            </div>
                        </div>
                    <?php endif; // app('laratrust')->permission ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <?php echo $bills->links('vendor.pagination.global-pagination'); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on("click", ".cp_link", function() {
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bill\grid.blade.php ENDPATH**/ ?>
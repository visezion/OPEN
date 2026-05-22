<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Invoices')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Invoices')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <?php echo $__env->yieldPushContent('addButtonHook'); ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService') && (module_is_active('Account') || module_is_active('Taskly'))): ?>
        <?php if (app('laratrust')->hasPermission('category create')) : ?>
            <a href="<?php echo e(route('category.index')); ?>"data-size="md" class="btn btn-sm btn-primary me-2"
                data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>"><i
                    class="ti ti-settings"></i></a>
        <?php endif; // app('laratrust')->permission ?>
            <?php if (app('laratrust')->hasPermission('invoice manage')) : ?>
                <a href="<?php echo e(route('invoice.index')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('List View')); ?>"
                    class="btn btn-sm btn-primary btn-icon me-2">
                    <i class="ti ti-list"></i>
                </a>
                <a href="<?php echo e(route('invoice.status.view')); ?>"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Quick Stats')); ?>" class="btn btn-sm btn-primary btn-icon me-2">
                    <i class="ti ti-filter"></i>
                </a>
            <?php endif; // app('laratrust')->permission ?>
            <?php if (app('laratrust')->hasPermission('invoice create')) : ?>
                <a href="<?php echo e(route('invoice.create', 0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Create')); ?>">
                    <i class="ti ti-plus"></i>
                </a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="mt-2" id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['invoice.grid.view'], 'method' => 'GET', 'id' => 'customer_submit'])); ?>

                    <div class="row d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                            <div class="btn-box">
                                <?php echo e(Form::label('issue_date', __('Issue Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('issue_date', isset($_GET['issue_date']) ? $_GET['issue_date'] : null, ['class' => 'form-control flatpickr-to-input', 'placeholder' => 'Select Date'])); ?>

                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'client'): ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <?php echo e(Form::label('customer', __('Customer'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::select('customer', $customer, isset($_GET['customer']) ? $_GET['customer'] : '', ['class' => 'form-control select', 'placeholder' => 'Select Customer'])); ?>

                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="btn-box">
                                <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('status', ['' => 'Select Status'] + $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control select'])); ?>

                            </div>
                        </div>
                        <div class="col-auto float-end mt-4 d-flex">
                            <a href="#" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('customer_submit').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('Apply')); ?>" title="<?php echo e(__('Apply')); ?>" data-bs-toggle="tooltip">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="<?php echo e(route('invoice.grid.view')); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                data-original-title="<?php echo e(__('Reset')); ?>"  title="<?php echo e(__('Reset')); ?>">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                            </a>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row mb-4 project-wrp d-flex">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($invoices)): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12">
                            <div class="project-card">
                                <div class="project-card-inner">
                                    <div class="project-card-header d-flex justify-content-between">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->status == 0): ?>
                                            <span class="badge bg-info p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 1): ?>
                                            <span class="badge bg-primary p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 2): ?>
                                            <span class="badge bg-secondary p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 3): ?>
                                            <span class="badge bg-warning p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 4): ?>
                                            <span class="badge bg-success p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 5): ?>
                                            <span class="badge bg-success p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <button type="button"
                                            class="btn btn-light dropdown-toggle d-flex align-items-center justify-content-center"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ti ti-dots-vertical text-black"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-end pointer">
                                            <a href="#"  data-link="<?php echo e(route('pay.invoice',\Illuminate\Support\Facades\Crypt::encrypt($invoice->id))); ?>" class="dropdown-item cp_link" >
                                                <i class="ti ti-file me-1"></i> <?php echo e(__('Click To Copy Invoice Link')); ?>

                                            </a>
                                            <?php if (app('laratrust')->hasPermission('invoice duplicate')) : ?>
                                            <?php echo Form::open([
                                                'method' => 'get',
                                                'route' => ['invoice.duplicate', $invoice->id],
                                                'id' => 'duplicate-form-' . $invoice->id,
                                            ]); ?>

                                                    <a href="#!" class="show_confirm dropdown-item" data-text="<?php echo e(__('You want to confirm duplicate this invoice. Press Yes to continue or No to go back')); ?>"
                                                    data-confirm-yes="duplicate-form-<?php echo e($invoice->id); ?>">
                                                    <i class="ti ti-copy me-1"></i> <?php echo e(__('Duplicate')); ?>

                                                    </a>
                                                <?php echo Form::close(); ?>

                                            <?php endif; // app('laratrust')->permission ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('EInvoice')): ?>
                                                <?php if (app('laratrust')->hasPermission('download invoice')) : ?>
                                                    <?php echo $__env->make('einvoice::download.grid_generate_invoice',['invoice_id'=>$invoice->id], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <?php endif; // app('laratrust')->permission ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <a href="#" class="dropdown-item"
                                                data-url="<?php echo e(route('delivery-form.pdf', \Crypt::encrypt($invoice->id))); ?>" data-ajax-popup="true"
                                                data-size="lg" data-title="<?php echo e(__('Invoice Delivery Form')); ?>">
                                                <i class="ti ti-clipboard-list me-1"></i> <?php echo e(__('Invoice Delivery Form')); ?>

                                            </a>
                                            <?php if (app('laratrust')->hasPermission('invoice show')) : ?>
                                                <a href="<?php echo e(route('invoice.show',\Crypt::encrypt($invoice->id))); ?>" class="dropdown-item" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>">
                                                    <i class="ti ti-eye me-1"></i> <?php echo e(__('View')); ?>

                                                </a>
                                            <?php endif; // app('laratrust')->permission ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService') && $invoice->invoice_module == 'taskly' ? module_is_active('Taskly') : module_is_active('Account')): ?>
                                                <?php if (app('laratrust')->hasPermission('invoice edit')) : ?>
                                                    <a href="<?php echo e(route('invoice.edit', \Crypt::encrypt($invoice->id))); ?>" class="dropdown-item" >
                                                        <i class="ti ti-pencil me-1 "></i> <?php echo e(__('Edit')); ?>

                                                    </a>
                                                <?php endif; // app('laratrust')->permission ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if (app('laratrust')->hasPermission('invoice delete')) : ?>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['invoice.destroy', $invoice->id]]); ?>

                                                    <a href="#!" class="show_confirm dropdown-item text-danger">
                                                        <i class="ti ti-trash me-1 "></i> <?php echo e(__('Delete')); ?>

                                                    </a>
                                                <?php echo Form::close(); ?>

                                            <?php endif; // app('laratrust')->permission ?>
                                        </div>
                                    </div>
                                    <div class="project-card-content">
                                        <div class="project-content-top">
                                            <div class="user-info  d-flex align-items-center">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Laratrust::hasPermission('invoice show')): ?>
                                                    <a href="<?php echo e(route('invoice.show',\Crypt::encrypt($invoice->id))); ?>"><?php echo e(App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id)); ?></a>
                                                <?php else: ?>
                                                    <a href="#"><?php echo e(App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id)); ?></a>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-break"><?php echo e(currency_format_with_sym($invoice->getTotal())); ?></h6>
                                                    <span class="text-sm text-muted"><?php echo e(__('Total Amount')); ?></span>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-break"><?php echo e(currency_format_with_sym($invoice->getDue())); ?></h6>
                                                    <span class="text-sm text-muted"><?php echo e(__('Due Amount')); ?></span>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-break"><?php echo e(company_date_formate($invoice->issue_date)); ?></h6>
                                                    <span class="text-sm text-muted"><?php echo e(__('Issue Date')); ?></span>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="mb-0 text-break"><?php echo e(company_date_formate($invoice->due_date)); ?></h6>
                                                    <span class="text-sm text-muted"><?php echo e(__('Due Date')); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="project-content-bottom d-flex align-items-center justify-content-between gap-2">
                                            <div class="d-flex align-items-center gap-2 user-image">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'client'): ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($invoice->customers)): ?>
                                                        <div class="user-group pt-2">
                                                                <img alt="image" data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="<?php echo e($invoice->customers->name); ?>"
                                                                    <?php if($invoice->customers->avatar): ?> src="<?php echo e(get_file($invoice->customers->avatar)); ?>" <?php else: ?> src="<?php echo e(get_file('avatar.png')); ?>" <?php endif; ?>
                                                                    class="rounded-circle " width="25" height="25">
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div class="comment d-flex align-items-center gap-2">
                                                <?php if (app('laratrust')->hasPermission('invoice show')) : ?>
                                                    <a class="btn btn-sm btn-warning" href="<?php echo e(route('invoice.show',\Crypt::encrypt($invoice->id))); ?>" class="dropdown-item" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('invoice duplicate')) : ?>
                                                <?php echo Form::open([
                                                    'method' => 'get',
                                                    'route' => ['invoice.duplicate', $invoice->id],
                                                    'id' => 'duplicate-form-' . $invoice->id,
                                                ]); ?>

                                                        <a href="#!" class="show_confirm btn btn-sm bg-secondary" data-text="<?php echo e(__('You want to confirm duplicate this invoice. Press Yes to continue or No to go back')); ?>"
                                                        data-confirm-yes="duplicate-form-<?php echo e($invoice->id); ?>">
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
                    <?php if (app('laratrust')->hasPermission('invoice create')) : ?>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12">
                            <div class="project-card-inner">
                                <a href="<?php echo e(route('invoice.create', 0)); ?>" class="btn-addnew-project " data-size="md"
                                    data-title="<?php echo e(__('Create New Invoice')); ?>">
                                    <div class="badge bg-primary proj-add-icon">
                                        <i class="ti ti-plus"></i>
                                    </div>
                                    <h6 class="my-2 text-center"><?php echo e(__('New Invoice')); ?></h6>
                                    <p class="text-muted text-center"><?php echo e(__('Click here to add New Invoice')); ?></p>
                                </a>
                            </div>
                        </div>
                    <?php endif; // app('laratrust')->permission ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <?php echo $invoices->links('vendor.pagination.global-pagination'); ?>

    </div>
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\invoice\grid.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Purchase Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('click', '#shipping', function() {
            var url = $(this).data('url');
            var is_display = $("#shipping").is(":checked");
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'is_display': is_display,
                },
                success: function(data) {}
            });
        })
    </script>
    <script type="text/javascript">
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('success', '<?php echo e(__("Link Copy on Clipboard")); ?>', 'success')
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Purchase')); ?>,
    <?php echo e(App\Models\Purchase::purchaseNumberFormat($purchase->purchase_id)); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/Signature/src/Resources/assets/css/custom.css')); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/dropzone.css')); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/dropzone.css')); ?>">
    <style>
        .border-primary {
            border-color: #0CAF60 !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
<div>
    <div class="d-flex">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'company'): ?>
            <a href="<?php echo e(route('purchases.pdf', Crypt::encrypt($purchase->id))); ?>" target="_blank"
                class="btn btn-sm btn-primary me-2">
                <span class="btn-inner--icon text-white"><i class="ti ti-download"></i></span>
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <a href="#" class="btn btn-sm btn-primary cp_link"
            data-link="<?php echo e(route('purchases.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($purchase->id))); ?>"
            data-bs-toggle="tooltip" title="<?php echo e(__('Copy')); ?>"
            data-original-title="<?php echo e(__('Click to copy purchase link')); ?>">
            <span class="btn-inner--icon text-white"><i class="ti ti-file"></i></span>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type == 'company'): ?>
        <?php if (app('laratrust')->hasPermission('purchase send')) : ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status != 4): ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row timeline-wrapper">
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="progress mb-3">
                                    <div class="progress-value"></div>
                                </div>
                                <div class="d-flex align-items-start gap-2">
                                    <div class="timeline-icons ">
                                        <i class="ti ti-plus text-primary"></i>
                                    </div>
                                    <div class="invoice-content">
                                        <h2 class="text-primary h5 mb-2"><?php echo e(__('Create Purchase')); ?></h2>
                                        <p class="text-sm mb-3">
                                            <?php echo e(__('Created on ')); ?><?php echo e(company_date_formate($purchase->purchase_date)); ?>

                                        </p>
                                        <?php if (app('laratrust')->hasPermission('purchase edit')) : ?>
                                            <a href="<?php echo e(route('purchases.edit', \Crypt::encrypt($purchase->id))); ?>"
                                                class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                                data-original-title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil me-1"></i><?php echo e(__('Edit')); ?></a>
                                        <?php endif; // app('laratrust')->permission ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="progress mb-3">
                                    <div class="<?php echo e($purchase->status !== 0 ? 'progress-value' : ''); ?>"></div>
                                </div>
                                <div class="d-flex align-items-start gap-2">
                                    <div class="timeline-icons ">
                                        <i class="ti ti-send text-warning"></i>
                                    </div>
                                    <div class="invoice-content">
                                        <h6 class="text-warning h5 mb-2"><?php echo e(__('Send Purchase')); ?></h6>
                                        <p class="text-sm mb-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status != 0): ?>
                                                <?php echo e(__('Sent on')); ?>

                                                <?php echo e(company_date_formate($purchase->send_date)); ?>

                                            <?php else: ?>
                                                <?php if (app('laratrust')->hasPermission('purchase send')) : ?>
                                                    <?php echo e(__('Status')); ?> : <?php echo e(__('Not Sent')); ?>

                                                <?php endif; // app('laratrust')->permission ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status == 0): ?>
                                            <?php if (app('laratrust')->hasPermission('purchase send')) : ?>
                                                <a href="<?php echo e(route('purchases.sent', $purchase->id)); ?>" class="btn btn-sm btn-warning"
                                                    data-bs-toggle="tooltip" data-original-title="<?php echo e(__('Mark Sent')); ?>"><i
                                                        class="ti ti-send me-1"></i><?php echo e(__('Send')); ?></a>
                                            <?php endif; // app('laratrust')->permission ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="progress mb-3">
                                    <div class="<?php echo e($purchase->status == 4 ? 'progress-value' : ''); ?>"></div>
                                </div>
                                <div class="d-flex align-items-start gap-2">
                                    <div class="timeline-icons ">
                                        <i class="ti ti-report-money text-info"></i>
                                    </div>
                                    <div class="invoice-content">
                                        <h6 class="text-info h5 mb-2"><?php echo e(__('Get Paid')); ?></h6>
                                        <p class="text-sm mb-3"><?php echo e(__('Status')); ?> :
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status == 0): ?>
                                                <span><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                            <?php elseif($purchase->status == 1): ?>
                                                <span><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                            <?php elseif($purchase->status == 2): ?>
                                                <span><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                            <?php elseif($purchase->status == 3): ?>
                                                <span><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                            <?php elseif($purchase->status == 4): ?>
                                                <span><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status != 0): ?>
                                            <?php if (app('laratrust')->hasPermission('purchase payment create')) : ?>
                                                <a href="#" data-url="<?php echo e(route('purchases.payment', $purchase->id)); ?>"
                                                    data-ajax-popup="true" data-title="<?php echo e(__('Add Payment')); ?>"
                                                    class="btn btn-sm btn-light" data-original-title="<?php echo e(__('Add Payment')); ?>"><i
                                                        class="ti ti-report-money mr-2"></i><?php echo e(__(' Add Payment')); ?></a> <br>
                                            <?php endif; // app('laratrust')->permission ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type == 'company'): ?>
            <div class="row row-gap justify-content-between align-items-center mb-3">
                <div class="col-md-6">
                    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php if(!session('tab') or session('tab') and session('tab') == 1): ?> active <?php endif; ?>" id="purchase-setting-tab"
                                data-bs-toggle="pill" data-bs-target="#purchase-setting"
                                type="button"><?php echo e(__('Purchase')); ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php if(session('tab') and session('tab') == 2): ?> active <?php endif; ?>" id="payment-setting-tab"
                                data-bs-toggle="pill" data-bs-target="#payment-setting"
                                type="button"><?php echo e(__('Payment')); ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php if(session('tab') and session('tab') == 3): ?> active <?php endif; ?>" id="debit-setting-tab"
                                data-bs-toggle="pill" data-bs-target="#debit-setting"
                                type="button"><?php echo e(__('Debit Note')); ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php if(session('tab') and session('tab') == 4): ?> active <?php endif; ?>" id="attachment-setting-tab"
                                data-bs-toggle="pill" data-bs-target="#attachment-setting"
                                type="button"><?php echo e(__('Attachments')); ?></button>
                        </li>
                    </ul>
                </div>

                <div class="col-md-6 apply-wrp d-flex align-items-center justify-content-between justify-content-md-end">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status != 0): ?>
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                                <div class="all-button-box me-2">
                                    <a href="#" data-url="<?php echo e(route('purchases.debit.note', $purchase->id)); ?>"
                                        data-ajax-popup="true" data-title="<?php echo e(__('Apply Debit Note')); ?>"
                                        class="btn btn-sm btn-primary">
                                        <?php echo e(__('Apply Debit Note')); ?>

                                    </a>
                                </div>
                                <div class="all-button-box me-2">
                                    <a href="<?php echo e(route('purchases.resent', $purchase->id)); ?>" class="btn btn-sm btn-primary">
                                        <?php echo e(__('Resend purchase')); ?>

                                    </a>
                                </div>
                                <div class="all-button-box">
                                    <a href="<?php echo e(route('purchases.pdf', Crypt::encrypt($purchase->id))); ?>" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        <?php echo e(__('Download')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade <?php if(!session('tab') or session('tab') and session('tab') == 1): ?> active show <?php endif; ?>" id="purchase-setting"
                        role="tabpanel" aria-labelledby="pills-user-tab-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice">
                                    <div class="invoice-print">
                                        <div class="row row-gap invoice-title border-1 border-bottom  pb-3 mb-3">
                                            <div class="col-sm-4  col-12">
                                                <h2 class="h3 mb-0"><?php echo e(__('Purchase')); ?></h2>
                                            </div>
                                            <div class="col-sm-8  col-12">
                                                <div
                                                    class="d-flex invoice-wrp flex-wrap align-items-center gap-md-2 gap-1 justify-content-end">
                                                    <div
                                                        class="d-flex invoice-date flex-wrap align-items-center justify-content-end gap-md-3 gap-1">
                                                        <p class="mb-0"><strong><?php echo e(__('Purchase Date')); ?> :</strong>
                                                            <?php echo e(company_date_formate($purchase->purchase_date)); ?></p>
                                                    </div>
                                                    <h3 class="invoice-number mb-0">
                                                        <?php echo e(App\Models\Purchase::purchaseNumberFormat($purchase->purchase_id)); ?>

                                                    </h3>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="p-sm-4 p-3 invoice-billed">
                                            <div class="row row-gap">
                                                <div class="col-lg-4 col-sm-6">
                                                    <div class="invoice-billed-inner">
                                                        <p class="mb-3">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($purchase->vender_name)): ?>
                                                                <strong class="h5 mb-1"><?php echo e(__('Name ')); ?> :
                                                                </strong><?php echo e(!empty($vendor->name) ? $vendor->name : ''); ?>

                                                            <?php else: ?>
                                                                <strong class="h5 mb-1"><?php echo e(__('Vendor Name ')); ?> :
                                                                </strong><?php echo e(!empty($purchase->vender_name) ? $purchase->vender_name : ''); ?>

                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </p>
                                                        <div class="billed-content-top">
                                                           <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($vendor->billing_name) && !empty($vendor->billing_address) && !empty($vendor->billing_zip)): ?>
                                                                <div class="invoice-billed-content">
                                                                    <p class="mb-2"><strong
                                                                            class="h5 mb-1 d-block"><?php echo e(__('Billed To')); ?>

                                                                            :</strong>
                                                                        <span class="text-muted d-block" style="max-width:80%">
                                                                                <?php echo e(!empty($vendor->billing_name) ? $vendor->billing_name : ''); ?>

                                                                                <?php echo e(!empty($vendor->billing_address) ? $vendor->billing_address : ''); ?>

                                                                                <?php echo e(!empty($vendor->billing_city) ? $vendor->billing_city . ' ,' : ''); ?>

                                                                                <?php echo e(!empty($vendor->billing_state) ? $vendor->billing_state . ' ,' : ''); ?>

                                                                                <?php echo e(!empty($vendor->billing_zip) ? $vendor->billing_zip : ''); ?>

                                                                                <?php echo e(!empty($vendor->billing_country) ? $vendor->billing_country : ''); ?>

                                                                        </span>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        <?php echo e(!empty($vendor->billing_phone) ? $vendor->billing_phone : ''); ?>

                                                                    </p>
                                                                    <p class="mb-0">
                                                                        <strong><?php echo e(__('Tax Number ')); ?> :
                                                                        </strong><?php echo e(!empty($vendor->tax_number) ? $vendor->tax_number : ''); ?>

                                                                    </p>

                                                                </div>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                        <div class="billed-content-bottom">

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
                                                                <p>
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->company_signature): ?>
                                                                        <div class="mb-2">
                                                                            <img width="100px"
                                                                                src="<?php echo e($purchase->company_signature); ?>">
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="mb-2">
                                                                            <span
                                                                                class="badge bg-secondary p-2"><?php echo e(__('Not Signed')); ?></span>
                                                                        </div>
                                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                <div>
                                                                    <h5 class="mt-auto">
                                                                        <?php echo e(__('Company Signature')); ?></h5>
                                                                </div>
                                                                </p>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-sm-6">
                                                    <div class="invoice-billed-inner">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($purchase->vender_name)): ?>
                                                            <p class="mb-3">
                                                                <strong class="h5 mb-1"><?php echo e(__('Email ')); ?> :
                                                                </strong><?php echo e(!empty($vendor->email) ? $vendor->email : ''); ?>

                                                            </p>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <div class="billed-content-top">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['purchase_shipping_display']) && $company_settings['purchase_shipping_display'] == 'on'): ?>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($vendor->shipping_name) && !empty($vendor->shipping_address) && !empty($vendor->shipping_zip)): ?>
                                                                    <div class="invoice-billed-content">
                                                                        <p class="mb-2">
                                                                            <strong class="h5 mb-1 d-block"><?php echo e(__('Shipped To')); ?>

                                                                                :</strong>
                                                                            <span class="text-muted d-block"
                                                                                style="max-width:80%">
                                                                                <?php echo e(!empty($vendor->shipping_name) ? $vendor->shipping_name : ''); ?>

                                                                                <?php echo e(!empty($vendor->shipping_address) ? $vendor->shipping_address : ''); ?>

                                                                                <?php echo e(!empty($vendor->shipping_city) ? $vendor->shipping_city . ' ,' : ''); ?>

                                                                                <?php echo e(!empty($vendor->shipping_state) ? $vendor->shipping_state . ' ,' : ''); ?>

                                                                                <?php echo e(!empty($vendor->shipping_zip) ? $vendor->shipping_zip : ''); ?>

                                                                                <?php echo e(!empty($vendor->shipping_country) ? $vendor->shipping_country : ''); ?>

                                                                            </span>
                                                                        </p>
                                                                        <p class="mb-1 text-dark">
                                                                            <?php echo e(!empty($vendor->shipping_phone) ? $vendor->shipping_phone : ''); ?>

                                                                        </p>
                                                                        <p class="mb-0">
                                                                            <strong><?php echo e(__('Tax Number ')); ?> :
                                                                            </strong><?php echo e(!empty($vendor->tax_number) ? $vendor->tax_number : ''); ?>

                                                                        </p>
                                                                    </div>
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                        <div class="billed-content-bottom">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
                                                                <div class="vendor-signature-content">
                                                                    <p>
                                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->vendor_signature != ''): ?>
                                                                            <div class="mb-2">
                                                                                <img width="100px"
                                                                                    src="<?php echo e($purchase->vendor_signature); ?>">
                                                                            </div>
                                                                        <?php else: ?>
                                                                            <div class="mb-2">
                                                                                <span
                                                                                    class="badge bg-secondary p-2"><?php echo e(__('Not Signed')); ?></span>
                                                                            </div>
                                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                                    <div>
                                                                        <h5 class="mt-auto">
                                                                            <?php echo e(__('Vendor Signature')); ?></h5>
                                                                    </div>
                                                                    </p>
                                                                </div>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-6">
                                                    <strong class="h5 d-block mb-2">Status :</strong>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status == 0): ?>
                                                        <span
                                                            class="badge bg-info p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                    <?php elseif($purchase->status == 1): ?>
                                                        <span
                                                            class="badge bg-primary p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                    <?php elseif($purchase->status == 2): ?>
                                                        <span
                                                            class="badge bg-secondary p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                    <?php elseif($purchase->status == 3): ?>
                                                        <span
                                                            class="badge bg-warning p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                    <?php elseif($purchase->status == 4): ?>
                                                        <span
                                                            class="badge bg-success p-2 px-3"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['purchase_qr_display']) && $company_settings['purchase_qr_display'] == 'on'): ?>
                                                    <div class="col-lg-2 col-sm-6">
                                                        <div class="float-sm-end qr-code">
                                                            <div class="col">
                                                                <div class="float-sm-end">
                                                                    <?php echo DNS2D::getBarcodeHTML(
                                                                        route('purchases.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($purchase->id)),
                                                                        'QRCODE',
                                                                        2,
                                                                        2,
                                                                    ); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($customFields) && count($purchase->customField) > 0): ?>
                                            <div class="px-4 mt-3">
                                                <div class="row row-gap">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-xxl-3 col-sm-6">
                                                            <strong class="d-block mb-1"><?php echo e($field->name); ?> </strong>

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($field->type == 'attachment'): ?>
                                                                <a href="<?php echo e(get_file($purchase->customField[$field->id])); ?>"
                                                                    target="_blank">
                                                                    <img src=" <?php echo e(get_file($purchase->customField[$field->id])); ?> "
                                                                        class="wid-120 rounded">
                                                                </a>
                                                            <?php else: ?>
                                                                <p class="mb-0">
                                                                    <?php echo e(!empty($purchase->customField[$field->id]) ? $purchase->customField[$field->id] : '-'); ?>

                                                                </p>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <div class="invoice-summary mt-3">
                                            <div class="col-md-12">
                                                <div class="invoice-title border-1 border-bottom mb-3 pb-2">
                                                    <h3 class="h4 mb-0"><?php echo e(__('Item Summary')); ?></h3>
                                                    <small><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                                </div>
                                                <div class="table-responsive mt-2">
                                                    <table class="table mb-0 table-striped">
                                                        <tr>
                                                            <th data-width="40" class="text-white bg-primary text-uppercase">#
                                                            </th>
                                                            <th class="text-white bg-primary text-uppercase">
                                                                <?php echo e(__('Item Type')); ?></th>
                                                            <th class="text-white bg-primary text-uppercase">
                                                                <?php echo e(__('Item')); ?></th>
                                                            <th class="text-white bg-primary text-uppercase">
                                                                <?php echo e(__('Quantity')); ?></th>
                                                            <th class="text-white bg-primary text-uppercase">
                                                                <?php echo e(__('Rate')); ?></th>
                                                            <th class="text-white bg-primary text-uppercase">
                                                                <?php echo e(__('Discount')); ?> </th>
                                                            <th class="text-white bg-primary text-uppercase">
                                                                <?php echo e(__('Tax')); ?></th>
                                                            <th class="text-white bg-primary text-uppercase">
                                                                <?php echo e(__('Description')); ?></th>
                                                            <th class="text-end text-white bg-primary text-uppercase"
                                                                width="12%">
                                                                <?php echo e(__('Price')); ?><br>
                                                                <small
                                                                    class="text-danger font-weight-bold"><?php echo e(__('After discount & tax')); ?></small>
                                                            </th>

                                                        </tr>
                                                        <?php
                                                            $totalQuantity = 0;
                                                            $totalRate = 0;
                                                            $totalTaxPrice = 0;
                                                            $totalDiscount = 0;
                                                            $taxesData = [];
                                                            $TaxPrice_array = [];
                                                        ?>

                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $iteams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $iteam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($iteam->tax)): ?>
                                                                <?php
                                                                    $taxes = App\Models\Purchase::taxs($iteam->tax);
                                                                    $totalQuantity += $iteam->quantity;
                                                                    $totalRate += $iteam->price;
                                                                    $totalDiscount += $iteam->discount;
                                                                    foreach ($taxes as $taxe) {
                                                                        $taxDataPrice = App\Models\Purchase::taxRate(
                                                                            $taxe->rate,
                                                                            $iteam->price,
                                                                            $iteam->quantity,
                                                                            $iteam->discount,
                                                                        );
                                                                        if (array_key_exists($taxe->name, $taxesData)) {
                                                                            $taxesData[$taxe->name] =
                                                                                $taxesData[$taxe->name] + $taxDataPrice;
                                                                        } else {
                                                                            $taxesData[$taxe->name] = $taxDataPrice;
                                                                        }
                                                                    }
                                                                ?>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <tr>
                                                                <td><?php echo e($key + 1); ?></td>
                                                                <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?>

                                                                </td>
                                                                <td><?php echo e(!empty($iteam->product) ? $iteam->product->name : ''); ?>

                                                                </td>
                                                                <td><?php echo e($iteam->quantity); ?></td>
                                                                <td><?php echo e(currency_format_with_sym($iteam->price)); ?></td>
                                                                <td><?php echo e(currency_format_with_sym($iteam->discount)); ?></td>
                                                                <td>
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($iteam->tax)): ?>
                                                                        <table>
                                                                            <?php
                                                                                $totalTaxRate = 0;
                                                                                $data = 0;
                                                                            ?>
                                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php
                                                                                    $taxPrice = App\Models\Purchase::taxRate(
                                                                                        $tax->rate,
                                                                                        $iteam->price,
                                                                                        $iteam->quantity,
                                                                                        $iteam->discount,
                                                                                    );
                                                                                    $totalTaxPrice += $taxPrice;
                                                                                    $data += $taxPrice;
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="">
                                                                                        <?php echo e($tax->name . ' (' . $tax->rate . '%)'); ?>

                                                                                    </td>
                                                                                    <td><?php echo e(currency_format_with_sym($taxPrice)); ?>

                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                            <?php
                                                                                array_push($TaxPrice_array, $data);
                                                                            ?>
                                                                        </table>
                                                                    <?php else: ?>
                                                                        -
                                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                </td>
                                                                <td><?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?>

                                                                </td>
                                                                <td class="text-end">
                                                                    <?php echo e(currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $totalTaxPrice)); ?>

                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <tfoot>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="bg-color"><b><?php echo e(__('Total')); ?></b></td>
                                                                <td class="bg-color"><b><?php echo e($totalQuantity); ?></b></td>
                                                                <td class="bg-color">
                                                                    <b><?php echo e(currency_format_with_sym($totalRate)); ?></b></td>
                                                                <td class="bg-color">
                                                                    <b><?php echo e(currency_format_with_sym($totalDiscount)); ?></b></td>
                                                                <td class="bg-color">
                                                                    <b><?php echo e(currency_format_with_sym($totalTaxPrice)); ?></b></td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="7"></td>
                                                                <td class="text-end"><?php echo e(__('Sub Total')); ?></td>
                                                                <td class="text-end">
                                                                    <b><?php echo e(currency_format_with_sym($purchase->getSubTotal())); ?></b>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="7"></td>
                                                                <td class="text-end"><?php echo e(__('Discount')); ?></td>
                                                                <td class="text-end">
                                                                    <b><?php echo e(currency_format_with_sym($purchase->getTotalDiscount())); ?></b>
                                                                </td>
                                                            </tr>

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($taxesData)): ?>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr>
                                                                        <td colspan="7"></td>
                                                                        <td class="text-end"><?php echo e($taxName); ?></td>
                                                                        <td class="text-end">
                                                                            <b><?php echo e(currency_format_with_sym($taxPrice)); ?></b>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <tr>
                                                                <td colspan="7"></td>
                                                                <td class="blue-text text-end"><?php echo e(__('Total')); ?>

                                                                </td>
                                                                <td class="blue-text text-end">
                                                                    <b><?php echo e(currency_format_with_sym($purchase->getTotal())); ?></b>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                $getdue = $purchase->getDue();
                                                            ?>
                                                            <tr>
                                                                <td colspan="7"></td>
                                                                <td class="text-end"><?php echo e(__('Paid')); ?></td>
                                                                <td class="text-end">
                                                                    <b><?php echo e(currency_format_with_sym($purchase->getTotal() - $getdue)); ?></b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7"></td>
                                                                <td class="text-end"><?php echo e(__('Debit Note')); ?></td>
                                                                <td class="text-end">
                                                                    <b><?php echo e(currency_format_with_sym($purchase->purchaseTotalDebitNote())); ?></b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7"></td>
                                                                <td class="text-end"><?php echo e(__('Due')); ?></td>
                                                                <td class="text-end">
                                                                    <b><?php echo e(currency_format_with_sym($getdue)); ?></b>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade <?php if(session('tab') and session('tab') == 2): ?> active show <?php endif; ?>" id="payment-setting"
                        role="tabpanel" aria-labelledby="pills-user-tab-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-border-style">
                                        <h5 class=" d-inline-block mb-5"><?php echo e(__('Payment Summary')); ?></h5>
                                        <div class="table-responsive">
                                            <table class="table mb-0 pc-dt-simple" id="payment_summary">
                                                <thead>
                                                    <tr>
                                                        <th class="text-dark"><?php echo e(__('Payment Receipt')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                                        <?php if (app('laratrust')->hasPermission('purchase payment delete')) : ?>
                                                            <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                                        <?php endif; // app('laratrust')->permission ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $purchase->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($payment->add_receipt)): ?>
                                                                    <div class="action-btn me-2">
                                                                        <a href="<?php echo e(get_file($payment->add_receipt)); ?>"
                                                                            download=""
                                                                            class="mx-3 btn btn-sm align-items-center bg-primary"
                                                                            data-bs-toggle="tooltip"
                                                                            title="<?php echo e(__('Download')); ?>" target="_blank">
                                                                            <i class="ti ti-download text-white"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="action-btn">
                                                                        <a href="<?php echo e(get_file($payment->add_receipt)); ?>"
                                                                            class="mx-3 btn btn-sm align-items-center bg-secondary"
                                                                            data-bs-toggle="tooltip"
                                                                            title="<?php echo e(__('Show')); ?>" target="_blank">
                                                                            <i class="ti ti-crosshair text-white"></i>
                                                                        </a>
                                                                    </div>
                                                                <?php else: ?>
                                                                    -
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            </td>
                                                            <td><?php echo e(company_date_formate($payment->date)); ?></td>
                                                            <td><?php echo e(currency_format_with_sym($payment->amount)); ?></td>
                                                            <td><?php echo e(!empty($payment->bankAccount) ? $payment->bankAccount->bank_name . ' ' . $payment->bankAccount->holder_name : ''); ?>

                                                            </td>
                                                            <td><?php echo e($payment->reference); ?></td>
                                                            <td>
                                                                <?php echo e(isset($payment->description) ? $payment->description : '-'); ?></td>
                                                            <td class="text-dark">
                                                                <?php if (app('laratrust')->hasPermission('purchase payment delete')) : ?>
                                                                    <div class="action-btn">
                                                                        <?php echo e(Form::open(['route' => ['purchases.payment.destroy', $purchase->id, $payment->id], 'class' => 'm-0'])); ?>

                                                                        <a href="#"
                                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                                                                            data-bs-toggle="tooltip" title=""
                                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                                            data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                            data-confirm-yes="delete-form-<?php echo e($payment->id); ?>">
                                                                            <i class="ti ti-trash text-white text-white"></i>
                                                                        </a>
                                                                        <?php echo e(Form::close()); ?>

                                                                    </div>
                                                                <?php endif; // app('laratrust')->permission ?>
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
                        </div>
                    </div>

                    <div class="tab-pane fade <?php if(session('tab') and session('tab') == 3): ?> active show <?php endif; ?>" id="debit-setting"
                        role="tabpanel" aria-labelledby="pills-user-tab-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-border-style">
                                        <h5 class="d-inline-block mb-5"><?php echo e(__('Debit Note Summary')); ?></h5>
                                        <div class="table-responsive">
                                            <table class="table mb-0 pc-dt-simple" id="debit_summary">
                                                <thead>
                                                    <tr>
                                                        <th class="text-dark"><?php echo e(__('Debit Note')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Laratrust::hasPermission('purchase debitnote edit') || Laratrust::hasPermission('purchase debitnote delete')): ?>
                                                            <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $purchase->debitNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$debitNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><a href="#" class="btn btn-outline-primary"><?php echo e(!empty($debitNote->debitNote) ? \Workdo\Account\Entities\CustomerDebitNotes::debitNumberFormat($debitNote->debitNote->debit_id) : '-'); ?></a></td>
                                                        <td><?php echo e(company_date_formate($debitNote->date)); ?></td>
                                                        <td><?php echo e(currency_format_with_sym($debitNote->amount)); ?></td>
                                                        <td><?php echo e(isset($debitNote->description) ? $debitNote->description :'-'); ?></td>
                                                        <td>
                                                            <?php if (app('laratrust')->hasPermission('purchase debitnote edit')) : ?>
                                                                <div class="action-btn me-2">
                                                                    <a data-url="<?php echo e(route('purchases.edit.debit.note', [$debitNote->purchase, $debitNote->id])); ?>"
                                                                        data-ajax-popup="true"
                                                                        data-title="<?php echo e(__('Edit Debit Note')); ?>" href="#"
                                                                        class="mx-3 btn btn-sm align-items-center bg-info"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                                        <i class="ti ti-pencil text-white"></i>
                                                                    </a>
                                                                </div>
                                                            <?php endif; // app('laratrust')->permission ?>
                                                            <?php if (app('laratrust')->hasPermission('purchase debitnote delete')) : ?>
                                                                <div class="action-btn">
                                                                    <?php echo e(Form::open(['route' => ['purchases.delete.debit.note', $debitNote->purchase, $debitNote->id], 'class' => 'm-0'])); ?>

                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <a href="#"
                                                                        class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                                                                        data-bs-toggle="tooltip" title=""
                                                                        data-bs-original-title="Delete" aria-label="Delete"
                                                                        data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                        data-confirm-yes="delete-form-<?php echo e($debitNote->id); ?>">
                                                                        <i class="ti ti-trash text-white text-white"></i>
                                                                    </a>
                                                                    <?php echo e(Form::close()); ?>

                                                                </div>
                                                            <?php endif; // app('laratrust')->permission ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade <?php if(session('tab') and session('tab') == 4): ?> active show <?php endif; ?>" id="attachment-setting"
                        role="tabpanel" aria-labelledby="pills-user-tab-4">
                        <div class="row">
                            <h5 class="d-inline-block my-3"><?php echo e(__('Attachments')); ?></h5>
                            <div class="col-3">
                                <div class="card border-primary border">
                                    <div class="card-body table-border-style">
                                        <div class="col-md-12 dropzone browse-file" id="dropzonewidget">
                                            <div class="dz-message my-5" data-dz-message>
                                                <span><?php echo e(__('Drop files here to upload')); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card border-primary border">
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table mb-0 pc-dt-simple" id="attachment">
                                                <thead>
                                                    <tr>
                                                        <th class="text-dark"><?php echo e(__('#')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('File Name')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('File Size')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Date Created')); ?></th>
                                                        <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                </thead>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $purchase_attachment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e(++$key); ?></td>
                                                        <td><?php echo e($attachment->file_name); ?></td>
                                                        <td><?php echo e($attachment->file_size); ?></td>
                                                        <td><?php echo e(company_date_formate($attachment->created_at)); ?></td>
                                                        <td>
                                                            <div class="action-btn me-2">
                                                                <a href="<?php echo e(url($attachment->file_path)); ?>" data-bs-toggle="tooltip"
                                                                    class="mx-3 btn btn-sm align-items-center bg-primary"
                                                                    title="<?php echo e(__('Download')); ?>" target="_blank" download>
                                                                    <i class="ti ti-download text-white"></i>
                                                                </a>
                                                            </div>
                                                            <div class="action-btn">
                                                                <?php echo e(Form::open(['route' => ['purchases.attachment.destroy', $attachment->id], 'class' => 'm-0'])); ?>

                                                                <?php echo method_field('DELETE'); ?>
                                                                <a href="#"
                                                                    class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="Delete" aria-label="Delete"
                                                                    data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                    data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                    data-confirm-yes="delete-form-<?php echo e($attachment->id); ?>">
                                                                    <i class="ti ti-trash text-white text-white"></i>
                                                                </a>
                                                                <?php echo e(Form::close()); ?>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'company'): ?>
            <div class="col-12">
                <h5 class="h4 d-inline-block font-weight-400 mb-4"><?php echo e(__('Receipt Summary')); ?></h5>
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table ">
                                <tr>
                                    <th class="text-dark"><?php echo e(__('Payment Receipt')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $purchase->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($payment->add_receipt)): ?>
                                                <div class="action-btn me-2">
                                                    <a href="<?php echo e(get_file($payment->add_receipt)); ?>"
                                                        download=""
                                                        class="mx-3 btn btn-sm align-items-center bg-primary"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('Download')); ?>" target="_blank">
                                                        <i class="ti ti-download text-white"></i>
                                                    </a>
                                                </div>
                                                <div class="action-btn">
                                                    <a href="<?php echo e(get_file($payment->add_receipt)); ?>"
                                                        class="mx-3 btn btn-sm align-items-center bg-secondary"
                                                        data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('Show')); ?>" target="_blank">
                                                        <i class="ti ti-crosshair text-white"></i>
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td><?php echo e(company_date_formate($payment->date)); ?></td>
                                        <td><?php echo e(currency_format_with_sym($payment->amount)); ?></td>
                                        <td><?php echo e(!empty($payment->bankAccount) ? $payment->bankAccount->bank_name . ' ' . $payment->bankAccount->holder_name : ''); ?></td>
                                        <td><?php echo e($payment->reference); ?></td>
                                        <td><?php echo e(isset($payment->description) ? $payment->description : '-'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/dropzone-amd-module.min.js')); ?>"></script>
    <script>
        Dropzone.autoDiscover = false;
        myDropzone = new Dropzone("#dropzonewidget", {
            maxFiles: 20,
            maxFilesize: 20,
            parallelUploads: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.txt",
            url: "<?php echo e(route('purchases.files.upload', [$purchase->id])); ?>",
            success: function(file, response) {
                if (response.is_success) {
                    // dropzoneBtn(file, response);
                    location.reload();
                    myDropzone.removeFile(file);
                    toastrs('<?php echo e(__('Success')); ?>', 'File Successfully Uploaded', 'success');
                } else {
                    location.reload();
                    myDropzone.removeFile(response.error);
                    toastrs('Error', response.error, 'error');
                }
            },
            error: function(file, response) {
                myDropzone.removeFile(file);
                location.reload();
                if (response.error) {
                    toastrs('Error', response.error, 'error');
                } else {
                    toastrs('Error', response, 'error');
                }
            }
        });
        myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("purchase_id", <?php echo e($purchase->id); ?>);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\purchases\view.blade.php ENDPATH**/ ?>
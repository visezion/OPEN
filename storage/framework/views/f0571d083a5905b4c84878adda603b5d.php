<?php
    $admin_settings = getAdminAllSetting();

    $company_settings = getCompanyAllSetting(creatorId());

?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Bill Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Bill Detail')); ?>

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
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')
        });
    </script>
    <script src="<?php echo e(asset('assets/js/plugins/dropzone-amd-module.min.js')); ?>"></script>
    <script>
        Dropzone.autoDiscover = false;
        myDropzone = new Dropzone("#dropzonewidget", {
            url: "<?php echo e(route('bill.file.upload', [$bill->id])); ?>",
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
            formData.append("bill_id", <?php echo e($bill->id); ?>);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
        <link rel="stylesheet" href="<?php echo e(asset('packages/workdo/Signature/src/Resources/assets/css/custom.css')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <style>
        .bill_status {
            min-width: 94px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="float-end d-flex">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'company'): ?>
            <a href="<?php echo e(route('bill.pdf', Crypt::encrypt($bill->id))); ?>" target="_blank" class="btn btn-sm btn-primary me-2">
                <span class="btn-inner--icon text-white"><i class="ti ti-download"></i></span>
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <a href="#" class="btn btn-sm btn-primary cp_link"
            data-link="<?php echo e(route('pay.billpay', \Illuminate\Support\Facades\Crypt::encrypt($bill->id))); ?>"
            data-bs-toggle="tooltip" title="<?php echo e(__('copy')); ?>"
            data-original-title="<?php echo e(__('Click to copy invoice link')); ?>">
            <span class="text-white btn-inner--icon"><i class="ti ti-file"></i></span>
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type == 'company'): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status != 4): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row timeline-wrapper">
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="progress mb-3">
                                <div class="progress-value"></div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <div class="timeline-icons">
                                    <i class="ti ti-plus text-primary"></i>
                                </div>
                                <div class="invoice-content">
                                    <h2 class="text-primary h5 mb-2"><?php echo e(__('Create Bill')); ?></h2>
                                    <p class="text-sm mb-3">
                                        <?php echo e(__('Created on ')); ?><?php echo e(company_date_formate($bill->bill_date)); ?>

                                    </p>
                                    <?php if (app('laratrust')->hasPermission('bill edit')) : ?>
                                        <a href="<?php echo e(route('bill.edit', \Crypt::encrypt($bill->id))); ?>"
                                            class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                            data-original-title="<?php echo e(__('Edit')); ?>"><i
                                                class="mr-2 ti ti-pencil"></i><?php echo e(__('Edit')); ?>

                                        </a>
                                    <?php endif; // app('laratrust')->permission ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="progress mb-3">
                                <div class="<?php echo e($bill->status !== 0 ? 'progress-value' : ''); ?>"></div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <div class="timeline-icons">
                                    <i class="ti ti-send text-warning"></i>
                                </div>
                                <div class="invoice-content">
                                    <h6 class="text-warning h5 mb-2"><?php echo e(__('Send Bill')); ?></h6>
                                    <p class="text-sm mb-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status != 0): ?>
                                            <?php echo e(__('Sent on')); ?>

                                            <?php echo e(company_date_formate($bill->send_date)); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Status')); ?> : <?php echo e(__('Not Sent')); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                    <?php echo $__env->yieldPushContent('recurring_type'); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status == 0): ?>
                                        <?php if (app('laratrust')->hasPermission('bill send')) : ?>
                                            <a href="<?php echo e(route('bill.sent', $bill->id)); ?>" class="btn btn-sm btn-warning"
                                                data-bs-toggle="tooltip" data-original-title="<?php echo e(__('Mark Sent')); ?>"><i
                                                    class="me-1 ti ti-send"></i><?php echo e(__('Send')); ?></a>
                                        <?php endif; // app('laratrust')->permission ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="progress mb-3">
                                <div class="<?php echo e($bill->status == 4 ? 'progress-value' : ''); ?>"></div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <div class="timeline-icons">
                                    <i class="ti ti-report-money text-info"></i>
                                </div>
                                <div class="invoice-content">
                                    <h6 class="text-info h5 mb-2"><?php echo e(__('Pay Bill')); ?></h6>
                                    <p class="text-sm mb-3"><?php echo e(__('Status')); ?> :
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status == 0): ?>
                                            <span><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php elseif($bill->status == 1): ?>
                                            <span><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php elseif($bill->status == 2): ?>
                                            <span><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php elseif($bill->status == 3): ?>
                                            <span><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php elseif($bill->status == 4): ?>
                                            <span><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status != 0): ?>
                                        <?php if (app('laratrust')->hasPermission('bill payment create')) : ?>
                                            <a href="#" data-url="<?php echo e(route('bill.payment', $bill->id)); ?>"
                                                data-ajax-popup="true" data-title="<?php echo e(__('Add Payment')); ?>"
                                                class="btn btn-sm btn-light" data-original-title="<?php echo e(__('Add Payment')); ?>"><i
                                                    class="mr-2 ti ti-report-money"></i><?php echo e(__(' Add Payment')); ?></a> <br>
                                        <?php endif; // app('laratrust')->permission ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type == 'company'): ?>
        <div class="mb-3 row justify-content-between align-items-center">
            <div class="col-md-6">
                <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="bill-tab" data-bs-toggle="pill" data-bs-target="#bill"
                            type="button"><?php echo e(__('Bill')); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payment-summary-tab" data-bs-toggle="pill"
                            data-bs-target="#payment-summary" type="button"><?php echo e(__('Payment Summary')); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="debit-summary-tab" data-bs-toggle="pill"
                            data-bs-target="#debit-summary" type="button"><?php echo e(__('Debit Note Summary')); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bill-attechment-tab" data-bs-toggle="pill"
                            data-bs-target="#bill-attechment" type="button"><?php echo e(__('Attachment')); ?></button>
                    </li>
                    <?php echo $__env->yieldPushContent('add_recurring_tab'); ?>
                </ul>
            </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type == 'company'): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status != 0): ?>
            <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status != 4): ?>
                    <div class="me-2 all-button-box">
                        <a href="#" data-url="<?php echo e(route('bill.debit.note', $bill->id)); ?>" data-ajax-popup="true"
                            data-title="<?php echo e(__('Apply Debit Note')); ?>" class="btn btn-sm btn-primary">
                            <?php echo e(__('Apply Debit Note')); ?>

                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="me-2 all-button-box">
                    <a href="<?php echo e(route('bill.resent', $bill->id)); ?>" class="btn btn-sm btn-primary">
                        <?php echo e(__('Resend Bill')); ?>

                    </a>
                </div>
                <div class="all-button-box">
                    <a href="<?php echo e(route('bill.pdf', Crypt::encrypt($bill->id))); ?>" target="_blank"
                        class="btn btn-sm btn-primary">
                        <?php echo e(__('Download')); ?>

                    </a>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="bill" role="tabpanel"
                    aria-labelledby="pills-user-tab-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice">
                                <div class="invoice-print">
                                    <div
                                        class="d-flex flex-wrap align-items-center justify-content-between row-gap invoice-title border-1 border-bottom  pb-3 mb-3">
                                        <div>
                                            <h2 class="h3 mb-0"><?php echo e(__('Bill')); ?></h2>
                                        </div>
                                        <div>
                                            <div class="d-flex invoice-wrp flex-wrap align-items-center gap-md-2 gap-1">
                                                <div
                                                    class="d-flex invoice-date flex-wrap align-items-center gap-md-3 gap-1">
                                                    <p class="mb-0"><strong><?php echo e(__('Bill Date')); ?> :</strong>
                                                        <?php echo e(company_date_formate($bill->bill_date)); ?></p>
                                                    <p class="mb-0"><strong><?php echo e(__('Due Date')); ?> :</strong>
                                                        <?php echo e(company_date_formate($bill->due_date)); ?></p>
                                                </div>
                                                <h3 class="invoice-number mb-0">
                                                    <?php echo e(Workdo\Account\Entities\Bill::billNumberFormat($bill->bill_id)); ?>

                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-sm-4 p-3 invoice-billed">
                                        <div class="row row-gap">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="invoice-billed-inner">
                                                    <p class="mb-3">
                                                        <strong class="h5 mb-1"><?php echo e(__('Name ')); ?> :
                                                        </strong><?php echo e(!empty($vendor->name) ? $vendor->name : ''); ?>

                                                    </p>
                                                    <div class="billed-content-top">

                                                        <div class="invoice-billed-content">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($vendor->billing_name)): ?>
                                                                <p class="mb-2"><strong
                                                                        class="h5 mb-1 d-block"><?php echo e(__('Billed To')); ?>

                                                                        :</strong>
                                                                    <span class="text-muted d-block"
                                                                        style="max-width:80%">
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
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="billed-content-bottom">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
                                                            <p>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->company_signature != ''): ?>
                                                                    <div class="mb-2">
                                                                        <img width="100px"
                                                                            src="<?php echo e($bill->company_signature); ?>">
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
                                                    <p class="mb-3">
                                                        <strong class="h5 mb-1"><?php echo e(__('Email ')); ?> :
                                                        </strong><?php echo e(!empty($vendor->email) ? $vendor->email : ''); ?>

                                                    </p>
                                                    <div class="billed-content-top">

                                                        <div class="invoice-billed-content">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(company_setting('bill_shipping_display') == 'on'): ?>
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
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>

                                                    </div>
                                                    <div class="billed-content-bottom">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
                                                            <div class="vendor-signature-content">
                                                                <p>
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->vendor_signature != ''): ?>
                                                                        <div class="mb-2">
                                                                            <img width="100px"
                                                                                src="<?php echo e($bill->vendor_signature); ?>">
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
                                                <strong class="h5 d-block mb-2"><?php echo e(__('Status')); ?> :</strong>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status == 0): ?>
                                                    <span
                                                        class="badge fix_badge f-12 p-2 d-inline-block bg-info"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php elseif($bill->status == 1): ?>
                                                    <span
                                                        class="badge fix_badge f-12 p-2 d-inline-block bg-primary"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php elseif($bill->status == 2): ?>
                                                    <span
                                                        class="badge fix_badge f-12 p-2 d-inline-block bg-secondary"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php elseif($bill->status == 3): ?>
                                                    <span
                                                        class="badge fix_badge f-12 p-2 d-inline-block bg-warning"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php elseif($bill->status == 4): ?>
                                                    <span
                                                        class="badge fix_badge f-12 p-2 d-inline-block bg-success"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['bill_qr_display']) && $company_settings['bill_qr_display'] == 'on'): ?>
                                                <div class="col-lg-2 col-sm-6">
                                                    <div class="float-sm-end qr-code">
                                                        <div class="col">
                                                            <div class="float-sm-end">
                                                                <?php echo DNS2D::getBarcodeHTML(
                                                                    route('pay.billpay', \Illuminate\Support\Facades\Crypt::encrypt($bill->id)),
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

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($customFields) && count($bill->customField) > 0): ?>
                                        <div class="px-4 mt-3">
                                            <div class="row row-gap">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-xxl-3 col-sm-6">
                                                        <strong class="d-block mb-1"><?php echo e($field->name); ?> </strong>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($field->type == 'attachment'): ?>
                                                            <a href="<?php echo e(get_file($bill->customField[$field->id])); ?>"
                                                                target="_blank">
                                                                <img src=" <?php echo e(get_file($bill->customField[$field->id])); ?> "
                                                                    class="wid-120 rounded">
                                                            </a>
                                                        <?php else: ?>
                                                            <p class="mb-0">
                                                                <?php echo e(!empty($bill->customField[$field->id]) ? $bill->customField[$field->id] : '-'); ?>

                                                            </p>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="invoice-summary mt-3">
                                        <div class="invoice-title border-1 border-bottom mb-3 pb-2">
                                            <h3 class="h4 mb-0"><?php echo e(__('Item Summary')); ?></h3>
                                            <small class="mb-2"><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                        </div>
                                        <div class="mt-2 table-responsive">
                                            <table class="table mb-0 table-striped">
                                                <tr>
                                                    <th class="text-white bg-primary text-uppercase" data-width="40">#
                                                    </th>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->bill_module == 'account' || $bill->bill_module == ''): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Item Type')); ?></th>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Item')); ?></th>
                                                    <?php elseif($bill->bill_module == 'taskly'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Project')); ?></th>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Quantity')); ?>

                                                    </th>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Rate')); ?>

                                                    </th>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Discount')); ?>

                                                    </th>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Tax')); ?>

                                                    </th>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->bill_module == 'account' || $bill->bill_module == ''): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Chart Of Account')); ?></th>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Account Amount')); ?></th>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <th class="text-white bg-primary text-uppercase">
                                                        <?php echo e(__('Description')); ?></th>
                                                    <th class="text-right text-white bg-primary text-uppercase"
                                                        width="12%"><?php echo e(__('Price')); ?><br>
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
                                                            $taxes = Workdo\Account\Entities\AccountUtility::tax(
                                                                $iteam->tax,
                                                            );
                                                            $totalQuantity += $iteam->quantity;
                                                            $totalRate += $iteam->price;
                                                            $totalDiscount += $iteam->discount;
                                                            foreach ($taxes as $taxe) {
                                                                $taxDataPrice = Workdo\Account\Entities\AccountUtility::taxRate(
                                                                    $taxe['rate'],
                                                                    $iteam->price,
                                                                    $iteam->quantity,
                                                                    $iteam->discount,
                                                                );
                                                                if (array_key_exists($taxe['name'], $taxesData)) {
                                                                    $taxesData[$taxe['name']] =
                                                                        $taxesData[$taxe['name']] + $taxDataPrice;
                                                                } else {
                                                                    $taxesData[$taxe['name']] = $taxDataPrice;
                                                                }
                                                            }
                                                        ?>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <tr>
                                                        <td><?php echo e($key + 1); ?></td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->bill_module == 'account' || $bill->bill_module == ''): ?>
                                                            <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?>

                                                            </td>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                                            </td>
                                                        <?php elseif($bill->bill_module == 'taskly'): ?>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->title : ''); ?>

                                                            </td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                                                            $taxPrice = Workdo\Account\Entities\AccountUtility::taxRate(
                                                                                $tax['rate'],
                                                                                $iteam->price,
                                                                                $iteam->quantity,
                                                                                $iteam->discount,
                                                                            );
                                                                            $totalTaxPrice += $taxPrice;
                                                                            $data += $taxPrice;
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo e($tax['name'] . ' (' . $tax['rate'] . '%)'); ?>

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

                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->bill_module == 'account' || $bill->bill_module == ''): ?>
                                                            <?php
                                                                $chartAccount = \Workdo\Account\Entities\ChartOfAccount::find(
                                                                    $iteam->chart_account_id,
                                                                );
                                                            ?>
                                                            <td><?php echo e(!empty($chartAccount) ? $chartAccount->name : '-'); ?>

                                                            </td>
                                                            <td><?php echo e(currency_format_with_sym($iteam->amount)); ?></td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <td style="white-space: break-spaces;">
                                                            <?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?></td>
                                                        <?php
                                                            $tr_tex =
                                                                array_key_exists($key, $TaxPrice_array) == true
                                                                    ? $TaxPrice_array[$key]
                                                                    : 0;
                                                        ?>
                                                        <td class="">
                                                            <?php echo e(currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $tr_tex)); ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->bill_module == 'account' || $bill->bill_module == ''): ?>
                                                            <td></td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <td class="bg-color"><b><?php echo e(__('Total')); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e($totalQuantity); ?></b></td>
                                                        <td class="bg-color">
                                                            <b><?php echo e(currency_format_with_sym($totalRate)); ?></b></td>
                                                        <td class="bg-color">
                                                            <b><?php echo e(currency_format_with_sym($totalDiscount)); ?></b></td>
                                                        <td class="bg-color">
                                                            <b><?php echo e(currency_format_with_sym($totalTaxPrice)); ?></b></td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->bill_module == 'account' || $bill->bill_module == ''): ?>
                                                            <td class="bg-color"></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($bill->getAccountTotal())); ?></b>
                                                            </td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </tr>
                                                    <?php
                                                        $colspan = 6;
                                                        if (
                                                            $bill->bill_module == 'account' ||
                                                            $bill->bill_module == ''
                                                        ) {
                                                            $colspan = 9;
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Sub Total')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($bill->getSubTotal())); ?></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Discount')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($bill->getTotalDiscount())); ?></b>
                                                        </td>
                                                    </tr>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($taxesData)): ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td colspan="<?php echo e($colspan); ?>"></td>
                                                                <td class="text-right"><?php echo e($taxName); ?></td>
                                                                <td class="text-right">
                                                                    <b><?php echo e(currency_format_with_sym($taxPrice)); ?></b>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right blue-text"><?php echo e(__('Total')); ?></td>
                                                        <td class="text-right blue-text">
                                                            <b><?php echo e(currency_format_with_sym($bill->getTotal())); ?></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Paid')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($bill->getTotal() - $bill->getDue() - $bill->billTotalDebitNote())); ?></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Debit note Applied')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($bill->billTotalDebitNote())); ?></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Debit note issued')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($bill->billTotalCustomerDebitNote())); ?></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Due')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($bill->getDue())); ?></b>
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
                <div class="tab-pane fade" id="payment-summary" role="tabpanel" aria-labelledby="pills-user-tab-2">
                    <div class="card">
                        <div class="card-body table-border-style">
                            <h5 class="mb-5 d-inline-block"><?php echo e(__('Payment Summary')); ?></h5>
                            <div class="table-responsive">
                                <table class="table mb-0 pc-dt-simple" id="invoice-payment">
                                    <thead>
                                        <tr>
                                            <th class="text-dark"><?php echo e(__('Payment Receipt')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                            <?php if (app('laratrust')->hasPermission('bill payment delete')) : ?>
                                                <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                            <?php endif; // app('laratrust')->permission ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bill->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($payment->add_receipt)): ?>
                                                        <div class="action-btn  me-2">
                                                            <a href="<?php echo e(get_file($payment->add_receipt)); ?>"
                                                                download=""
                                                                class=" bg-primary mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>"
                                                                target="_blank">
                                                                <i class="text-white ti ti-download"></i>
                                                            </a>
                                                        </div>
                                                        <div class="action-btn">
                                                            <a href="<?php echo e(get_file($payment->add_receipt)); ?>"
                                                                class="bg-secondary mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip" title="<?php echo e(__('Show')); ?>"
                                                                target="_blank">
                                                                <i class="text-white ti ti-crosshair"></i>
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
                                                <td><?php echo e(isset($payment->description) ? $payment->description : '-'); ?></td>
                                                <td class="text-dark">
                                                    <?php if (app('laratrust')->hasPermission('bill payment delete')) : ?>
                                                        <div class="action-btn">
                                                            <?php echo e(Form::open(['route' => ['bill.payment.destroy', $bill->id, $payment->id], 'class' => 'm-0'])); ?>

                                                            <a href="#"
                                                                class="bg-danger mx-3 btn btn-sm align-items-center bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                data-confirm-yes="delete-form-<?php echo e($payment->id); ?>">
                                                                <i class="text-white ti ti-trash"></i>
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
                <div class="tab-pane fade" id="debit-summary" role="tabpanel" aria-labelledby="pills-user-tab-3">
                    <div class="card">
                        <div class="card-body table-border-style">
                            <h5 class="mb-5 d-inline-block"><?php echo e(__('Debit Note Summary')); ?></h5>
                            <div class="table-responsive">
                                <table class="table mb-0 pc-dt-simple" id="debit-note">
                                    <thead>
                                        <tr>
                                            <th class="text-dark"><?php echo e(__('Debit Note')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Laratrust::hasPermission('debitnote edit') || Laratrust::hasPermission('debitnote delete')): ?>
                                                <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tr>
                                    </thead>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bill->debitNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$debitNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><a href="#" class="btn btn-outline-primary"><?php echo e(!empty($debitNote->debitNote) ? \Workdo\Account\Entities\CustomerDebitNotes::debitNumberFormat($debitNote->debitNote->debit_id) : '-'); ?></a></td>
                                            <td><?php echo e(company_date_formate($debitNote->date)); ?></td>
                                            <td><?php echo e(currency_format_with_sym($debitNote->amount)); ?></td>
                                            <td><?php echo e(isset($debitNote->description) ? $debitNote->description : '-'); ?></td>
                                            <td>
                                                <?php if (app('laratrust')->hasPermission('debitnote edit')) : ?>
                                                    <div class="action-btn me-2">
                                                        <a data-url="<?php echo e(route('bill.edit.debit.note', [$debitNote->bill, $debitNote->id])); ?>"
                                                            data-ajax-popup="true" data-title="<?php echo e(__('Add Debit Note')); ?>"
                                                            href="#" class="bg-info mx-3 btn btn-sm align-items-center"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                            <i class="text-white ti ti-pencil"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('debitnote delete')) : ?>
                                                    <div class="action-btn">
                                                        <?php echo e(Form::open(['route' => ['bill.delete.debit.note', $debitNote->bill, $debitNote->id], 'class' => 'm-0'])); ?>

                                                        <?php echo method_field('DELETE'); ?>
                                                        <a href="#"
                                                            class="bg-danger mx-3 btn btn-sm align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-confirm-yes="delete-form-<?php echo e($debitNote->id); ?>">
                                                            <i class="text-white ti ti-trash"></i>
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
                <div class="tab-pane fade" id="bill-attechment" role="tabpanel" aria-labelledby="pills-user-tab-4">
                    <div class="row">
                        <h5 class="my-3 d-inline-block"><?php echo e(__('Attachments')); ?></h5>
                        <div class="col-3">
                            <div class="border card border-primary">
                                <div class="card-body table-border-style">
                                    <div class="col-md-12 dropzone browse-file" id="dropzonewidget">
                                        <div class="my-5 dz-message" data-dz-message>
                                            <span><?php echo e(__('Drop files here to upload')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="border card border-primary">
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
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bill_attachment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <td><?php echo e(++$key); ?></td>
                                                <td><?php echo e($attachment->file_name); ?></td>
                                                <td><?php echo e($attachment->file_size); ?></td>
                                                <td><?php echo e(company_date_formate($attachment->created_at)); ?></td>
                                                <td>
                                                    <div class="action-btn  me-2">
                                                        <a href="<?php echo e(url($attachment->file_path)); ?>"
                                                            class="mx-3 btn btn-sm align-items-center bg-primary"
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>"
                                                            target="_blank" download>
                                                            <i class="text-white ti ti-download"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn">
                                                        <?php echo e(Form::open(['route' => ['bill.attachment.destroy', $attachment->id], 'class' => 'm-0'])); ?>

                                                        <?php echo method_field('DELETE'); ?>
                                                        <a href="#"
                                                            class="bg-danger mx-3 btn btn-sm align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-confirm-yes="delete-form-<?php echo e($attachment->id); ?>">
                                                            <i class="text-white ti ti-trash"></i>
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
                <?php echo $__env->yieldPushContent('add_recurring_pills'); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bill->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($payment->add_receipt)): ?>
                                            <div class="action-btn  me-2">
                                                <a href="<?php echo e(get_file($payment->add_receipt)); ?>" download=""
                                                    class=" bg-primary mx-3 btn btn-sm align-items-center"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>"
                                                    target="_blank">
                                                    <i class="text-white ti ti-download"></i>
                                                </a>
                                            </div>
                                            <div class="action-btn">
                                                <a href="<?php echo e(get_file($payment->add_receipt)); ?>"
                                                    class="bg-secondary mx-3 btn btn-sm align-items-center"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Show')); ?>"
                                                    target="_blank">
                                                    <i class="text-white ti ti-crosshair"></i>
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bill\view.blade.php ENDPATH**/ ?>
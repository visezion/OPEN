<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Invoice Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Invoice Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <style>
        #card-element {
            border: 1px solid #a3afbb !important;
            border-radius: 10px !important;
            padding: 10px !important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
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
    <script src="<?php echo e(asset('assets/js/plugins/dropzone-amd-module.min.js')); ?>"></script>
    <script>
        Dropzone.autoDiscover = false;
        myDropzone = new Dropzone("#dropzonewidget", {
            url: "<?php echo e(route('invoice.file.upload', [$invoice->id])); ?>",
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
            formData.append("invoice_id", <?php echo e($invoice->id); ?>);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
    <div>
        <div class="d-flex">
            <a href="#" class="btn btn-sm btn-primary cp_link me-2  "
                data-link="<?php echo e(route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id))); ?>"
                data-bs-toggle="tooltip" title="<?php echo e(__('Copy')); ?>"
                data-original-title="<?php echo e(__('Click to copy invoice link')); ?>">
                <span class="btn-inner--icon text-white"><i class="ti ti-file"></i></span>
            </a>
            <a href="#" class="btn btn-sm btn-info align-items-center"
                data-url="<?php echo e(route('delivery-form.pdf', \Crypt::encrypt($invoice->id))); ?>" data-ajax-popup="true"
                data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Invoice Delivery Form')); ?>"
                data-title="<?php echo e(__('Invoice Delivery Form')); ?>">
                <i class="ti ti-clipboard-list text-white"></i>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(\Auth::user()->type == 'company'): ?>
        <?php if($invoice->status != 4): ?>
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
                                    <h2 class="text-primary h5 mb-2"><?php echo e(__('Create Invoice')); ?></h2>
                                    <p class="text-sm mb-3">
                                        <?php echo e(__('Created on ')); ?><?php echo e(company_date_formate($invoice->issue_date, $invoice->created_by, $invoice->workspace)); ?>

                                    </p>
                                    <?php if (app('laratrust')->hasPermission('invoice edit')) : ?>
                                        <a href="<?php echo e(route('invoice.edit', \Crypt::encrypt($invoice->id))); ?>"
                                            class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                            data-original-title="<?php echo e(__('Edit')); ?>"><i
                                                class="ti ti-pencil me-1"></i><?php echo e(__('Edit')); ?></a>
                                    <?php endif; // app('laratrust')->permission ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="progress mb-3">
                                <div class="<?php echo e($invoice->status !== 0 ? 'progress-value' : ''); ?>"></div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <div class="timeline-icons ">
                                    <i class="ti ti-send text-warning"></i>
                                </div>
                                <div class="invoice-content">
                                    <h6 class="text-warning h5 mb-2"><?php echo e(__('Send Invoice')); ?></h6>
                                    <p class="text-sm mb-2">
                                        <?php if($invoice->status != 0): ?>
                                            <?php echo e(__('Sent on')); ?>

                                            <?php echo e(company_date_formate($invoice->send_date, $invoice->created_by, $invoice->workspace)); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Status')); ?> : <?php echo e(__('Not Sent')); ?>

                                        <?php endif; ?>
                                    </p>
                                    <?php echo $__env->yieldPushContent('recurring_type'); ?>
                                    <?php if($invoice->status == 0): ?>
                                        <?php if (app('laratrust')->hasPermission('invoice send')) : ?>
                                            <a href="<?php echo e(route('invoice.sent', $invoice->id)); ?>" class="btn btn-sm btn-warning"
                                                data-bs-toggle="tooltip" data-original-title="<?php echo e(__('Mark Sent')); ?>"><i
                                                    class="ti ti-send me-1"></i><?php echo e(__('Send')); ?></a>
                                        <?php endif; // app('laratrust')->permission ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="progress mb-3">
                                <div class="<?php echo e($invoice->status == 4 ? 'progress-value' : ''); ?>"></div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <div class="timeline-icons ">
                                    <i class="ti ti-report-money text-info"></i>
                                </div>
                                <div class="invoice-content">
                                    <h6 class="text-info h5 mb-2"><?php echo e(__('Get Paid')); ?></h6>
                                    <p class=" text-sm mb-3"><?php echo e(__('Status')); ?> :
                                        <?php if($invoice->status == 0): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 1): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 2): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 3): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 4): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php endif; ?>
                                    </p>
                                    <?php if($invoice->status != 0): ?>
                                        <?php if (app('laratrust')->hasPermission('invoice payment create')) : ?>
                                            <a href="#" data-url="<?php echo e(route('invoice.payment', $invoice->id)); ?>"
                                                data-ajax-popup="true" data-title="<?php echo e(__('Add Payment')); ?>"
                                                class="btn btn-sm btn-light" data-original-title="<?php echo e(__('Add Payment')); ?>"><i
                                                    class="ti ti-report-money me-1"></i><?php echo e(__('Add Payment')); ?></a> <br>
                                        <?php endif; // app('laratrust')->permission ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($invoice->status != 0 && \Auth::user()->type == 'company'): ?>
        <div class="row row-gap justify-content-between align-items-center mb-3">
            <div class="col-md-6">
                <ul class="nav nav-pills nav-fill cust-nav information-tab invoice-tab" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="invoice-tab" data-bs-toggle="pill" data-bs-target="#invoice"
                            type="button"><?php echo e(__('Invoice')); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="receipt-summary-tab" data-bs-toggle="pill"
                            data-bs-target="#receipt-summary" type="button"><?php echo e(__('Receipt Summary')); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="credit-summary-tab" data-bs-toggle="pill"
                            data-bs-target="#credit-summary" type="button"><?php echo e(__('Credit Note Summary')); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invoice-attechment-tab" data-bs-toggle="pill"
                            data-bs-target="#invoice-attechment" type="button"><?php echo e(__('Attachment')); ?></button>
                    </li>
                    <?php echo $__env->yieldPushContent('add_recurring_tab'); ?>
                </ul>
            </div>

            <div
                class="col-md-6 apply-wrp d-flex flex-wrap gap-2 align-items-center justify-content-start justify-content-md-end">
                <?php if (app('laratrust')->hasPermission('creditnote create')) : ?>
                    <?php if(!empty($customer) && $invoice->status != 4): ?>
                        <div class="all-button-box">
                            <a href="#" class="btn btn-sm btn-primary"
                                data-url="<?php echo e(route('invoice.credit.note', $invoice->id)); ?>" data-ajax-popup="true"
                                data-title="<?php echo e(__('Apply Credit Note')); ?>">
                                <?php echo e(__('Apply Credit Note')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; // app('laratrust')->permission ?>

                <?php if($invoice->status != 4): ?>
                    <div class="all-button-box">
                        <a href="<?php echo e(route('invoice.payment.reminder', $invoice->id)); ?>"
                            class="btn btn-sm btn-primary"><?php echo e(__('Receipt Reminder')); ?></a>
                    </div>
                <?php endif; ?>

                <div class="all-button-box">
                    <a href="<?php echo e(route('invoice.resent', $invoice->id)); ?>"
                        class="btn btn-sm btn-primary"><?php echo e(__('Resend Invoice')); ?></a>
                </div>

                <div class="all-button-box">
                    <a href="<?php echo e(route('invoice.pdf', Crypt::encrypt($invoice->id))); ?>" target="_blank"
                        class="btn btn-sm btn-primary"><?php echo e(__('Download')); ?></a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                <div class="all-button-box">
                    <a href="<?php echo e(route('invoice.pdf', Crypt::encrypt($invoice->id))); ?>" target="_blank"
                        class="btn btn-sm btn-primary">
                        <?php echo e(__('Download')); ?>

                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="invoice" role="tabpanel"
                    aria-labelledby="pills-user-tab-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice">
                                <div class="invoice-print">
                                    <div
                                        class="d-flex flex-wrap align-items-center justify-content-between row-gap invoice-title border-1 border-bottom  pb-3 mb-3">
                                        <div>
                                            <h2 class="h3 mb-0"><?php echo e(__('Invoice')); ?></h2>
                                        </div>
                                        <div>
                                            <div class="d-flex invoice-wrp flex-wrap align-items-center gap-md-2 gap-1">
                                                <div
                                                    class="d-flex invoice-date flex-wrap align-items-center gap-md-3 gap-1">
                                                    <p class="mb-0"><strong><?php echo e(__('Issue Date')); ?> :</strong>
                                                        <?php echo e(company_date_formate($invoice->issue_date)); ?>

                                                    </p>
                                                    <p class="mb-0"><strong><?php echo e(__('Due Date')); ?> :</strong>
                                                        <?php echo e(company_date_formate($invoice->due_date)); ?>

                                                    </p>
                                                </div>
                                                <h3 class="invoice-number mb-0">
                                                    <?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id)); ?>

                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-sm-4 p-3 invoice-billed">
                                        <div class="row row-gap">
                                            <?php if(
                                                $invoice->invoice_module == 'taskly' ||
                                                    $invoice->invoice_module == 'account' ||
                                                    $invoice->invoice_module == 'cmms' ||
                                                    $invoice->invoice_module == 'cardealership' ||
                                                    $invoice->invoice_module == 'musicinstitute' ||
                                                    $invoice->invoice_module == 'rent'): ?>
                                                <div class="col-lg-4 col-sm-6">
                                                    <p class="mb-3">
                                                        <strong class="h5 mb-1"><?php echo e(__('Name ')); ?> :
                                                        </strong><?php echo e(!empty($customer->name) ? $customer->name : ''); ?>

                                                    </p>

                                                    <?php if(!empty($customer->billing_name) && !empty($customer->billing_address) && !empty($customer->billing_zip)): ?>
                                                        <p class="mb-2"><strong
                                                                class="h5 mb-1 d-block"><?php echo e(__('Billed To')); ?>

                                                                :</strong>
                                                            <span class="text-muted d-block" style="max-width:80%">
                                                                <?php echo e(!empty($customer->billing_name) ? $customer->billing_name : ''); ?>

                                                                <?php echo e(!empty($customer->billing_address) ? $customer->billing_address : ''); ?>

                                                                <?php echo e(!empty($customer->billing_city) ? $customer->billing_city . ' ,' : ''); ?>

                                                                <?php echo e(!empty($customer->billing_state) ? $customer->billing_state . ' ,' : ''); ?>

                                                                <?php echo e(!empty($customer->billing_zip) ? $customer->billing_zip : ''); ?>

                                                                <?php echo e(!empty($customer->billing_country) ? $customer->billing_country : ''); ?>

                                                            </span>
                                                        </p>
                                                        <p class="mb-1 text-dark">
                                                            <?php echo e(!empty($customer->billing_phone) ? $customer->billing_phone : ''); ?>

                                                        </p>
                                                        <p class="mb-0">
                                                            <strong><?php echo e(__('Tax Number ')); ?> :
                                                            </strong><?php echo e(!empty($customer->tax_number) ? $customer->tax_number : ''); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-lg-4 col-sm-6">
                                                    <p class="mb-3">
                                                        <strong class="h5 mb-1"><?php echo e(__('Email ')); ?> :
                                                        </strong><?php echo e(!empty($customer->email) ? $customer->email : ''); ?>

                                                    </p>

                                                    <?php if(!empty($company_settings['invoice_shipping_display']) && ($company_settings['invoice_shipping_display'] == 'on')): ?>
                                                        <?php if(!empty($customer->shipping_name) && !empty($customer->shipping_address) && !empty($customer->shipping_zip)): ?>
                                                            <p class="mb-2">
                                                                <strong class="h5 mb-1 d-block"><?php echo e(__('Shipped To')); ?>

                                                                    :</strong>
                                                                <span class="text-muted d-block" style="max-width:80%">
                                                                    <?php echo e(!empty($customer->shipping_name) ? $customer->shipping_name : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_address) ? $customer->shipping_address : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_city) ? $customer->shipping_city . ' ,' : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_state) ? $customer->shipping_state . ' ,' : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_zip) ? $customer->shipping_zip : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_country) ? $customer->shipping_country : ''); ?>

                                                                </span>
                                                            </p>
                                                            <p class="mb-1 text-dark">
                                                                <?php echo e(!empty($customer->shipping_phone) ? $customer->shipping_phone : ''); ?>

                                                            </p>
                                                            <p class="mb-0">
                                                                <strong><?php echo e(__('Tax Number ')); ?> :
                                                                </strong><?php echo e(!empty($customer->tax_number) ? $customer->tax_number : ''); ?>

                                                            </p>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if($invoice->invoice_module == 'mobileservice' && !empty($mobileCustomer)): ?>
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="customer_name"
                                                                class="form-label"><?php echo e(__('Customer Name : ')); ?></label><br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo e($mobileCustomer->customer_name); ?>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="sender_mobileno"
                                                                class="form-label"><?php echo e(__('Customer Mobile No : ')); ?></label><br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo e($mobileCustomer->mobile_no); ?>


                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="sender_email"
                                                                class="form-label"><?php echo e(__('Customer Email Address : ')); ?></label><br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo e($mobileCustomer->email); ?>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="sender_email"
                                                                class="form-label"><?php echo e(__('Created By : ')); ?></label><br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo e($mobileCustomer->getServiceCreatedName->name); ?>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="sender_email"
                                                                class="form-label"><?php echo e(__('Request Status : ')); ?></label><br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span
                                                                class="badge fix_badge <?php if($mobileCustomer->is_approve == 1): ?> bg-success <?php else: ?> bg-danger <?php endif; ?>  p-2 px-3">
                                                                <?php if($mobileCustomer->is_approve == 1): ?>
                                                                    <?php echo e(__('Accepted')); ?>

                                                                <?php else: ?>
                                                                    <?php echo e(__('Rejected')); ?>

                                                                <?php endif; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if(
                                                ($invoice->invoice_module == 'legalcase' ||
                                                    $invoice->invoice_module == 'lms' ||
                                                    $invoice->invoice_module == 'sales' ||
                                                    $invoice->invoice_module == 'newspaper' ||
                                                    $invoice->invoice_module == 'RestaurantMenu' ||
                                                    $invoice->invoice_module == 'Fleet') &&
                                                    !empty($commonCustomer)): ?>
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="customer_name"
                                                                class="form-label"><?php echo e(__('Name : ')); ?></label><br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo e($commonCustomer['name']); ?>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="customer_name"
                                                                class="form-label"><?php echo e(__('Email : ')); ?></label><br>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo e($commonCustomer['email']); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if($invoice->invoice_module == 'childcare' && !empty($childCustomer)): ?>
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-md-5 col-12">
                                                            <h6><?php echo e(__('Child Detail')); ?></h6>
                                                            <p>
                                                                <span><b><?php echo e(__('Name :')); ?> </b>
                                                                    <?php echo e($childCustomer['child']->first_name . ' ' . $childCustomer['child']->last_name); ?>

                                                                </span><br>
                                                                <span><b><?php echo e(__('Date Of Birth :')); ?>

                                                                    </b><?php echo e($childCustomer['child']->dob); ?></span><br>
                                                                <span><b><?php echo e(__('Gender :')); ?>

                                                                    </b><?php echo e($childCustomer['child']->gender); ?></span><br>
                                                                <span><b><?php echo e(__('Age :')); ?>

                                                                    </b><?php echo e($childCustomer['child']->age); ?></span><br>
                                                                <span><b><?php echo e(__('Class :')); ?> </b>
                                                                    <?php echo e(!empty($childCustomer['child']->class) ? $childCustomer['child']->class->class_level : ''); ?></span><br>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-5 col-12">
                                                            <h6><?php echo e(__('Parent Detail')); ?></h6>
                                                            <p>
                                                                <span><b><?php echo e(__('Name :')); ?>

                                                                    </b><?php echo e($childCustomer['parent']->name); ?></span><br>
                                                                <span><b><?php echo e(__('Email : ')); ?></b>
                                                                    <?php echo e($childCustomer['parent']->email); ?></span><br>
                                                                <span><b><?php echo e(__('Contact Number :')); ?> </b>
                                                                    <?php echo e($childCustomer['parent']->contact_number); ?></span><br>
                                                                <span><b><?php echo e(__('Address :')); ?> </b>
                                                                    <?php echo e($childCustomer['parent']->address); ?></span><br>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if($invoice->invoice_module == 'vehicleinspection'): ?>
                                                <?php
                                                    $inspectionRequest = Workdo\VehicleInspectionManagement\Entities\InspectionRequest::find(
                                                        $invoice->customer_id,
                                                    );
                                                    $vehicle_details = Workdo\VehicleInspectionManagement\Entities\InspectionVehicle::find(
                                                        $inspectionRequest->vehicle_id,
                                                    );
                                                ?>
                                                <?php if(!empty($inspectionRequest->inspector_name) && !empty($inspectionRequest->inspector_email)): ?>
                                                    <div class="col">
                                                        <p class="font-style">
                                                            <strong class="h5 mb-1 d-block"><?php echo e(__('Request Number')); ?>

                                                                :</strong>
                                                            <?php echo e(!empty($invoice->customer_id) ? \Workdo\VehicleInspectionManagement\Entities\InspectionRequest::inspectionRequestIdFormat($invoice->customer_id, $invoice->created_by, $invoice->workspace) : ''); ?>

                                                        </p>
                                                        <p class="font-style">
                                                            <strong class="h5 mb-1 d-block"><?php echo e(__('Billed To')); ?>

                                                                :</strong>
                                                            <?php echo e(!empty($inspectionRequest->inspector_name) ? $inspectionRequest->inspector_name : ''); ?><br>
                                                            <?php echo e(!empty($inspectionRequest->inspector_email) ? $inspectionRequest->inspector_email : ''); ?>

                                                        </p>
                                                    </div>
                                                    <div class="col">
                                                        <p class="font-style">
                                                            <strong class="h5 mb-1 d-block"><?php echo e(__('Vehicle Details')); ?>

                                                                :</strong>
                                                        <dl class="row align-items-center">
                                                            <dt class="col-sm-6">
                                                                <?php echo e(__('Model')); ?>

                                                            </dt>
                                                            <dd class="col-sm-6  ms-0" style="margin-bottom: 0px;"> :
                                                                <?php echo e(!empty($vehicle_details->model) ? $vehicle_details->model : ''); ?>

                                                            </dd>
                                                            <dt class="col-sm-6">
                                                                <?php echo e(__('ID Number')); ?>

                                                            </dt>
                                                            <dd class="col-sm-6  ms-0" style="margin-bottom: 0px;"> :
                                                                <?php echo e(!empty($vehicle_details->vehicle_id_number) ? $vehicle_details->vehicle_id_number : ''); ?>

                                                            </dd>
                                                            <dt class="col-sm-6">
                                                                <?php echo e(__('Current Mileage')); ?>

                                                            </dt>
                                                            <dd class="col-sm-6  ms-0" style="margin-bottom: 0px;"> :
                                                                <?php echo e(!empty($vehicle_details->mileage) ? $vehicle_details->mileage : ''); ?>

                                                            </dd>
                                                            <dt class="col-sm-6">
                                                                <?php echo e(__('Manufacture Year')); ?>

                                                            </dt>
                                                            <dd class="col-sm-6  ms-0" style="margin-bottom: 0px;"> :
                                                                <?php echo e(!empty($vehicle_details->manufacture_year) ? $vehicle_details->manufacture_year : ''); ?>

                                                            </dd>
                                                        </dl>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if($invoice->invoice_module == 'machinerepair' && !empty($invoice->customer_id)): ?>
                                                <?php
                                                    $repair_request = \Workdo\MachineRepairManagement\Entities\MachineRepairRequest::find(
                                                        $invoice->customer_id,
                                                    );
                                                    $machine_details = \Workdo\MachineRepairManagement\Entities\Machine::find(
                                                        $repair_request->machine_id,
                                                    );
                                                ?>
                                                <div class="col">
                                                    <p class="font-style">
                                                        <strong><?php echo e(__('Request Number')); ?> :</strong><br>
                                                        <?php echo e(!empty($invoice->customer_id) ? \Workdo\MachineRepairManagement\Entities\MachineRepairRequest::machineRepairNumberFormat($invoice->customer_id, $invoice->created_by, $invoice->workspace) : ''); ?><br>
                                                    </p>
                                                    <p class="font-style">
                                                        <strong><?php echo e(__('Billed To')); ?> :</strong><br>
                                                        <?php echo e(!empty($repair_request->customer_name) ? $repair_request->customer_name : ''); ?><br>
                                                        <?php echo e(!empty($repair_request->customer_email) ? $repair_request->customer_email : ''); ?><br>
                                                    </p>
                                                </div>

                                                <div class="col">
                                                    <p class="font-style">
                                                        <strong><?php echo e(__('Machine Details')); ?> :</strong><br>
                                                    <dl class="row align-items-center">
                                                        <dt class="col-sm-4" style="font-weight: 600;">
                                                            <?php echo e(__('Name')); ?>

                                                        </dt>
                                                        <dd class="col-sm-8  ms-0" style="margin-bottom: 0px;"> :
                                                            <?php echo e(!empty($machine_details->name) ? $machine_details->name : ''); ?>

                                                        </dd>
                                                        <dt class="col-sm-4" style="font-weight: 600;">
                                                            <?php echo e(__('Model')); ?>

                                                        </dt>
                                                        <dd class="col-sm-8  ms-0" style="margin-bottom: 0px;"> :
                                                            <?php echo e(!empty($machine_details->model) ? $machine_details->model : ''); ?>

                                                        </dd>
                                                        <dt class="col-sm-4" style="font-weight: 600;">
                                                            <?php echo e(__('Manufacturer')); ?>

                                                        </dt>
                                                        <dd class="col-sm-8  ms-0" style="margin-bottom: 0px;"> :
                                                            <?php echo e(!empty($machine_details->manufacturer) ? $machine_details->manufacturer : ''); ?>

                                                        </dd>
                                                    </dl>
                                                    </p>
                                                </div>
                                            <?php endif; ?>

                                            <div class="col-lg-4 col-sm-6">
                                                <div class="d-flex flex-wrap justify-content-between gap-3">
                                                    <div>
                                                        <strong class="h5 d-block mb-2"><?php echo e(__('Status')); ?> :</strong>
                                                        <?php if($invoice->status == 0): ?>
                                                            <span
                                                                class="badge fix_badge f-12 p-2 d-inline-block bg-info"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                        <?php elseif($invoice->status == 1): ?>
                                                            <span
                                                                class="badge fix_badge f-12 p-2 d-inline-block bg-primary"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                        <?php elseif($invoice->status == 2): ?>
                                                            <span
                                                                class="badge fix_badge f-12 p-2 d-inline-block bg-secondary"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                        <?php elseif($invoice->status == 3): ?>
                                                            <span
                                                                class="badge fix_badge f-12 p-2 d-inline-block bg-warning"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                        <?php elseif($invoice->status == 4): ?>
                                                            <span
                                                                class="badge fix_badge f-12 p-2 d-inline-block bg-success"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <?php if(!empty($company_settings['invoice_qr_display']) && $company_settings['invoice_qr_display'] == 'on'): ?>
                                                        <div class="float-sm-end qr-code">
                                                            <?php if(module_is_active('Zatca')): ?>
                                                                <div class="float-sm-end w-100">
                                                                    <?php echo $__env->make('zatca::zatca_qr_code', [
                                                                        'invoice_id' => $invoice->id,
                                                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="float-sm-end invoice-qr-inner w-100">
                                                                    <?php echo DNS2D::getBarcodeHTML(
                                                                        route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id)),
                                                                        'QRCODE',
                                                                        2,
                                                                        2,
                                                                    ); ?>

                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if(!empty($customFields) && count($invoice->customField) > 0): ?>
                                        <div class="px-4 mt-3">
                                            <div class="row row-gap">
                                                <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-xxl-3 col-sm-6">
                                                        <strong class="d-block mb-1"><?php echo e($field->name); ?> </strong>
                                                        <?php if($field->type == 'attachment'): ?>
                                                            <a href="<?php echo e(get_file($invoice->customField[$field->id])); ?>"
                                                                target="_blank">
                                                                <img src=" <?php echo e(get_file($invoice->customField[$field->id])); ?> "
                                                                    class="wid-120 rounded">
                                                            </a>
                                                        <?php else: ?>
                                                            <p class="mb-0">
                                                                <?php echo e(!empty($invoice->customField[$field->id]) ? $invoice->customField[$field->id] : '-'); ?>

                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="invoice-summary mt-3">
                                        <div class="invoice-title border-1 border-bottom mb-3 pb-2">
                                            <h3 class="h4 mb-0"><?php echo e(__('Item Summary')); ?></h3>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <table class="table mb-0 table-striped">
                                                <tr>
                                                    <th data-width="40" class="text-white bg-primary text-uppercase">#
                                                    </th>
                                                    <?php if(
                                                        $invoice->invoice_module == 'account' ||
                                                            $invoice->invoice_module == 'cmms' ||
                                                            $invoice->invoice_module == 'rent' ||
                                                            $invoice->invoice_module == 'machinerepair' ||
                                                            $invoice->invoice_module == 'musicinstitute' ||
                                                            $invoice->invoice_module == 'vehicleinspection'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Item Type')); ?></th>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Item')); ?></th>
                                                    <?php elseif($invoice->invoice_module == 'taskly'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Project')); ?></th>
                                                    <?php elseif($invoice->invoice_module == 'lms'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Course')); ?></th>
                                                    <?php elseif($invoice->invoice_module == 'childcare'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Name')); ?></th>
                                                    <?php elseif(
                                                        $invoice->invoice_module == 'cardealership' ||
                                                            $invoice->invoice_module == 'sales' ||
                                                            $invoice->invoice_module == 'newspaper' ||
                                                            $invoice->invoice_module == 'mobileservice'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Items')); ?></th>
                                                    <?php elseif($invoice->invoice_module == 'legalcase'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('PARTICULARS')); ?></th>
                                                    <?php elseif($invoice->invoice_module == 'Fleet'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Distance')); ?></th>
                                                    <?php elseif($invoice->invoice_module == 'RestaurantMenu'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Item Name')); ?></th>
                                                    <?php endif; ?>
                                                    <?php if(
                                                        $invoice->invoice_module !== 'Fleet' &&
                                                            $invoice->invoice_module !== 'taskly' &&
                                                            $invoice->invoice_module !== 'childcare'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Quantity')); ?></th>
                                                    <?php endif; ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Rate')); ?>

                                                    </th>
                                                    <?php if($invoice->invoice_module != 'Fleet' && $invoice->invoice_module != 'childcare'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Discount')); ?></th>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Tax')); ?></th>
                                                    <?php endif; ?>
                                                    <th class="text-white bg-primary text-uppercase">
                                                        <?php echo e(__('Description')); ?></th>
                                                    <th class="text-right text-white bg-primary text-uppercase"
                                                        width="12%"><?php echo e(__('Price')); ?></th>
                                                </tr>
                                                <?php
                                                    $totalQuantity = 0;
                                                    $totalRate = 0;
                                                    $totalTaxPrice = 0;
                                                    $totalDiscount = 0;
                                                    $commonSubtotal = 0;
                                                    $taxesData = [];
                                                    $TaxPrice_array = [];
                                                ?>

                                                <?php $__currentLoopData = $iteams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $iteam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $commonSubtotal += $iteam->price;
                                                    ?>
                                                    <?php if(!empty($iteam->tax)): ?>
                                                        <?php
                                                        if ($invoice->invoice_module == 'newspaper'){
                                                            $taxes = \Workdo\Newspaper\Entities\NewspaperTax::tax($iteam->tax);
                                                            $totalQuantity += $iteam->quantity;
                                                            $totalRate += $iteam->price;

                                                            foreach ($taxes as $taxe) {
                                                                $taxDataPrice = \Workdo\Newspaper\Entities\NewspaperTax::taxRate(
                                                                    $taxe->percentage,
                                                                    $iteam->price,
                                                                    $iteam->quantity
                                                                );
                                                                if (array_key_exists($taxe->name, $taxesData)) {
                                                                    $taxesData[$taxe->name] =
                                                                        $taxesData[$taxe->name] + $taxDataPrice;
                                                                } else {
                                                                    $taxesData[$taxe->name] = $taxDataPrice;
                                                                }
                                                            }
                                                        }
                                                        else{
                                                            $taxes = \App\Models\Invoice::tax($iteam->tax);
                                                            $totalQuantity += $iteam->quantity;
                                                            $totalRate += $iteam->price;
                                                            $totalDiscount += $iteam->discount;

                                                            foreach ($taxes as $taxe) {
                                                                $taxDataPrice = \App\Models\Invoice::taxRate(
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
                                                        }
                                                        ?>
                                                    <?php elseif($invoice->invoice_module == 'Fleet'): ?>
                                                        <?php
                                                            $totalRate += $iteam->price;
                                                        ?>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <td><?php echo e($key + 1); ?></td>
                                                        <?php if(
                                                            $invoice->invoice_module == 'account' ||
                                                                $invoice->invoice_module == 'machinerepair' ||
                                                                $invoice->invoice_module == 'musicinstitute' ||
                                                                $invoice->invoice_module == 'vehicleinspection'): ?>
                                                            <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?>

                                                            </td>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                                            </td>
                                                        <?php elseif($invoice->invoice_module == 'taskly'): ?>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->title : ''); ?>

                                                            </td>
                                                        <?php elseif($invoice->invoice_module == 'cmms' || $invoice->invoice_module == 'rent'): ?>
                                                            <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?>

                                                            </td>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                                            </td>
                                                        <?php elseif($invoice->invoice_module == 'lms'): ?>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->title : ''); ?>

                                                            </td>
                                                        <?php elseif($invoice->invoice_module == 'childcare' || $invoice->invoice_module == 'legalcase'): ?>
                                                            <td><?php echo e(!empty($iteam->product_name) ? $iteam->product_name : ''); ?>

                                                            </td>
                                                        <?php elseif(
                                                            $invoice->invoice_module == 'cardealership' ||
                                                                $invoice->invoice_module == 'sales' ||
                                                                $invoice->invoice_module == 'newspaper' ||
                                                                $invoice->invoice_module == 'mobileservice'): ?>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                                            </td>
                                                        <?php elseif($invoice->invoice_module == 'RestaurantMenu'): ?>
                                                            <td><?php echo e(!empty($iteam->product_name) ? $iteam->product_name : ''); ?>

                                                            </td>
                                                        <?php endif; ?>

                                                        <?php if($invoice->invoice_module == 'Fleet'): ?>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->distance : 0); ?>

                                                            </td>
                                                        <?php elseif($invoice->invoice_module == 'taskly' || $invoice->invoice_module == 'childcare'): ?>
                                                        <?php else: ?>
                                                            <td><?php echo e($iteam->quantity); ?></td>
                                                        <?php endif; ?>

                                                        <td><?php echo e(currency_format_with_sym($iteam->price)); ?></td>
                                                        <?php if($invoice->invoice_module != 'Fleet' && $invoice->invoice_module != 'childcare'): ?>
                                                            <td><?php echo e(currency_format_with_sym($iteam->discount)); ?></td>
                                                            <td>
                                                                <?php if(!empty($iteam->tax)): ?>
                                                                    <table class="w-100">
                                                                        <?php
                                                                            $totalTaxRate = 0;
                                                                            $data = 0;
                                                                        ?>
                                                                        <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php
                                                                            if ($invoice->invoice_module == 'newspaper'){
                                                                                $taxPrice = \Workdo\Newspaper\Entities\NewspaperTax::taxRate(
                                                                                    $tax->percentage,
                                                                                    $iteam->price,
                                                                                    $iteam->quantity
                                                                                );
                                                                            }
                                                                            else {
                                                                                $taxPrice = \App\Models\Invoice::taxRate(
                                                                                    $tax->rate,
                                                                                    $iteam->price,
                                                                                    $iteam->quantity,
                                                                                    $iteam->discount,
                                                                                );
                                                                            }
                                                                            $totalTaxPrice += $taxPrice;
                                                                            $data += $taxPrice;
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo e($tax->name . ' (' . $tax->rate . '%)'); ?>

                                                                                    <?php echo e(currency_format_with_sym($taxPrice)); ?>

                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            array_push($TaxPrice_array, $data);
                                                                        ?>
                                                                    </table>
                                                                <?php else: ?>
                                                                    -
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endif; ?>
                                                        <td><?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?>

                                                        </td>
                                                        <?php
                                                            $tr_tex =
                                                                array_key_exists($key, $TaxPrice_array) == true
                                                                    ? $TaxPrice_array[$key]
                                                                    : 0;
                                                        ?>
                                                        <td class="">
                                                            <?php if($invoice->invoice_module == 'childcare'): ?>
                                                                <?php echo e(currency_format_with_sym($iteam->price)); ?>

                                                            <?php elseif($invoice->invoice_module == 'Fleet'): ?>
                                                                <?php
                                                                    $distance = !empty($iteam->product())
                                                                        ? $iteam->product()->distance
                                                                        : 0;
                                                                    $price =
                                                                        $iteam->price * $iteam->product()->distance;
                                                                ?>
                                                                <?php echo e(currency_format_with_sym($price)); ?>

                                                            <?php else: ?>
                                                                <?php echo e(currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $tr_tex)); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <?php if($invoice->invoice_module == 'account'): ?>
                                                            <td></td>
                                                        <?php endif; ?>

                                                        <?php if(
                                                            $invoice->invoice_module == 'cmms' ||
                                                                $invoice->invoice_module == 'rent' ||
                                                                $invoice->invoice_module == 'vehicleinspection' ||
                                                                $invoice->invoice_module == 'musicinstitute' ||
                                                                $invoice->invoice_module == 'machinerepair'): ?>
                                                            <td></td>
                                                            <td class="bg-color "><b><?php echo e(__('Total')); ?></b></td>
                                                        <?php else: ?>
                                                            <td class="bg-color "><b><?php echo e(__('Total')); ?></b></td>
                                                        <?php endif; ?>

                                                        <?php if($invoice->invoice_module == 'Fleet'): ?>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalRate)); ?></b></td>
                                                        <?php elseif($invoice->invoice_module == 'taskly'): ?>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalRate)); ?></b></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalDiscount)); ?></b></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalTaxPrice)); ?></b></td>
                                                        <?php elseif($invoice->invoice_module == 'cmms'): ?>
                                                            <td class="bg-color"><b><?php echo e($totalQuantity); ?></b></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalRate)); ?></b></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalDiscount)); ?></b></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalTaxPrice)); ?></b></td>
                                                        <?php elseif($invoice->invoice_module == 'childcare'): ?>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($commonSubtotal)); ?></b>
                                                            </td>
                                                        <?php else: ?>
                                                            <td class="bg-color"><b><?php echo e($totalQuantity); ?></b></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalRate)); ?></b></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalDiscount)); ?></b></td>
                                                            <td class="bg-color">
                                                                <b><?php echo e(currency_format_with_sym($totalTaxPrice)); ?></b></td>
                                                        <?php endif; ?>
                                                    </tr>

                                                    <?php
                                                        $colspan = 6;
                                                        $customerInvoices = ['taskly', 'account', 'cmms', 'cardealership', 'RestaurantMenu', 'rent' , 'Fleet','vehicleinspection','machinerepair'];
                                                        if (in_array($invoice->invoice_module, $customerInvoices)) {
                                                            $colspan = 7;
                                                        }

                                                        if ($invoice->invoice_module == 'taskly') {
                                                            $colspan = 5;
                                                        }

                                                        if (
                                                            $invoice->invoice_module == 'Fleet' || $invoice->invoice_module == 'childcare'
                                                        ) {
                                                            $colspan = 3;
                                                        }
                                                    ?>

                                                    <?php if($invoice->invoice_module != 'Fleet'): ?>
                                                        <tr>
                                                            <td colspan="<?php echo e($colspan); ?>"></td>
                                                            <td class="text-right"><?php echo e(__('Sub Total')); ?></td>
                                                            <td class="text-right">
                                                                <?php if($invoice->invoice_module == 'childcare'): ?>
                                                                    <b><?php echo e(currency_format_with_sym($commonSubtotal)); ?></b>
                                                                <?php else: ?>
                                                                    <b><?php echo e(currency_format_with_sym($invoice->getSubTotal())); ?></b>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <?php if($invoice->invoice_module != 'childcare'): ?>
                                                            <tr>
                                                                <td colspan="<?php echo e($colspan); ?>"></td>
                                                                <td class="text-right"><?php echo e(__('Discount')); ?></td>
                                                                <td class="text-right">
                                                                    <b><?php echo e(currency_format_with_sym($invoice->getTotalDiscount())); ?></b>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                    <?php if(!empty($taxesData)): ?>
                                                        <?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td colspan="<?php echo e($colspan); ?>"></td>
                                                                <td class="text-right"><?php echo e($taxName); ?></td>
                                                                <td class="text-right">
                                                                    <b><?php echo e(currency_format_with_sym($taxPrice)); ?></b></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>

                                                    <?php if($invoice->invoice_module == 'machinerepair' || $invoice->invoice_module == 'mobileservice' || $invoice->invoice_module == 'vehicleinspection'): ?>
                                                        <tr>
                                                            <td colspan="<?php echo e($colspan); ?>"></td>
                                                            <td class="text-right"><?php echo e(__('Service Charge')); ?></td>
                                                            <td class="text-right">
                                                                <b><?php echo e(currency_format_with_sym($invoice->category_id)); ?></b></td>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="blue-text text-right"><?php echo e(__('Total')); ?></td>
                                                        <td class="blue-text text-right">
                                                            <?php if($invoice->invoice_module == 'childcare'): ?>
                                                                <b><?php echo e(currency_format_with_sym($commonSubtotal)); ?></b>
                                                            <?php elseif($invoice->invoice_module == 'Fleet'): ?>
                                                                <b><?php echo e(currency_format_with_sym($invoice->getFleetSubTotal())); ?></b>
                                                            <?php else: ?>
                                                                <b><?php echo e(currency_format_with_sym($invoice->getTotal())); ?></b>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Paid')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($invoice->getTotal() - $invoice->getDue() - $invoice->invoiceTotalCreditNote())); ?></b>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Credit Note Applied')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($invoice->invoiceTotalCreditNote())); ?></b>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Credit note issued')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($invoice->invoiceTotalCustomerCreditNote())); ?></b>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Due')); ?></td>
                                                        <td class="text-right">
                                                            <b><?php echo e(currency_format_with_sym($invoice->getDue())); ?></b></td>
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

                <div class="tab-pane fade" id="receipt-summary" role="tabpanel" aria-labelledby="pills-user-tab-2">
                    
                    <div class="card">
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table mb-0 pc-dt-simple" id="invoice-receipt-summary">
                                    <thead>
                                        <tr>
                                            <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Payment Type')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                            <th class="text-dark"><?php echo e(__('Receipt')); ?></th>
                                            <th class="text-dark"><?php echo e(__('OrderId')); ?></th>
                                            <?php if (app('laratrust')->hasPermission('invoice payment delete')) : ?>
                                                <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                            <?php endif; // app('laratrust')->permission ?>
                                        </tr>
                                    </thead>
                                    <?php if(!empty($invoice->payments) || !empty($bank_transfer_payments)): ?>
                                        <?php $__currentLoopData = $bank_transfer_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank_transfer_payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(company_datetime_formate($bank_transfer_payment->created_at)); ?>

                                                </td>
                                                <td class="text-right">
                                                    <?php echo e(currency_format_with_sym($bank_transfer_payment->price)); ?></td>
                                                <td><?php echo e($bank_transfer_payment->payment_type); ?></td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>
                                                    <?php if(!empty($bank_transfer_payment->attachment)): ?>
                                                        <a href="<?php echo e(get_file($bank_transfer_payment->attachment)); ?>"
                                                            target="_blank"> <i class="ti ti-file"></i></a>
                                                    <?php else: ?>
                                                        --
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($bank_transfer_payment->order_id); ?></td>
                                                <td>
                                                    <div class="action-btn me-2">
                                                        <?php if($bank_transfer_payment->payment_type == 'Bank Transfer'): ?>
                                                            <a class="mx-3 btn btn-sm  align-items-center bg-primary"
                                                                data-url="<?php echo e(route('invoice.bank.request.edit', $bank_transfer_payment->id)); ?>"
                                                                data-ajax-popup="true" data-size="md"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-title="<?php echo e(__('Request Action')); ?>"
                                                                data-bs-original-title="<?php echo e(__('Action')); ?>">
                                                                <i class="ti ti-caret-right text-white"></i>
                                                            </a>
                                                        <?php elseif($bank_transfer_payment->payment_type == 'Bank Account'): ?>
                                                            <a class="mx-3 btn btn-sm  align-items-center bg-primary"
                                                                data-url="<?php echo e(route('invoice.bankaccount.request.edit', $bank_transfer_payment->id)); ?>"
                                                                data-ajax-popup="true" data-size="md"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-title="<?php echo e(__('Request Action')); ?>"
                                                                data-bs-original-title="<?php echo e(__('Action')); ?>">
                                                                <i class="ti ti-caret-right text-white"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="action-btn">
                                                        <?php if($bank_transfer_payment->payment_type == 'Bank Transfer'): ?>
                                                            <?php echo e(Form::open(['route' => ['bank-transfer-request.destroy', $bank_transfer_payment->id], 'class' => 'm-0'])); ?>

                                                            <?php echo method_field('DELETE'); ?>
                                                            <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                data-confirm-yes="delete-form-<?php echo e($bank_transfer_payment->id); ?>"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            <?php echo e(Form::close()); ?>

                                                        <?php elseif($bank_transfer_payment->payment_type == 'Bank Account'): ?>
                                                            <?php echo e(Form::open(['route' => ['invoice.bankaccount.request.destroy', $bank_transfer_payment->id], 'class' => 'm-0'])); ?>

                                                            <?php echo method_field('DELETE'); ?>
                                                            <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                data-confirm-yes="delete-form-<?php echo e($bank_transfer_payment->id); ?>"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            <?php echo e(Form::close()); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(company_date_formate($payment->date)); ?></td>
                                                <td><?php echo e(currency_format_with_sym($payment->amount)); ?></td>
                                                <td><?php echo e($payment->payment_type); ?></td>
                                                <?php if(module_is_active('Account')): ?>
                                                    <td><?php echo e(!empty($payment->bankAccount) ? $payment->bankAccount->bank_name . ' ' . $payment->bankAccount->holder_name : '--'); ?>

                                                    </td>
                                                <?php else: ?>
                                                    <td>--</td>
                                                <?php endif; ?>

                                                <td><?php echo e(!empty($payment->reference) ? $payment->reference : '--'); ?></td>
                                                <td><?php echo e(!empty($payment->description) ? $payment->description : '--'); ?>

                                                </td>
                                                <td>
                                                    <?php if(!empty($payment->add_receipt) && empty($payment->receipt) && check_file($payment->add_receipt)): ?>
                                                        <div class="d-flex">
                                                            <div class="action-btn me-2">
                                                                <a href="<?php echo e(check_file($payment->add_receipt) ? get_file($payment->add_receipt) : '-'); ?>"
                                                                    download=""
                                                                    class="mx-3 btn btn-sm align-items-center bg-primary"
                                                                    data-bs-toggle="tooltip"
                                                                    title="<?php echo e(__('Download')); ?>" target="_blank">
                                                                    <i class="ti ti-download text-white"></i>
                                                                </a>
                                                            </div>
                                                            <div class="action-btn">
                                                                <a href="<?php echo e(check_file($payment->add_receipt) ? get_file($payment->add_receipt) : '-'); ?>"
                                                                    class="mx-3 btn btn-sm align-items-center bg-secondary"
                                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Show')); ?>"
                                                                    target="_blank">
                                                                    <i class="ti ti-crosshair text-white"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php elseif(!empty($payment->receipt) && empty($payment->add_receipt) && $payment->payment_type == 'Stripe'): ?>
                                                        <a href="<?php echo e($payment->receipt); ?>" target="_blank"><i
                                                                class="ti ti-file"></i></a>
                                                    <?php elseif($payment->payment_type == 'Bank Transfer' || $payment->payment_type == 'Bank Account'): ?>
                                                        <a href="<?php echo e(!empty($payment->receipt) ? (check_file($payment->receipt) ? get_file($payment->receipt) : '#!') : '#!'); ?>"
                                                            target="_blank"><i class="ti ti-file"></i></a>
                                                    <?php else: ?>
                                                        --
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e(!empty($payment->order_id) ? $payment->order_id : '--'); ?></td>
                                                <?php if (app('laratrust')->hasPermission('invoice payment delete')) : ?>
                                                    <td>
                                                        <div class="action-btn">
                                                            <?php echo e(Form::open(['route' => ['invoice.payment.destroy', $invoice->id, $payment->id], 'class' => 'm-0'])); ?>

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
                                                    </td>
                                                <?php endif; // app('laratrust')->permission ?>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="credit-summary" role="tabpanel" aria-labelledby="pills-user-tab-3">
                    <?php if(module_is_active('Account')): ?>
                        <?php echo $__env->make('account::invoice.invoice_section', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="invoice-attechment" role="tabpanel" aria-labelledby="pills-user-tab-4">
                    <div class="row">
                        
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
                                            <?php $__empty_1 = true; $__currentLoopData = $invoice_attachment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <td><?php echo e(++$key); ?></td>
                                                <td><?php echo e($attachment->file_name); ?></td>
                                                <td><?php echo e($attachment->file_size); ?></td>
                                                <td><?php echo e(company_date_formate($attachment->created_at)); ?></td>
                                                <td>
                                                    <div class="action-btn me-2">
                                                        <a href="<?php echo e(url($attachment->file_path)); ?>"
                                                            data-bs-toggle="tooltip"
                                                            class="mx-3 btn btn-sm align-items-center bg-primary"
                                                            title="<?php echo e(__('Download')); ?>" target="_blank" download>
                                                            <i class="ti ti-download text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn">
                                                        <?php echo e(Form::open(['route' => ['invoice.attachment.destroy', $attachment->id], 'class' => 'm-0'])); ?>

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
                                                <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
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
    <?php if(\Auth::user()->type != 'company'): ?>
        <div class="col-12">
            <h5 class="h4 d-inline-block font-weight-400 mb-4"><?php echo e(__('Receipt Summary')); ?></h5>
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table ">
                            <tr>
                                    <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Payment Type')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Receipt')); ?></th>
                                    <th class="text-dark"><?php echo e(__('OrderId')); ?></th>
                                </tr>
                            </thead>
                            <?php if(!empty($invoice->payments) || !empty($bank_transfer_payments)): ?>
                                <?php $__currentLoopData = $bank_transfer_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank_transfer_payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(company_datetime_formate($bank_transfer_payment->created_at)); ?>

                                        </td>
                                        <td class="text-right">
                                            <?php echo e(currency_format_with_sym($bank_transfer_payment->price)); ?></td>
                                        <td><?php echo e($bank_transfer_payment->payment_type); ?></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>
                                            <?php if(!empty($bank_transfer_payment->attachment)): ?>
                                                <a href="<?php echo e(get_file($bank_transfer_payment->attachment)); ?>"
                                                    target="_blank"> <i class="ti ti-file"></i></a>
                                            <?php else: ?>
                                                --
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($bank_transfer_payment->order_id); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(company_date_formate($payment->date)); ?></td>
                                        <td><?php echo e(currency_format_with_sym($payment->amount)); ?></td>
                                        <td><?php echo e($payment->payment_type); ?></td>
                                        <?php if(module_is_active('Account')): ?>
                                            <td><?php echo e(!empty($payment->bankAccount) ? $payment->bankAccount->bank_name . ' ' . $payment->bankAccount->holder_name : '--'); ?>

                                            </td>
                                        <?php else: ?>
                                            <td>--</td>
                                        <?php endif; ?>

                                        <td><?php echo e(!empty($payment->reference) ? $payment->reference : '--'); ?></td>
                                        <td><?php echo e(!empty($payment->description) ? $payment->description : '--'); ?>

                                        </td>
                                        <td>
                                            <?php if(!empty($payment->add_receipt) && empty($payment->receipt) && check_file($payment->add_receipt)): ?>
                                                <div class="d-flex">
                                                    <div class="action-btn me-2">
                                                        <a href="<?php echo e(check_file($payment->add_receipt) ? get_file($payment->add_receipt) : '-'); ?>"
                                                            download=""
                                                            class="mx-3 btn btn-sm align-items-center bg-primary"
                                                            data-bs-toggle="tooltip"
                                                            title="<?php echo e(__('Download')); ?>" target="_blank">
                                                            <i class="ti ti-download text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn">
                                                        <a href="<?php echo e(check_file($payment->add_receipt) ? get_file($payment->add_receipt) : '-'); ?>"
                                                            class="mx-3 btn btn-sm align-items-center bg-secondary"
                                                            data-bs-toggle="tooltip" title="<?php echo e(__('Show')); ?>"
                                                            target="_blank">
                                                            <i class="ti ti-crosshair text-white"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php elseif(!empty($payment->receipt) && empty($payment->add_receipt) && $payment->payment_type == 'Stripe'): ?>
                                                <a href="<?php echo e($payment->receipt); ?>" target="_blank"><i
                                                        class="ti ti-file"></i></a>
                                            <?php elseif($payment->payment_type == 'Bank Transfer' || $payment->payment_type == 'Bank Account'): ?>
                                                <a href="<?php echo e(!empty($payment->receipt) ? (check_file($payment->receipt) ? get_file($payment->receipt) : '#!') : '#!'); ?>"
                                                    target="_blank"><i class="ti ti-file"></i></a>
                                            <?php else: ?>
                                                --
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(!empty($payment->order_id) ? $payment->order_id : '--'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\invoice\view.blade.php ENDPATH**/ ?>
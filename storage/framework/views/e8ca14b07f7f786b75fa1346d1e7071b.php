<?php $__env->startSection('page-title'); ?>
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
<?php
    $company_settings = getCompanyAllSetting($invoice->created_by, $invoice->workspace);
?>
<?php $__env->startSection('action-btn'); ?>
    <div class="row justify-content-center align-items-center ">
        <div class="col-12 d-flex align-items-center justify-content-between justify-content-md-end">
            <div class="all-button-box mr-3 d-flex">
                <a href="<?php echo e(route('invoice.pdf', \Crypt::encrypt($invoice->id))); ?>" target="_blank"
                    class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="<?php echo e(__('Print')); ?>">
                    <span class="btn-inner--icon text-white"><i class="ti ti-printer"></i><?php echo e(__(' Print')); ?></span>
                </a>

                <?php if($invoice->status != 0 && $invoice->getDue() > 0): ?>
                    <a id="paymentModals" class="btn btn-sm btn-primary">
                        <span class="btn-inner--icon text-white"><i class="ti ti-credit-card"></i></span>
                        <span class="btn-inner--text text-white"><?php echo e(__(' Pay Now')); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row row-gap invoice-title border-1 border-bottom  pb-3 mb-3">
                                <div class="col-sm-4  col-12">
                                    <h2 class="h3 mb-0"><?php echo e(__('Invoice')); ?></h2>
                                </div>
                                <div class="col-sm-8  col-12">
                                    <div class="d-flex invoice-wrp flex-wrap align-items-center gap-md-2 gap-1 justify-content-end">
                                        <div class="d-flex invoice-date flex-wrap align-items-center justify-content-end gap-md-3 gap-1">
                                            <p class="mb-0"><strong><?php echo e(__('Issue Date')); ?> :</strong> <?php echo e(company_date_formate($invoice->issue_date,$invoice->created_by, $invoice->workspace)); ?></p>
                                            <p class="mb-0"><strong><?php echo e(__('Due Date')); ?> :</strong> <?php echo e(company_date_formate($invoice->due_date,$invoice->created_by, $invoice->workspace)); ?></p>
                                        </div>
                                        <h3 class="invoice-number mb-0">
                                            <?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id,$invoice->created_by, $invoice->workspace)); ?>

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
                                                    <strong class="h5 mb-1"><?php echo e(__('Name ')); ?>:
                                                    </strong><?php echo e(!empty($customer->name) ? $customer->name : ''); ?>

                                                </p>
                                                <?php if(!empty($customer->billing_name) && !empty($customer->billing_address) && !empty($customer->billing_zip)): ?>
                                                    <p class="mb-2"><strong class="h5 mb-1 d-block"><?php echo e(__('Billed To')); ?>

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
                                                    <strong class="h5 mb-1"><?php echo e(__('Email ')); ?>:
                                                    </strong><?php echo e(!empty($customer->email) ? $customer->email : ''); ?>

                                                </p>
                                                <?php if(!empty($company_settings['invoice_shipping_display']) && $company_settings['invoice_shipping_display'] == 'on'): ?>
                                                    <?php if(!empty($customer->shipping_name) && !empty($customer->shipping_address) && !empty($customer->shipping_zip)): ?>
                                                        <p class="mb-2">
                                                            <strong class="h5 mb-1 d-block"><?php echo e(__('Shipped To')); ?> :</strong>
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
                                                            <?php echo e(!empty($customer->billing_phone) ? $customer->billing_phone : ''); ?>

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

                                    <?php if(($invoice->invoice_module == 'legalcase' ||
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
                                                    <strong class="h5 mb-1 d-block"><?php echo e(__('Request Number')); ?> :</strong>
                                                    <?php echo e(!empty($invoice->customer_id) ? \Workdo\VehicleInspectionManagement\Entities\InspectionRequest::inspectionRequestIdFormat($invoice->customer_id, $invoice->created_by, $invoice->workspace) : ''); ?>

                                                </p>
                                                <p class="font-style">
                                                    <strong class="h5 mb-1 d-block"><?php echo e(__('Billed To')); ?> :</strong>
                                                    <?php echo e(!empty($inspectionRequest->inspector_name) ? $inspectionRequest->inspector_name : ''); ?><br>
                                                    <?php echo e(!empty($inspectionRequest->inspector_email) ? $inspectionRequest->inspector_email : ''); ?>

                                                </p>
                                            </div>
                                            <div class="col">
                                                <p class="font-style">
                                                    <strong class="h5 mb-1 d-block"><?php echo e(__('Vehicle Details')); ?> :</strong>
                                                    <dl class="row align-items-center">
                                                        <dt class="col-sm-6">
                                                            <?php echo e(__('Model')); ?></dt>
                                                        <dd class="col-sm-6  ms-0"> :
                                                            <?php echo e(!empty($vehicle_details->model) ? $vehicle_details->model : ''); ?>

                                                        </dd>
                                                        <dt class="col-sm-6">
                                                            <?php echo e(__('ID Number')); ?>

                                                        </dt>
                                                        <dd class="col-sm-6  ms-0"> :
                                                            <?php echo e(!empty($vehicle_details->vehicle_id_number) ? $vehicle_details->vehicle_id_number : ''); ?>

                                                        </dd>
                                                        <dt class="col-sm-6">
                                                            <?php echo e(__('Current Mileage')); ?></dt>
                                                        <dd class="col-sm-6  ms-0"> :
                                                            <?php echo e(!empty($vehicle_details->mileage) ? $vehicle_details->mileage : ''); ?>

                                                        </dd>
                                                        <dt class="col-sm-6">
                                                            <?php echo e(__('Manufacture Year')); ?></dt>
                                                        <dd class="col-sm-6  ms-0"> :
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
                                                        <?php echo e(__('Name')); ?></dt>
                                                    <dd class="col-sm-8  ms-0" style="margin-bottom: 0px;"> :
                                                        <?php echo e(!empty($machine_details->name) ? $machine_details->name : ''); ?>

                                                    </dd>
                                                    <dt class="col-sm-4" style="font-weight: 600;">
                                                        <?php echo e(__('Model')); ?></dt>
                                                    <dd class="col-sm-8  ms-0" style="margin-bottom: 0px;"> :
                                                        <?php echo e(!empty($machine_details->model) ? $machine_details->model : ''); ?>

                                                    </dd>
                                                    <dt class="col-sm-4" style="font-weight: 600;">
                                                        <?php echo e(__('Manufacturer')); ?></dt>
                                                    <dd class="col-sm-8  ms-0" style="margin-bottom: 0px;"> :
                                                        <?php echo e(!empty($machine_details->manufacturer) ? $machine_details->manufacturer : ''); ?>

                                                    </dd>
                                                </dl>
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-lg-2 col-sm-6">
                                        <strong class="h5 d-block mb-2"><?php echo e(__('Status')); ?> :</strong>
                                        <?php if($invoice->status == 0): ?>
                                            <span class="badge fix_badge f-12 p-2 d-inline-block bg-info"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 1): ?>
                                            <span class="badge fix_badge f-12 p-2 d-inline-block bg-primary"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 2): ?>
                                            <span class="badge fix_badge f-12 p-2 d-inline-block bg-secondary"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 3): ?>
                                            <span class="badge fix_badge f-12 p-2 d-inline-block bg-warning"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 4): ?>
                                            <span class="badge fix_badge f-12 p-2 d-inline-block bg-success"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if(!empty($company_settings['invoice_qr_display']) && $company_settings['invoice_qr_display'] == 'on'): ?>
                                        <div class="col-lg-2 col-sm-6">
                                            <div class="float-sm-end qr-code">
                                                <?php if(module_is_active('Zatca', $invoice->created_by)): ?>
                                                    <div class="col">
                                                        <div class="float-sm-end">
                                                            <?php echo $__env->make('zatca::zatca_qr_code', [
                                                                'invoice_id' => $invoice->id,
                                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="col">
                                                        <div class="float-sm-end">
                                                            <?php echo DNS2D::getBarcodeHTML(
                                                                route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id)),
                                                                'QRCODE',
                                                                2,
                                                                2,
                                                            ); ?>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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
                                                        <p  class="mb-0">
                                                            <?php echo e(!empty($invoice->customField[$field->id]) ? $invoice->customField[$field->id] : '-'); ?>

                                                        </p>
                                                    <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row mt-4">
                                <div class="col-md-12 invoice-summary mt-3">
                                    <div class="invoice-title border-1 border-bottom mb-3 pb-2">
                                        <h3 class="h4 mb-0"><?php echo e(__('Product Summary')); ?></h3>
                                        <small><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th data-width="40" class="text-white bg-primary text-uppercase">#</th>
                                                <?php if($invoice->invoice_module == 'account' || $invoice->invoice_module == 'cmms' || $invoice->invoice_module == 'rent' || $invoice->invoice_module == 'machinerepair' || $invoice->invoice_module == 'musicinstitute' || $invoice->invoice_module == 'vehicleinspection' ): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item Type')); ?></th>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item')); ?></th>
                                                <?php elseif($invoice->invoice_module == 'taskly'): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Project')); ?></th>
                                                <?php elseif($invoice->invoice_module == 'lms'): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Course')); ?></th>
                                                <?php elseif($invoice->invoice_module == 'childcare'): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Name')); ?></th>
                                                <?php elseif($invoice->invoice_module == 'cardealership' ||  $invoice->invoice_module == 'sales' || $invoice->invoice_module == 'newspaper'|| $invoice->invoice_module == 'mobileservice'): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Items')); ?></th>
                                                <?php elseif($invoice->invoice_module == 'legalcase' ): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('PARTICULARS')); ?></th>
                                                <?php elseif($invoice->invoice_module == 'Fleet' ): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Distance')); ?></th>
                                                <?php elseif($invoice->invoice_module == 'RestaurantMenu'): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item Name')); ?></th>
                                                <?php endif; ?>
                                                <?php if($invoice->invoice_module !== 'Fleet' && $invoice->invoice_module !== 'taskly' && $invoice->invoice_module !== 'childcare'): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Quantity')); ?></th>
                                                <?php endif; ?>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Rate')); ?></th>
                                                <?php if($invoice->invoice_module != 'Fleet' && $invoice->invoice_module != 'childcare' ): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Discount')); ?></th>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Tax')); ?></th>
                                                <?php endif; ?>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Description')); ?></th>
                                                <th class="text-right text-white bg-primary text-uppercase" width="12%"><?php echo e(__('Price')); ?><br></th>
                                            </tr>
                                            <?php
                                                $totalQuantity = 0;
                                                $totalRate = 0;
                                                $totalTaxPrice = 0;
                                                $totalDiscount = 0;
                                                $taxesData = [];
                                                $TaxPrice_array = [];
                                                $commonSubtotal = 0;

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
                                                                    $taxesData[$taxe->name] = $taxesData[$taxe->name] + $taxDataPrice;
                                                                } else {
                                                                    $taxesData[$taxe->name] = $taxDataPrice;
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $taxes = App\Models\Invoice::tax($iteam->tax);
                                                            $totalQuantity += $iteam->quantity;
                                                            $totalRate += $iteam->price;
                                                            if ($invoice->invoice_module == 'account') {
                                                                $totalDiscount += $iteam->discount;
                                                            } elseif ($invoice->invoice_module == 'taskly') {
                                                                $totalDiscount = $invoice->discount;
                                                            }

                                                            foreach ($taxes as $taxe) {
                                                                $taxDataPrice = App\Models\Invoice::taxRate(
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
                                                    <?php if($invoice->invoice_module == 'account' || $invoice->invoice_module == 'machinerepair' || $invoice->invoice_module == 'musicinstitute' || $invoice->invoice_module == 'vehicleinspection'): ?>
                                                        <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?></td>
                                                        <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?></td>
                                                    <?php elseif($invoice->invoice_module == 'taskly'): ?>
                                                        <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->title : ''); ?></td>
                                                    <?php elseif($invoice->invoice_module == 'cmms' || $invoice->invoice_module == 'rent'): ?>
                                                        <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?></td>
                                                        <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?></td>
                                                    <?php elseif($invoice->invoice_module == 'lms'): ?>
                                                        <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->title : ''); ?></td>
                                                    <?php elseif($invoice->invoice_module == 'childcare' || $invoice->invoice_module == 'legalcase'): ?>
                                                        <td><?php echo e(!empty($iteam->product_name) ? $iteam->product_name : ''); ?></td>
                                                    <?php elseif($invoice->invoice_module == 'cardealership' || $invoice->invoice_module == 'sales' || $invoice->invoice_module == 'newspaper' || $invoice->invoice_module == 'mobileservice'): ?>
                                                        <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?></td>
                                                    <?php elseif($invoice->invoice_module == 'RestaurantMenu'): ?>
                                                        <td><?php echo e(!empty($iteam->product_name) ? $iteam->product_name : ''); ?></td>
                                                    <?php endif; ?>
                                                    <?php if($invoice->invoice_module == 'Fleet'): ?>
                                                        <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->distance : 0); ?></td>
                                                    <?php elseif($invoice->invoice_module == 'taskly' || $invoice->invoice_module == 'childcare'): ?>
                                                    <?php else: ?>
                                                        <td><?php echo e($iteam->quantity); ?></td>
                                                    <?php endif; ?>
                                                    <td><?php echo e(currency_format_with_sym($iteam->price, $invoice->created_by, $invoice->workspace)); ?></td>
                                                    <?php if($invoice->invoice_module != 'Fleet' && $invoice->invoice_module != 'childcare'): ?>
                                                        <td><?php echo e(currency_format_with_sym($iteam->discount, $invoice->created_by, $invoice->workspace)); ?></td>
                                                        <td>
                                                            <?php if(!empty($iteam->tax)): ?>
                                                                <table>
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
                                                                            <td><?php echo e($tax->name . ' (' . $tax->rate . '%)'); ?></td>
                                                                            <td><?php echo e(currency_format_with_sym($taxPrice, $invoice->created_by, $invoice->workspace)); ?></td>
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
                                                    <td><?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?></td>
                                                    <?php
                                                        $tr_tex =
                                                            array_key_exists($key, $TaxPrice_array) == true
                                                                ? $TaxPrice_array[$key]
                                                                : 0;
                                                    ?>
                                                    <td>
                                                        <?php if($invoice->invoice_module == 'childcare'): ?>
                                                            <?php echo e(currency_format_with_sym($iteam->price, $invoice->created_by, $invoice->workspace)); ?>

                                                        <?php elseif($invoice->invoice_module == 'Fleet'): ?>
                                                            <?php
                                                                $distance = !empty($iteam->product()) ? $iteam->product()->distance : 0;
                                                                $price = $iteam->price * $iteam->product()->distance;
                                                            ?>
                                                            <?php echo e(currency_format_with_sym($price,$invoice->created_by, $invoice->workspace)); ?>

                                                        <?php else: ?>
                                                            <?php echo e(currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $tr_tex, $invoice->created_by, $invoice->workspace)); ?>

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

                                                    <?php if($invoice->invoice_module == 'cmms' || $invoice->invoice_module == 'rent' || $invoice->invoice_module == 'vehicleinspection' || $invoice->invoice_module == 'musicinstitute' || $invoice->invoice_module == 'machinerepair'): ?>
                                                        <td></td>
                                                        <td class="bg-color "><b><?php echo e(__('Total')); ?></b></td>
                                                    <?php else: ?>
                                                        <td class="bg-color "><b><?php echo e(__('Total')); ?></b></td>
                                                    <?php endif; ?>

                                                    <?php if($invoice->invoice_module == 'Fleet'): ?>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalRate,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                    <?php elseif($invoice->invoice_module == 'taskly'): ?>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalRate,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalDiscount,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalTaxPrice,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                    <?php elseif($invoice->invoice_module == 'cmms'): ?>
                                                        <td class="bg-color"><b><?php echo e($totalQuantity,$invoice->created_by, $invoice->workspace); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalRate,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalDiscount,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalTaxPrice,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                    <?php elseif($invoice->invoice_module == 'childcare'): ?>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($commonSubtotal,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                    <?php else: ?>
                                                        <td class="bg-color"><b><?php echo e($totalQuantity,$invoice->created_by, $invoice->workspace); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalRate,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalDiscount,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                        <td class="bg-color"><b><?php echo e(currency_format_with_sym($totalTaxPrice,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <?php
                                                    $colspan = 6;
                                                    $customerInvoices = ['taskly', 'account', 'cmms', 'cardealership', 'RestaurantMenu', 'rent' , 'Fleet'];
                                                    if (in_array($invoice->invoice_module, $customerInvoices)) {
                                                        $colspan = 7;
                                                    }

                                                    if ($invoice->invoice_module == 'taskly') {
                                                        $colspan = 5;
                                                    }

                                                    if ($invoice->invoice_module == 'Fleet' || $invoice->invoice_module == 'childcare') {
                                                        $colspan = 3;
                                                    }
                                                ?>

                                                <?php if($invoice->invoice_module != 'Fleet'): ?>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Sub Total')); ?></td>
                                                        <td class="text-right">
                                                            <?php if($invoice->invoice_module == 'childcare'): ?>
                                                                <b><?php echo e(currency_format_with_sym($commonSubtotal,$invoice->created_by, $invoice->workspace)); ?></b>
                                                            <?php else: ?>
                                                                <b><?php echo e(currency_format_with_sym($invoice->getSubTotal(),$invoice->created_by, $invoice->workspace)); ?></b>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Discount')); ?></td>
                                                        <td class="text-right"><b> <?php echo e(currency_format_with_sym($invoice->getTotalDiscount(),$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if(!empty($taxesData)): ?>
                                                    <?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td colspan="<?php echo e($colspan); ?>"></td>
                                                            <td class="text-right"><?php echo e($taxName); ?></td>
                                                            <td class="text-right"><b><?php echo e(currency_format_with_sym($taxPrice,$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="blue-text text-right"><?php echo e(__('Total')); ?></td>
                                                    <td class="blue-text text-right">
                                                        <?php if($invoice->invoice_module == 'childcare'): ?>
                                                            <b><?php echo e(currency_format_with_sym($commonSubtotal,$invoice->created_by, $invoice->workspace)); ?></b>
                                                        <?php elseif($invoice->invoice_module == 'Fleet'): ?>
                                                            <b><?php echo e(currency_format_with_sym($invoice->getFleetSubTotal(),$invoice->created_by, $invoice->workspace)); ?></b>
                                                        <?php else: ?>
                                                           <b> <?php echo e(currency_format_with_sym($invoice->getTotal(),$invoice->created_by, $invoice->workspace)); ?></b>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Paid')); ?></td>
                                                    <td class="text-right"><b><?php echo e(currency_format_with_sym($invoice->getTotal() - $invoice->getDue() - $invoice->invoiceTotalCreditNote(),$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Credit Note Applied')); ?></td>
                                                    <td class="text-right"><b><?php echo e(currency_format_with_sym($invoice->invoiceTotalCreditNote(),$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Debit note issued')); ?></td>
                                                    <td class="text-right"><b><?php echo e(currency_format_with_sym($invoice->invoiceTotalCustomerCreditNote(),$invoice->created_by, $invoice->workspace)); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Due')); ?></td>
                                                    <td class="text-right"><b><?php echo e(currency_format_with_sym($invoice->getDue(),$invoice->created_by, $invoice->workspace)); ?></b></td>
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
        <div class="col-12">
            <h5 class="h4 d-inline-block font-weight-400 mb-4"><?php echo e(__('Receipt Summary')); ?></h5>
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                <th class="text-dark"><?php echo e(__('Payment Type')); ?></th>
                                <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                <th class="text-dark"><?php echo e(__('Receipt')); ?></th>
                                <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                <th class="text-dark"><?php echo e(__('OrderId')); ?></th>
                            </tr>
                            <?php $__empty_1 = true; $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(company_date_formate($payment->date, $invoice->created_by, $invoice->workspace)); ?></td>
                                    <td><?php echo e(currency_format_with_sym($payment->amount, $invoice->created_by, $invoice->workspace)); ?></td>
                                    <td><?php echo e($payment->payment_type); ?></td>
                                    <?php if(module_is_active('Account')): ?>
                                        <td><?php echo e(!empty($payment->bankAccount) ? $payment->bankAccount->bank_name . ' ' . $payment->bankAccount->holder_name : '--'); ?>

                                        <?php else: ?>
                                        <td>--</td>
                                    <?php endif; ?>
                                    <td><?php echo e(!empty($payment->reference) ? $payment->reference : '--'); ?></td>
                                    <td>
                                        <?php if(!empty($payment->add_receipt) && empty($payment->receipt) && check_file($payment->add_receipt)): ?>
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
                                                    data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Show')); ?>" target="_blank">
                                                    <i class="ti ti-crosshair text-white"></i>
                                                </a>
                                            </div>

                                        <?php elseif(!empty($payment->receipt) && empty($payment->add_receipt) && $payment->payment_type == 'Stripe'): ?>
                                            <a href="<?php echo e($payment->receipt); ?>" target="_blank"> <i class="ti ti-file"></i></a>
                                        <?php elseif(!empty($payment->receipt) && empty($payment->add_receipt) && $payment->payment_type == 'Coin'): ?>
                                            <a href="<?php echo e($payment->receipt); ?>" target="_blank"> <i class="ti ti-file"></i></a>
                                        <?php elseif($payment->payment_type == 'Bank Transfer'): ?>
                                            <a href="<?php echo e(!empty($payment->receipt) ? (check_file($payment->receipt) ? get_file($payment->receipt) : '#!') : '#!'); ?>" target="_blank"><i class="ti ti-file"></i></a>
                                        <?php else: ?>
                                            --
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e(!empty($payment->description) ? $payment->description : '--'); ?></td>
                                    <td><?php echo e(!empty($payment->order_id) ? $payment->order_id : '--'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php if(module_is_active('Account')): ?>
            <div class="col-12">
                <h5 class="h4 d-inline-block font-weight-400 mb-4"><?php echo e(__('Credit Note Summary')); ?></h5>
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table ">
                                <tr>
                                    <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                    <th class="text-dark" class=""><?php echo e(__('Amount')); ?></th>
                                    <th class="text-dark" class=""><?php echo e(__('Description')); ?></th>
                                    <?php if(Laratrust::hasPermission('edit credit note') || Laratrust::hasPermission('delete credit note')): ?>
                                        <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                                <?php $__empty_1 = true; $__currentLoopData = $invoice->creditNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$creditNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e(company_date_formate($creditNote->date, $invoice->created_by, $invoice->workspace)); ?></td>
                                        <td class=""><?php echo e(currency_format_with_sym($creditNote->amount, $invoice->created_by, $invoice->workspace)); ?></td>
                                        <td class=""><?php echo e($creditNote->description); ?></td>
                                        <td>
                                            <?php if (app('laratrust')->hasPermission('edit credit note')) : ?>
                                                <a data-url="<?php echo e(route('invoice.edit.credit.note', [$creditNote->invoice, $creditNote->id])); ?>"
                                                    data-ajax-popup="true" data-title="<?php echo e(__('Add Credit Note')); ?>"
                                                    data-toggle="tooltip" data-original-title="<?php echo e(__('Credit Note')); ?>"
                                                    href="#" class="mx-3 btn btn-sm align-items-center"
                                                    data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            <?php endif; // app('laratrust')->permission ?>
                                            <?php if (app('laratrust')->hasPermission('delete credit note')) : ?>
                                                <a href="#" class="mx-3 btn btn-sm align-items-center "
                                                    data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>"
                                                    data-confirm="<?php echo e(__('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?')); ?>"
                                                    data-confirm-yes="document.getElementById('delete-form-<?php echo e($creditNote->id); ?>').submit();">
                                                    <i class="ti ti-trash text-white"></i>
                                                </a>
                                                <?php echo Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['invoice.delete.credit.note', $creditNote->invoice, $creditNote->id],
                                                    'id' => 'delete-form-' . $creditNote->id,
                                                ]); ?>

                                                <?php echo Form::close(); ?>

                                            <?php endif; // app('laratrust')->permission ?>
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
        <?php endif; ?>
    </div>

    <?php if($invoice->getDue() > 0): ?>
        <div id="paymentModal" class="modal" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-modal="true"
            role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel"><?php echo e(__('Add Payment')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row pb-3 px-2">
                            <section class="">
                                <ul class="nav nav-pills  mb-3" id="pills-tab" role="tablist">
                                    <?php if((isset($company_settings['bank_transfer_payment_is_on'])
                                            ? $company_settings['bank_transfer_payment_is_on']
                                            : 'off') == 'on' && !empty($company_settings['bank_number'])): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#bank-payment" type="button" role="tab"
                                                aria-controls="pills-home"
                                                aria-selected="true"><?php echo e(__('Bank trasfer')); ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php echo $__env->yieldPushContent('invoice_payment_tab'); ?>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <?php if((isset($company_settings['bank_transfer_payment_is_on'])
                                            ? $company_settings['bank_transfer_payment_is_on']
                                            : 'off') == 'on' && !empty($company_settings['bank_number'])): ?>
                                        <div class="tab-pane fade " id="bank-payment" role="tabpanel" aria-labelledby="bank-payment">
                                            <form method="post" action="<?php echo e(route('invoice.pay.with.bank')); ?>"
                                                class="require-validation" id="payment-form"
                                                enctype="multipart/form-data">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="type" value="invoice">
                                                <div class="row mt-2">
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <label class="form-label"><?php echo e(__('Bank Details :')); ?></label>
                                                            <p class=""><?php echo $company_settings['bank_number']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label"><?php echo e(__('Payment Receipt')); ?></label>
                                                            <div class="choose-files">
                                                                <label for="payment_receipt">
                                                                    <div class=" bg-primary "> <i class="ti ti-upload px-1"></i></div>
                                                                    <input type="file" class="form-control"
                                                                        required=""
                                                                        accept="image/png, image/jpeg, image/jpg, .pdf"
                                                                        name="payment_receipt" id="payment_receipt"
                                                                        data-filename="payment_receipt"
                                                                        onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
                                                                </label>
                                                                <p class="text-danger error_msg d-none"><?php echo e(__('This field is required')); ?></p>
                                                                <img class="mt-2" width="70px" id="blah3">
                                                            </div>
                                                            <div class="invalid-feedback"><?php echo e(__('invalid form file')); ?></div>
                                                        </div>
                                                    </div>
                                                    <small class="text-danger"><?php echo e(__('first, make a payment and take a screenshot or download the receipt and upload it.')); ?></small>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount"><?php echo e(__('Amount')); ?></label>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend"><span class="input-group-text"><?php echo e(!empty($company_settings['defult_currancy']) ? $company_settings['defult_currancy'] : '$'); ?></span></span>
                                                            <input class="form-control" required="required"
                                                                min="0" name="amount" type="number"
                                                                value="<?php echo e($invoice->getDue()); ?>" min="0"
                                                                step="0.01" max="<?php echo e($invoice->getDue()); ?>"
                                                                id="amount">
                                                            <input type="hidden" value="<?php echo e($invoice->id); ?>" name="invoice_id">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="error" style="display: none;">
                                                            <div class='alert-danger alert'><?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <button type="button" class="btn  btn-secondary me-1" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                                                    <button class="btn btn-primary" type="submit" id="submit_transfer"><?php echo e(__('Make Payment')); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    <?php echo $__env->yieldPushContent('invoice_payment_div'); ?>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $("#paymentModals").click(function() {
            $("#paymentModal").modal('show');
            $("ul li a").removeClass("active");
            $(".tab-pane").removeClass("active show");
            $("ul li:first a:first").addClass("active");
            $(".tab-pane:first").addClass("active show");
        });

        $("#submit_transfer").click(function() {
            var skill = $('#payment_receipt').val();
            if (skill == '') {
                $('.error_msg').removeClass('d-none')
                return false;
            } else {
                $('.error_msg').addClass('d-none')
            }
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.invoicepayheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\invoice\invoicepay.blade.php ENDPATH**/ ?>
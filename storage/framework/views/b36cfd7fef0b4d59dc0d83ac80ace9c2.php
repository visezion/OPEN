<?php
    $admin_settings = getAdminAllSetting();

    $company_settings = getCompanyAllSetting($bill->created_by);

?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Bill Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
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
<?php $__env->startSection('action-btn'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::check() && isset(\Auth::user()->type) && \Auth::user()->type == 'company'): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status != 0): ?>
            <div class="row justify-content-between align-items-center ">
                <div class="col-12 d-flex align-items-center justify-content-between justify-content-md-end">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($billPayment)): ?>
                        <div class="mx-2 all-button-box">
                            <a href="#" data-url="<?php echo e(route('bill.debit.note', $bill->id)); ?>" data-ajax-popup="true"
                                data-title="<?php echo e(__('Add Debit Note')); ?>" class="btn btn-sm btn-primary">
                                <?php echo e(__('Add Debit Note')); ?>

                            </a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="mr-3 all-button-box d-flex">
                        <a href="<?php echo e(route('bill.pdf', Crypt::encrypt($bill->id))); ?>" target="_blank"
                            class="btn btn-sm btn-primary"><i class="ti ti-printer"></i>
                            <?php echo e(__(' Print')); ?>

                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
        <div class="row justify-content-between align-items-center ">
            <div class="col-12 d-flex align-items-center justify-content-between justify-content-md-end">
                <div class="mx-2 all-button-box">
                    <a href="<?php echo e(route('bill.pdf', Crypt::encrypt($bill->id))); ?>" target="_blank"
                        class="btn btn-sm btn-primary btn-icon-only width-auto">
                        <i class="ti ti-printer"></i><?php echo e(__(' Print')); ?>

                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php
        $vendor = $bill->vendor;
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row row-gap invoice-title border-1 border-bottom  pb-3 mb-3">
                                <div class="col-sm-4  col-12">
                                    <h2 class="h3 mb-0"><?php echo e(__('Bill')); ?></h2>
                                </div>
                                <div class="col-sm-8  col-12">
                                    <div
                                        class="d-flex invoice-wrp flex-wrap align-items-center gap-md-2 gap-1 justify-content-end">
                                        <div
                                            class="d-flex invoice-date flex-wrap align-items-center justify-content-end gap-md-3 gap-1">
                                            <p class="mb-0"><strong><?php echo e(__('Bill Date')); ?> :</strong>
                                                <?php echo e(company_date_formate($bill->bill_date, $bill->created_by, $bill->workspace)); ?>

                                            </p>
                                            <p class="mb-0"><strong><?php echo e(__('Due Date')); ?> :</strong>
                                                <?php echo e(company_date_formate($bill->due_date, $bill->created_by, $bill->workspace)); ?>

                                            </p>
                                        </div>
                                        <h3 class="invoice-number mb-0">
                                            <?php echo e(\Workdo\Account\Entities\Bill::billNumberFormat($bill->bill_id, $company_id, $workspace_id)); ?>

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
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($vendor->billing_name) && !empty($vendor->billing_address) && !empty($vendor->billing_zip)): ?>
                                                        <p class="mb-2"><strong
                                                                class="h5 mb-1 d-block"><?php echo e(__('Billed To')); ?>

                                                                :</strong>
                                                            <?php echo e(!empty($vendor->billing_name) ? $vendor->billing_name : ''); ?>

                                                            <?php echo e(!empty($vendor->billing_address) ? $vendor->billing_address : ''); ?>

                                                            <?php echo e(!empty($vendor->billing_city) ? $vendor->billing_city . ' ,' : ''); ?>

                                                            <?php echo e(!empty($vendor->billing_state) ? $vendor->billing_state . ' ,' : ''); ?>

                                                            <?php echo e(!empty($vendor->billing_zip) ? $vendor->billing_zip : ''); ?>

                                                            <?php echo e(!empty($vendor->billing_country) ? $vendor->billing_country : ''); ?>

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
                                                                <img width="100px" src="<?php echo e($bill->company_signature); ?>">
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

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(company_setting('bill_shipping_display', $company_id, $workspace_id) == 'on'): ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($vendor->shipping_name) && !empty($vendor->shipping_address) && !empty($vendor->shipping_zip)): ?>
                                                            <p class="mb-2">
                                                                <strong class="h5 mb-1 d-block"><?php echo e(__('Shipped To')); ?>

                                                                    :</strong>
                                                                <span class="text-muted d-block" style="max-width:80%">
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
                                                        <p> <?php echo DNS2D::getBarcodeHTML(
                                                            route('pay.billpay', \Illuminate\Support\Facades\Crypt::encrypt($bill->id)),
                                                            'QRCODE',
                                                            2,
                                                            2,
                                                        ); ?></p>
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

                            <div class="row">
                                <div class="col-md-12 invoice-summary mt-3">
                                    <div class="invoice-title border-1 border-bottom mb-3 pb-2">
                                        <h3 class="h4 mb-0"><?php echo e(__('Item Summary')); ?></h3>
                                        <small><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th class="text-white bg-primary text-uppercase" data-width="40">#</th>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->bill_module == 'account' || $bill->bill_module == ''): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item Type')); ?>

                                                    </th>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item')); ?>

                                                    </th>
                                                <?php elseif($bill->bill_module == 'taskly'): ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Project')); ?>

                                                    </th>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Quantity')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Rate')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Discount')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Tax')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Description')); ?>

                                                </th>
                                                <th class="text-right text-white bg-primary text-uppercase"
                                                    width="12%"><?php echo e(__('Price')); ?><br>
                                                    <small
                                                        class="text-danger font-weight-bold"><?php echo e(__('after discount & tax')); ?></small>
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
                                                    <td><?php echo e(currency_format_with_sym($iteam->price, $company_id, $workspace_id)); ?>

                                                    </td>
                                                    <td><?php echo e(currency_format_with_sym($iteam->discount, $company_id, $workspace_id)); ?>

                                                    </td>
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
                                                                        <td><?php echo e(currency_format_with_sym($taxPrice, $company_id, $workspace_id)); ?>

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
                                                    <td style="white-space: break-spaces;">
                                                        <?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?></td>
                                                    <?php
                                                        $tr_tex =
                                                            array_key_exists($key, $TaxPrice_array) == true
                                                                ? $TaxPrice_array[$key]
                                                                : 0;
                                                    ?>
                                                    <td class="text-right">
                                                        <?php echo e(currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $tr_tex, $company_id, $workspace_id)); ?>

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
                                                        <b><?php echo e(currency_format_with_sym($totalRate, $company_id, $workspace_id)); ?></b>
                                                    </td>
                                                    <td class="bg-color">
                                                        <b><?php echo e(currency_format_with_sym($totalDiscount, $company_id, $workspace_id)); ?></b>
                                                    </td>
                                                    <td class="bg-color">
                                                        <b><?php echo e(currency_format_with_sym($totalTaxPrice, $company_id, $workspace_id)); ?></b>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                                    $colspan = 6;
                                                    if ($bill->bill_module == 'account' || $bill->bill_module == '') {
                                                        $colspan = 7;
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Sub Total')); ?></td>
                                                    <td class="text-right">
                                                        <b><?php echo e(currency_format_with_sym($bill->getSubTotal(), $company_id, $workspace_id)); ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Discount')); ?></td>
                                                    <td class="text-right">
                                                        <b><?php echo e(currency_format_with_sym($bill->getTotalDiscount(), $company_id, $workspace_id)); ?></b>
                                                    </td>
                                                </tr>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($taxesData)): ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td colspan="<?php echo e($colspan); ?>"></td>
                                                            <td class="text-right"><?php echo e($taxName); ?></td>
                                                            <td class="text-right">
                                                                <b><?php echo e(currency_format_with_sym($taxPrice, $company_id, $workspace_id)); ?></b>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="blue-text text-right"><?php echo e(__('Total')); ?></td>
                                                    <td class="blue-text text-right">
                                                        <b><?php echo e(currency_format_with_sym($bill->getTotal(), $company_id, $workspace_id)); ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Paid')); ?></td>
                                                    <td class="text-right">
                                                        <b><?php echo e(currency_format_with_sym($bill->getTotal() - $bill->getDue() - $bill->billTotalDebitNote(), $company_id, $workspace_id)); ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Debit Note')); ?></td>
                                                    <td class="text-right">
                                                        <b><?php echo e(currency_format_with_sym($bill->billTotalDebitNote(), $company_id, $workspace_id)); ?></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="<?php echo e($colspan); ?>"></td>
                                                    <td class="text-right"><?php echo e(__('Due')); ?></td>
                                                    <td class="text-right">
                                                        <b><?php echo e(currency_format_with_sym($bill->getDue(), $company_id, $workspace_id)); ?></b>
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

        <div class="col-12">
            <h5 class="mb-4 h4 d-inline-block font-weight-400"><?php echo e(__('Payment Summary')); ?></h5>
            <div class="card">
                <div class="py-0 card-body table-border-style">
                    <div class="m-0 table-responsive">
                        <table class="table ">
                            <tr>
                                <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                <th class="text-dark"><?php echo e(__('Description')); ?></th>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bill->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(company_date_formate($payment->date, $company_id, $workspace_id)); ?></td>
                                    <td><?php echo e(currency_format_with_sym($payment->amount, $company_id, $workspace_id)); ?></td>
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

        <div class="col-12">
            <h5 class="mb-4 h4 d-inline-block font-weight-400"><?php echo e(__('Debit Note Summary')); ?></h5>
            <div class="card">
                <div class="py-0 card-body table-border-style">
                    <div class="m-0 table-responsive">
                        <table class="table ">
                            <tr>
                                <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                <th class="text-dark"><?php echo e(__('Description')); ?></th>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bill->debitNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$debitNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(company_date_formate($debitNote->date, $company_id, $workspace_id)); ?></td>
                                    <td><?php echo e(currency_format_with_sym($debitNote->amount, $company_id, $workspace_id)); ?>

                                    </td>
                                    <td><?php echo e($debitNote->description); ?></td>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('account::layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bill\billpay.blade.php ENDPATH**/ ?>
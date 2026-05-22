<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Purchase Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
        <link rel="stylesheet" href="<?php echo e(asset('packages/workdo/Signature/src/Resources/assets/css/custom.css')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopPush(); ?>
<?php
    $company_settings = getCompanyAllSetting($purchase->created_by, $purchase->workspace);
?>
<?php $__env->startSection('action-btn'); ?>
    <div class="row justify-content-center align-items-center">
        <div class="col-12 d-flex align-items-center justify-content-between justify-content-md-end">
            <div class="all-button-box mr-3 d-flex">
                <a href="<?php echo e(route('purchases.pdf', \Crypt::encrypt($purchase->id))); ?>" target="_blank"
                    class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="<?php echo e(__('Print')); ?>">
                    <span class="btn-inner--icon text-white"><i class="ti ti-printer"></i><?php echo e(__(' Print')); ?></span>
                </a>
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
                                    <h2 class="h3 mb-0"><?php echo e(__('Purchase')); ?></h2>
                                </div>
                                <div class="col-sm-8  col-12">
                                    <div
                                        class="d-flex invoice-wrp flex-wrap align-items-center gap-md-2 gap-1 justify-content-end">
                                        <div
                                            class="d-flex invoice-date flex-wrap align-items-center justify-content-end gap-md-3 gap-1">
                                            <p class="mb-0"><strong><?php echo e(__('Purchase Date')); ?>

                                                    :</strong><?php echo e(company_date_formate($purchase->purchase_date, $purchase->created_by, $purchase->workspace)); ?>

                                            </p>
                                        </div>
                                        <h3 class="invoice-number mb-0">
                                            <?php echo e(\App\Models\Purchase::purchaseNumberFormat($purchase->purchase_id, $purchase->created_by, $purchase->workspace)); ?>

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
                                                <div class="invoice-billed-content">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['purchase_shipping_display']) && $company_settings['purchase_shipping_display'] == 'on'): ?>
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
                                        <strong><?php echo e(__('Status')); ?> :</strong><br>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status == 0): ?>
                                            <span
                                                class="badge fix_badge f-12 p-2 d-inline-block bg-info"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$purchase->status])); ?></span>
                                        <?php elseif($purchase->status == 1): ?>
                                            <span
                                                class="badge fix_badge f-12 p-2 d-inline-block bg-primary"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$purchase->status])); ?></span>
                                        <?php elseif($purchase->status == 2): ?>
                                            <span
                                                class="badge fix_badge f-12 p-2 d-inline-block bg-secondary"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$purchase->status])); ?></span>
                                        <?php elseif($purchase->status == 3): ?>
                                            <span
                                                class="badge fix_badge f-12 p-2 d-inline-block bg-warning"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$purchase->status])); ?></span>
                                        <?php elseif($purchase->status == 4): ?>
                                            <span
                                                class="badge fix_badge f-12 p-2 d-inline-block bg-success"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$purchase->status])); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['purchase_qr_display']) && $company_settings['purchase_qr_display'] == 'on'): ?>
                                        <div class="col-lg-2 col-sm-6">
                                            <div class="float-sm-end qr-code">
                                                <div class="col">
                                                    <div class="float-sm-end">
                                                        <p> <?php echo DNS2D::getBarcodeHTML(
                                                            route('purchases.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($purchase->id)),
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

                            <div class="row mt-4">
                                <div class="col-md-12 invoice-summary mt-3">
                                    <div class="invoice-title border-1 border-bottom mb-3 pb-2">
                                        <h3 class="h4 mb-0"><?php echo e(__('Item Summary')); ?></h3>
                                        <small><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th class="text-white bg-primary text-uppercase" data-width="40">#</th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item Type')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Quantity')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Rate')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Tax')); ?></th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Discount')); ?> </th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Description')); ?>

                                                </th>
                                                <th class="text-white bg-primary text-uppercase" width="12%">
                                                    <?php echo e(__('Price')); ?><br>
                                                    <small class="text-danger "><?php echo e(__('after discount & tax')); ?></small>
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
                                                    <td><?php echo e(!empty($iteam->product) ? $iteam->product->name : ''); ?></td>
                                                    <td><?php echo e($iteam->quantity); ?></td>
                                                    <td><?php echo e(currency_format_with_sym($iteam->price, $purchase->created_by, $purchase->workspace)); ?>

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
                                                                        $taxPrice = App\Models\Purchase::taxRate(
                                                                            $tax->rate,
                                                                            $iteam->price,
                                                                            $iteam->quantity,
                                                                        );
                                                                        $totalTaxPrice += $taxPrice;
                                                                        $data += $taxPrice;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo e($tax->name . ' (' . $tax->rate . '%)'); ?></td>
                                                                        <td><?php echo e(currency_format_with_sym($taxPrice, $purchase->created_by, $purchase->workspace)); ?>

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
                                                    <td>
                                                        <?php echo e(currency_format_with_sym($iteam->discount, $purchase->created_by, $purchase->workspace)); ?>


                                                    </td>
                                                    <td><?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?></td>
                                                    <?php
                                                        $tr_tex =
                                                            array_key_exists($key, $TaxPrice_array) == true
                                                                ? $TaxPrice_array[$key]
                                                                : 0;
                                                    ?>
                                                    <td class="text-end">
                                                        <?php echo e(currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $tr_tex, $purchase->created_by, $purchase->workspace)); ?>

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
                                                        <b><?php echo e(currency_format_with_sym($totalRate, $purchase->created_by, $purchase->workspace)); ?></b>
                                                    </td>
                                                    <td class="bg-color">
                                                        <b><?php echo e(currency_format_with_sym($totalTaxPrice, $purchase->created_by, $purchase->workspace)); ?></b>
                                                    </td>
                                                    <td class="bg-color">
                                                        <b><?php echo e(currency_format_with_sym($totalDiscount, $purchase->created_by, $purchase->workspace)); ?></b>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"></td>
                                                    <td class="text-end"><b><?php echo e(__('Sub Total')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(currency_format_with_sym($purchase->getSubTotal(), $purchase->created_by, $purchase->workspace)); ?>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="7"></td>
                                                    <td class="text-end"><b><?php echo e(__('Discount')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(currency_format_with_sym($purchase->getTotalDiscount(), $purchase->created_by, $purchase->workspace)); ?>

                                                    </td>
                                                </tr>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($taxesData)): ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td colspan="7"></td>
                                                            <td class="text-end"><b><?php echo e($taxName); ?></b></td>
                                                            <td class="text-end">
                                                                <?php echo e(currency_format_with_sym($taxPrice, $purchase->created_by, $purchase->workspace)); ?>

                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <tr>
                                                    <td colspan="7"></td>
                                                    <td class="blue-text text-end"><b><?php echo e(__('Total')); ?></b></td>
                                                    <td class="blue-text text-end">
                                                        <?php echo e(currency_format_with_sym($purchase->getTotal(), $purchase->created_by, $purchase->workspace)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"></td>
                                                    <td class="text-end"><b><?php echo e(__('Paid')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(currency_format_with_sym($purchase->getTotal() - $purchase->getDue(), $purchase->created_by, $purchase->workspace)); ?>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="7"></td>
                                                    <td class="text-end"><b><?php echo e(__('Due')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(currency_format_with_sym($purchase->getDue(), $purchase->created_by, $purchase->workspace)); ?>

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
    </div>

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
                                            <a href="<?php echo e(get_file($payment->add_receipt)); ?>" download=""
                                                class="mx-3 btn btn-sm align-items-center bg-primary"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>"
                                                target="_blank">
                                                <i class="ti ti-download text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn">
                                            <a href="<?php echo e(get_file($payment->add_receipt)); ?>"
                                                class="mx-3 btn btn-sm align-items-center bg-secondary"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Show')); ?>"
                                                target="_blank">
                                                <i class="ti ti-crosshair text-white"></i>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td><?php echo e(company_date_formate($payment->date, $purchase->created_by, $purchase->workspace)); ?></td>
                                <td><?php echo e(currency_format_with_sym($payment->amount, $purchase->created_by, $purchase->workspace)); ?></td>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.invoicepayheader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\purchases\customer_bill.blade.php ENDPATH**/ ?>
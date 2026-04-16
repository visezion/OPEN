<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Proposal Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '.status_change', function() {
            var status = this.value;
            var url = $(this).data('url');
            $.ajax({
                url: url + '?status=' + status,
                type: 'GET',
                cache: false,
                success: function(data) {},
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-btn'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::check() && isset(\Auth::user()->type) && \Auth::user()->type == 'company'): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->status != 0): ?>
            <div class="row justify-content-between align-items-center ">
                <div class="col-10 offset-1 d-flex align-items-center justify-content-between justify-content-md-end">
                    <div class="all-button-box">
                        <a href="<?php echo e(route('proposal.pdf', Crypt::encrypt($proposal->id))); ?>" class="btn btn-sm btn-primary"
                            target="_blank"><i class="ti ti-printer"></i><?php echo e(__('Print')); ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php else: ?>
        <div class="row justify-content-between align-items-center ">
            <div class="col-10  offset-1 d-flex align-items-center justify-content-between justify-content-md-end">
                <div class="all-button-box">
                    <a href="<?php echo e(route('proposal.pdf', Crypt::encrypt($proposal->id))); ?>" class="btn btn-sm btn-primary"
                        target="_blank"><i class="ti ti-printer"></i><?php echo e(__('Print')); ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                    <h2 class="h3 mb-0"><?php echo e(__('Proposal')); ?></h2>
                                </div>
                                <div class="col-sm-8  col-12">
                                    <div
                                        class="d-flex invoice-wrp flex-wrap align-items-center gap-md-2 gap-1 justify-content-end">
                                        <div
                                            class="d-flex invoice-date flex-wrap align-items-center justify-content-end gap-md-3 gap-1">
                                            <p class="mb-0"><strong><?php echo e(__('Issue Date')); ?> :</strong>
                                                <?php echo e(company_date_formate($proposal->issue_date, $proposal->created_by, $proposal->workspace)); ?>

                                            </p>
                                        </div>
                                        <h3 class="invoice-number mb-0">
                                            <?php echo e(\App\Models\Proposal::proposalNumberFormat($proposal->proposal_id, $proposal->created_by, $proposal->workspace)); ?>

                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="p-sm-4 p-3 invoice-billed">
                                <div class="row row-gap">
                                    <div class="col-lg-4 col-sm-6">
                                        <p class="mb-3">
                                            <strong class="h5 mb-1"><?php echo e(__('Name ')); ?> :
                                            </strong><?php echo e(!empty($customer->name) ? $customer->name : ''); ?>

                                        </p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($customer->billing_name) && !empty($customer->billing_address) && !empty($customer->billing_zip)): ?>
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
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div class="col-lg-4 col-sm-6">
                                        <p class="mb-3">
                                            <strong class="h5 mb-1"><?php echo e(__('Email ')); ?> :
                                            </strong><?php echo e(!empty($customer->email) ? $customer->email : ''); ?>

                                        </p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['proposal_shipping_display']) && $company_settings['proposal_shipping_display'] == 'on'): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($customer->shipping_name) && !empty($customer->shipping_address) && !empty($customer->shipping_zip)): ?>
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
                                                    <?php echo e(!empty($customer->shipping_phone) ? $customer->shipping_phone : ''); ?>

                                                </p>
                                                <p class="mb-0">
                                                    <strong><?php echo e(__('Tax Number ')); ?> :
                                                    </strong><?php echo e(!empty($customer->tax_number) ? $customer->tax_number : ''); ?>

                                                </p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div class="col-lg-2 col-sm-6">
                                        <strong class="h5 d-block mb-2"><?php echo e(__('Status')); ?> :</strong>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->status == 0): ?>
                                            <span
                                                class="badge bg-primary p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php elseif($proposal->status == 1): ?>
                                            <span
                                                class="badge bg-info p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php elseif($proposal->status == 2): ?>
                                            <span
                                                class="badge bg-success p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php elseif($proposal->status == 3): ?>
                                            <span
                                                class="badge bg-warning p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php elseif($proposal->status == 4): ?>
                                            <span
                                                class="badge bg-danger p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div class="col-lg-2 col-sm-6">
                                        <div class="float-sm-end qr-code">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['proposal_qr_display']) && $company_settings['proposal_qr_display'] == 'on'): ?>
                                                <div class="col">
                                                    <div class="float-end">
                                                        <?php echo DNS2D::getBarcodeHTML(
                                                            route('pay.proposalpay', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)),
                                                            'QRCODE',
                                                            2,
                                                            2,
                                                        ); ?>

                                                    </div>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($customFields) && count($proposal->customField) > 0): ?>
                                <div class="px-4 mt-3">
                                    <div class="row row-gap">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-xxl-3 col-sm-6">
                                                <strong class="d-block mb-1"><?php echo e($field->name); ?> </strong>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($field->type == 'attachment'): ?>
                                                    <a href="<?php echo e(get_file($proposal->customField[$field->id])); ?>"
                                                        target="_blank">
                                                        <img src=" <?php echo e(get_file($proposal->customField[$field->id])); ?> "
                                                            class="wid-120 rounded">
                                                    </a>
                                                <?php else: ?>
                                                    <p class="mb-0">
                                                        <?php echo e(!empty($proposal->customField[$field->id]) ? $proposal->customField[$field->id] : '-'); ?>

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
                                    <small><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                </div>

                                <div class="table-responsive mt-2">
                                    <table class="table mb-0 table-striped">
                                        <tr>
                                            <th class="text-white bg-primary text-uppercase" data-width="40">#</th>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item Type')); ?>

                                                </th>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Item')); ?>

                                                </th>
                                            <?php elseif($proposal->proposal_module == 'taskly'): ?>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Project')); ?>

                                                </th>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                <th class="text-white bg-primary text-uppercase"><?php echo e(__('Quantity')); ?>

                                                </th>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <th class="text-white bg-primary text-uppercase"><?php echo e(__('Rate')); ?></th>
                                            <th class="text-white bg-primary text-uppercase"> <?php echo e(__('Discount')); ?></th>
                                            <th class="text-white bg-primary text-uppercase"><?php echo e(__('Tax')); ?></th>
                                            <th class="text-white bg-primary text-uppercase"><?php echo e(__('Description')); ?>

                                            </th>

                                            <th class="text-right text-white bg-primary text-uppercase" width="12%">
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

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $iteam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($iteam->tax)): ?>
                                                <?php
                                                    $taxes = \Workdo\ProductService\Entities\Tax::tax($iteam->tax);
                                                    $totalQuantity += $iteam->quantity;
                                                    $totalRate += $iteam->price;
                                                    $totalDiscount += $iteam->discount;
                                                    foreach ($taxes as $taxe) {
                                                        $taxDataPrice = \App\Models\Proposal::taxRate(
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
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account'): ?>
                                                    <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                                    </td>
                                                <?php elseif($proposal->proposal_module == 'taskly'): ?>
                                                    
                                                    <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->title : '--'); ?>

                                                    </td>
                                                <?php elseif($proposal->proposal_module == 'cmms'): ?>
                                                    <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?>

                                                    </td>
                                                    <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                                    </td>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                    <td><?php echo e($iteam->quantity); ?></td>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <td><?php echo e(currency_format_with_sym($iteam->price, $proposal->created_by, $proposal->workspace)); ?>

                                                </td>
                                                <td>
                                                    <?php echo e(currency_format_with_sym($iteam->discount, $proposal->created_by, $proposal->workspace)); ?>

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
                                                                    $taxPrice = App\Models\Proposal::taxRate(
                                                                        $tax->rate,
                                                                        $iteam->price,
                                                                        $iteam->quantity,
                                                                        $iteam->discount,
                                                                    );

                                                                    $totalTaxPrice += $taxPrice;
                                                                    $data += $taxPrice;
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo e($tax->name . ' (' . $tax->rate . '%)'); ?>

                                                                    </td>
                                                                    <td><?php echo e(currency_format_with_sym($taxPrice, $proposal->created_by, $proposal->workspace)); ?>

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
                                                <?php
                                                    $tr_tex =
                                                        array_key_exists($key, $TaxPrice_array) == true
                                                            ? $TaxPrice_array[$key]
                                                            : 0;
                                                ?>
                                                <td><?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?></td>
                                                <td class="text-center">
                                                    <?php echo e(currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $tr_tex, $proposal->created_by, $proposal->workspace)); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                    <td></td>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <td class="bg-color"><b><?php echo e(__('Total')); ?></b></td>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                    <td class="bg-color"><b><?php echo e($totalQuantity); ?></b></td>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <td class="bg-color">
                                                    <b><?php echo e(currency_format_with_sym($totalRate, $proposal->created_by, $proposal->workspace)); ?></b>
                                                </td>
                                                <td class="bg-color">
                                                    <b><?php echo e(currency_format_with_sym($totalDiscount, $proposal->created_by, $proposal->workspace)); ?></b>
                                                </td>
                                                <td class="bg-color">
                                                    <b><?php echo e(currency_format_with_sym($totalTaxPrice, $proposal->created_by, $proposal->workspace)); ?></b>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                                $colspan = 7;
                                                $customerInvoices = ['taskly', 'account', 'cmms', 'cardealership', 'RestaurantMenu', 'rent' , 'Fleet'];

                                                if (in_array($proposal->invoice_module, $customerInvoices)) {
                                                    $colspan = 7;
                                                }

                                                if ($proposal->proposal_module == 'taskly') {
                                                    $colspan = 5;
                                                }
                                            ?>
                                            <tr>
                                                <td colspan="<?php echo e($colspan); ?>"></td>
                                                <td class="text-right"><b><?php echo e(__('Sub Total')); ?></b></td>
                                                <td class="text-right">
                                                    <?php echo e(currency_format_with_sym($proposal->getSubTotal(), $proposal->created_by, $proposal->workspace)); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="<?php echo e($colspan); ?>"></td>
                                                <td class="text-right"><b><?php echo e(__('Discount')); ?></b></td>
                                                <td class="text-right">
                                                    <?php echo e(currency_format_with_sym($proposal->getTotalDiscount(), $proposal->created_by, $proposal->workspace)); ?>

                                                </td>
                                            </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($taxesData)): ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><b><?php echo e($taxName); ?></b></td>
                                                        <td class="text-right">
                                                            <?php echo e(currency_format_with_sym($taxPrice, $proposal->created_by, $proposal->workspace)); ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <tr>
                                                <td colspan="<?php echo e($colspan); ?>"></td>
                                                <td class="blue-text text-right"><b><?php echo e(__('Total')); ?></b></td>
                                                <td class="blue-text text-right">
                                                    <?php echo e(currency_format_with_sym($proposal->getTotal(), $proposal->created_by, $proposal->workspace)); ?>

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.invoicepayheader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\proposal\proposalpay.blade.php ENDPATH**/ ?>
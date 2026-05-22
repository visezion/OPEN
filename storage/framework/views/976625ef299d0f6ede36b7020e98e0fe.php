<?php
    $admin_settings = getAdminAllSetting();
    $company_settings = getCompanyAllSetting(creatorId());
?>

<div class="modal-body">
    <div id="printableArea">
        <div class="invoice">
            <div class="card-header border-bottom pb-2 mb-3 d-flex align-items-top justify-content-between gap-2">
                <div class="invoice-number">
                    <img src="<?php echo e(get_file(sidebar_logo())); ?>" width="140px;">
                </div>
                <div>
                    <a id="downloadBtn" class="btn btn-sm btn-primary text-white" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="<?php echo e(__('Download')); ?>" onclick="saveAsPDF()">
                        <span class="ti ti-download"></span>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="mb-3">
                    <div class="invoice-billed p-3">
                        <div class="row row-gap">
                            <div class="col-sm-4">
                                    <div class="mb-2">
                                        <strong class="mt-2"><?php echo e(__('Invoice ID')); ?> :</strong>
                                        <?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id)); ?>

                                    </div>
                                    <div class="mb-2">
                                        <strong><?php echo e(__('Invoice Date')); ?> :</strong>
                                        <?php echo e(company_date_formate($invoice->issue_date)); ?>

                                    </div>
                                    <div class="mb-2">
                                        <strong><?php echo e(__('Invoice')); ?> :</strong>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->status == 0): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 1): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 2): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 3): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php elseif($invoice->status == 4): ?>
                                            <span><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-sm-4">
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

                            <div class="col-sm-4 text-end">
                                <div class="float-sm-end qr-code">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['invoice_qr_display']) && $company_settings['invoice_qr_display'] == 'on'): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Zatca')): ?>
                                            <div class="float-sm-end">
                                                <?php echo $__env->make('zatca::zatca_qr_code', [
                                                    'invoice_id' => $invoice->id,
                                                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="float-sm-end">
                                                <?php echo DNS2D::getBarcodeHTML(
                                                    route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id)),
                                                    'QRCODE',
                                                    2,
                                                    2,
                                                ); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="invoice-summary card shadow-lg mb-0">
                    <div class="invoice-title border-1 border-bottom mb-3 pb-2">
                        <h3 class="h4 mb-0"><?php echo e(__('Item List')); ?></h3>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr class="thead-default">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->invoice_module == 'account'): ?>
                                        <th class="text-white bg-primary text-uppercase text-start"><?php echo e(__('Item')); ?>

                                        </th>
                                    <?php elseif($invoice->invoice_module == 'taskly'): ?>
                                        <th class="text-white bg-primary text-uppercase"><?php echo e(__('Project')); ?></th>
                                    <?php elseif($invoice->invoice_module == 'childcare'): ?>
                                        <th class="text-white bg-primary text-uppercase"><?php echo e(__('Nutritions')); ?></th>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->invoice_module == 'childcare'): ?>
                                        <th class="text-white bg-primary text-uppercase"><?php echo e(__('Price')); ?></th>
                                    <?php else: ?>
                                        <th class="text-white bg-primary text-uppercase"><?php echo e(__('Description')); ?></th>
                                        <th class="text-white bg-primary text-uppercase"><?php echo e(__('Quantity')); ?></th>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $iteams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $iteam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->invoice_module == 'account'): ?>
                                            <td class="text-start">
                                                <?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                            </td>
                                        <?php elseif($invoice->invoice_module == 'taskly'): ?>
                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->title : ''); ?>

                                            </td>
                                        <?php elseif($invoice->invoice_module == 'childcare'): ?>
                                            <td>
                                                <?php echo e(!empty($iteam) ? $iteam->product_name : ''); ?>

                                            </td>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <td class="text-wrap">
                                            
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->invoice_module == 'childcare'): ?>
                                                <?php echo e($iteam->price ?? ($iteam->price ?? '')); ?>

                                            <?php else: ?>
                                                <?php echo e($iteam->description ?? ($iteam->product()->description ?? '')); ?>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->invoice_module != 'childcare'): ?>
                                            <td><?php echo e($iteam->quantity); ?></td>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="invoice-total mt-3 mb-0 p-3 d-flex align-items-end flex-column justify-content-end"
                        style="min-height: 200px;">
                        <h6 class="mb-0"><?php echo e(__('Customer Signature')); ?> </h6>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>

<script>
    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var downloadBtn = document.getElementById('downloadBtn');

        downloadBtn.style.display = 'none';

        var opt = {
            margin: 0.3,
            filename: '<?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id, $invoice->created_by)); ?>',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: { unit: 'in', format: 'A4' }
        };

        html2pdf().set(opt).from(element).save().then(function () {
            downloadBtn.style.display = 'inline-block';
        });
    }
</script>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\invoice\pdf.blade.php ENDPATH**/ ?>
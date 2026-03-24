<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Customer Statement')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };
            html2pdf().set(opt).from(element).save();
        }

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
        <?php echo e(__('Customer')); ?>,
        <?php echo e($customer['name']); ?>,
    <?php echo e(__('Customer Statement')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="float-end">
        <a  class="btn btn-sm btn-primary" onclick="saveAsPDF()"  data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>">
            <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
        </a>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="col-md-4 col-lg-4 col-xl-4">
            <div class="card bg-none invo-tab">
                <div class="card-body">

                <?php echo e(Form::model($customerDetail,array('route' => array('customer.statement' , $customer->id), 'method' => 'post', 'class'=>'needs-validation', 'novalidate'))); ?>

                <h3 class="small-title"><?php echo e($customer['name'].' '.__('Statement')); ?></h3>
                <div class="row issue_date">
                    <div class="col-md-12">
                        <div class="issue_date_main">
                        <div class="form-group">
                            <?php echo e(Form::label('from_date', __('From Date'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::date('from_date', isset($data['from_date'])?$data['from_date']:null,array('class'=>'form-control ','required'=>'required'))); ?>


                        </div>
                    </div>

                        <div class="issue_date_main">
                        <div class="form-group">
                            <?php echo e(Form::label('until_date', __('Until Date'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::date('until_date', isset($data['until_date'])?$data['until_date']:null,array('class'=>'form-control ','required'=>'required'))); ?>


                        </div>
                    </div>
                    </div>

                </div>

                <div class="col-12 text-end">
                    <input type="submit" value="<?php echo e(__('Apply')); ?>" class="btn btn-sm btn-primary">
                </div>
                <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>


        <div class="col-md-8 col-lg-8 col-xl-8">
            <span id="printableArea">
                <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12">
                                    <img src="<?php echo e(get_file(sidebar_logo())); ?>"
                                        alt="<?php echo e(config('app.name', 'WorkDo')); ?>" class="logo logo-lg" style="max-width: 250px">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12 text-end">
                                    <strong><?php echo e(__('My Company')); ?></strong><br>
                                    <h6 class="invoice-number"><?php echo e($user->email); ?></h6>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-12 text-center">
                                    <strong><h5><?php echo e(__('Statement of Account')); ?></h5></strong>
                                    <strong><?php echo e(($data['from_date']).'  '.'to'.'  '.($data['until_date'])); ?></strong>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <?php if(!empty($customer->billing_name)): ?>
                                    <div class="col-md-6">
                                        <small class="font-style">
                                            <strong><?php echo e(__('Billed To')); ?> :</strong><br>
                                            <?php echo e(!empty($customer->billing_name) ? $customer->billing_name : ''); ?><br>
                                            <?php echo e(!empty($customer->billing_address) ? $customer->billing_address : ''); ?><br>
                                            <?php echo e(!empty($customer->billing_city) ? $customer->billing_city .' ,': ''); ?>

                                            <?php echo e(!empty($customer->billing_state) ? $customer->billing_state .' ,': ''); ?>

                                            <?php echo e(!empty($customer->billing_zip) ? $customer->billing_zip : ''); ?><br>
                                            <?php echo e(!empty($customer->billing_country) ? $customer->billing_country : ''); ?><br>
                                            <?php echo e(!empty($customer->billing_phone) ? $customer->billing_phone : ''); ?><br>
                                            <strong><?php echo e(__('Tax Number ')); ?> : </strong><?php echo e(!empty($customer->tax_number)?$customer->tax_number:''); ?>


                                        </small>
                                    </div>
                                <?php endif; ?>
                                <?php if(company_setting('invoice_shipping_display') == 'on' || company_setting('proposal_shipping_display') == 'on' ): ?>
                                    <div class="col-md-6 text-end">
                                        <small>
                                            <strong><?php echo e(__('Shipped To')); ?> :</strong><br>
                                            <?php echo e(!empty($customer->shipping_name) ? $customer->shipping_name : ''); ?><br>
                                            <?php echo e(!empty($customer->shipping_address) ? $customer->shipping_address : ''); ?><br>
                                            <?php echo e(!empty($customer->shipping_city) ? $customer->shipping_city .' ,': ''); ?>

                                            <?php echo e(!empty($customer->shipping_state) ? $customer->shipping_state .' ,': ''); ?>

                                            <?php echo e(!empty($customer->shipping_zip) ? $customer->shipping_zip : ''); ?><br>
                                            <?php echo e(!empty($customer->shipping_country) ? $customer->shipping_country : ''); ?><br>
                                            <?php echo e(!empty($customer->shipping_phone) ? $customer->shipping_phone : ''); ?><br>
                                            <strong><?php echo e(__('Tax Number ')); ?> : </strong><?php echo e(!empty($customer->tax_number)?$customer->tax_number:''); ?>

                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body table-border-styletable-border-style">
                                    <div class="table-responsive">
                                    <table class="table align-items-center table_header">
                                        <thead>
                                        <tr>
                                            <th scope="col"><?php echo e(__('Date')); ?></th>
                                            <th scope="col"><?php echo e(__('Invoice')); ?></th>
                                            <th scope="col"><?php echo e(__('Payment Type')); ?></th>
                                            <th scope="col"><?php echo e(__('Amount')); ?></th>

                                        </tr>
                                        </thead>
                                        <tbody class="list">
                                        <?php
                                            $total = 0;

                                        ?>
                                        <?php $__empty_1 = true; $__currentLoopData = $invoice_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e(company_date_formate($payment->date)); ?> </td>
                                                <td><?php echo e(\App\Models\Invoice::invoiceNumberFormat($payment->invoice_id)); ?></td>
                                                <td><?php echo e($payment->payment_type); ?> </td>
                                                <td> <?php echo e(currency_format_with_sym(($payment->amount))); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-dark"><p><?php echo e(__('No Data Found')); ?></p></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr class="total">
                                            <td class="light_blue"><span></span><strong><?php echo e(__('TOTAL :')); ?></strong></td>
                                            <td class="light_blue"></td>
                                            <td class="light_blue"></td>
                                            <?php $__currentLoopData = $invoice_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                           <?php
                                               $total += $payment->amount;
                                           ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <td class="light_blue"><span></span><strong><?php echo e(currency_format_with_sym($total)); ?></strong></td>
                                        </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </span>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\customer\statement.blade.php ENDPATH**/ ?>
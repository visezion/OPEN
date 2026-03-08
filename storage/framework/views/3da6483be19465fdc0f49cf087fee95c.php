<!DOCTYPE html>
<html lang="en" dir="<?php echo e($settings['site_rtl'] == 'on' ? 'rtl' : ''); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id, $invoice->created_by, $invoice->workspace)); ?>

        |
        <?php echo e(!empty(company_setting('title_text', $invoice->created_by, $invoice->workspace)) ? company_setting('title_text', $invoice->created_by, $invoice->workspace) : (!empty(admin_setting('title_text')) ? admin_setting('title_text') : 'WorkDo')); ?>

    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">


    <style type="text/css">
        :root {
            --theme-color: <?php echo e($color); ?>;
            --white: #ffffff;
            --black: #000000;
        }

        body {
            font-family: 'Lato', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        p,
        li,
        ul,
        ol {
            margin: 0;
            padding: 0;
            list-style: none;
            line-height: 1.5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr th {
            padding: 0.75rem;
            text-align: left;
        }

        table tr td {
            padding: 0.75rem;
            text-align: left;
        }

        table th small {
            display: block;
            font-size: 12px;
        }

        .invoice-preview-main {
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            background: #ffff;
            box-shadow: 0 0 10px #ddd;
        }

        .invoice-logo {
            max-width: 200px;
            width: 100%;
        }

        .invoice-header table td {
            padding: 15px 30px;
        }

        .text-right {
            text-align: right;
        }

        .no-space tr td {
            padding: 0;
            white-space: nowrap;
        }

        .vertical-align-top td {
            vertical-align: top;
        }

        .view-qrcode {
            max-width: 114px;
            height: 114px;
            margin-left: auto;
            margin-top: 15px;
            background: var(--white);
        }

        .view-qrcode img {
            width: 100%;
            height: 100%;
        }

        .invoice-body {
            padding: 30px 25px 0;
        }

        table.add-border tr {
            border-top: 1px solid var(--theme-color);
        }

        tfoot tr:first-of-type {
            border-bottom: 1px solid var(--theme-color);
        }

        .total-table tr:first-of-type td {
            padding-top: 0;
        }

        .total-table tr:first-of-type {
            border-top: 0;
        }

        .sub-total {
            padding-right: 0;
            padding-left: 0;
        }

        .border-0 {
            border: none !important;
        }

        .invoice-summary td,
        .invoice-summary th {
            font-size: 13px;
            font-weight: 600;
        }

        .total-table td:last-of-type {
            width: 146px;
        }

        .invoice-footer {
            padding: 15px 20px;
        }

        .itm-description td {
            padding-top: 0;
        }

        html[dir="rtl"] table tr td,
        html[dir="rtl"] table tr th {
            text-align: right;
        }

        html[dir="rtl"] .text-right {
            text-align: left;
        }

        html[dir="rtl"] .view-qrcode {
            margin-left: 0;
            margin-right: auto;
        }

        p:not(:last-of-type) {
            margin-bottom: 15px;
        }

        .invoice-footer h6 {
            font-size: 45px;
            line-height: 1.2em;
            font-weight: 400;
            text-align: center;
            font-style: italic;
            color: var(--theme-color);
        }

        .invoice-summary p {
            margin-bottom: 0;
        }

        .wid-75 {
            width: 75px;
        }
    </style>
</head>

<body>
    <div class="invoice-preview-main" id="boxes">
        <div class="invoice-header">
            <table class="vertical-align-top">
                <tbody>
                    <tr>
                        <td>
                            <h3
                                style="text-transform: uppercase; font-size: 30px; font-weight: bold; margin-bottom: 10px; color: <?php echo e($color); ?>;">
                                <?php echo e(__('INVOICE')); ?></h3>
                            <p>
                                <?php if(!empty($settings['company_name'])): ?>
                                    <?php echo e($settings['company_name']); ?>

                                <?php endif; ?>
                                <br>
                                <?php if(!empty($settings['company_email'])): ?>
                                    <?php echo e($settings['company_email']); ?>

                                <?php endif; ?>
                                <br>
                                <?php if(!empty($settings['company_telephone'])): ?>
                                    <?php echo e($settings['company_telephone']); ?>

                                <?php endif; ?>
                                <br>
                                <?php if(!empty($settings['company_address'])): ?>
                                    <?php echo e($settings['company_address']); ?>

                                <?php endif; ?>
                                <?php if(!empty($settings['company_city'])): ?>
                                    <br> <?php echo e($settings['company_city']); ?>,
                                <?php endif; ?>
                                <?php if(!empty($settings['company_state'])): ?>
                                    <?php echo e($settings['company_state']); ?>

                                <?php endif; ?>
                                <?php if(!empty($settings['company_country'])): ?>
                                    <br><?php echo e($settings['company_country']); ?>

                                <?php endif; ?>
                                <?php if(!empty($settings['company_zipcode'])): ?>
                                    - <?php echo e($settings['company_zipcode']); ?>

                                <?php endif; ?>
                            </p>
                            <p>
                                <?php if(!empty($settings['registration_number'])): ?>
                                    <?php echo e(__('Registration Number')); ?> : <?php echo e($settings['registration_number']); ?>

                                <?php endif; ?>
                                <br>
                                <?php if(!empty($settings['tax_type']) && !empty($settings['vat_number'])): ?>
                                    <?php echo e($settings['tax_type'] . ' ' . __('Number')); ?> : <?php echo e($settings['vat_number']); ?>

                                    <br>
                                <?php endif; ?>
                            </p>
                        </td>

                        <td>
                            <div style="justify-content: end; display: flex;">
                                <img class="invoice-logo" src="<?php echo e($img); ?>" alt=""
                                    style="margin-bottom: 15px;">
                            </div>

                            <table class="no-space">
                                <tbody>
                                    <?php if(isset($settings['invoice_qr_display']) && $settings['invoice_qr_display'] == 'on'): ?>
                                        <tr>
                                            <?php if(module_is_active('Zatca', $invoice->created_by)): ?>
                                                <td colspan="2">
                                                    <div class="view-qrcode"
                                                        style="margin-top: 0; margin-bottom: 10px;">
                                                        <?php echo $__env->make('zatca::zatca_qr_code', [
                                                            'invoice_id' => $invoice->invoice_id,
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td colspan="2">
                                                    <div class="view-qrcode"
                                                        style="margin-top: 0; margin-bottom: 10px;">
                                                        <p> <?php echo DNS2D::getBarcodeHTML(
                                                            route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id)),
                                                            'QRCODE',
                                                            2,
                                                            2,
                                                        ); ?>

                                                    </div>
                                                </td>
                                            <?php endif; ?>

                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td><?php echo e(__('Number: ')); ?></td>
                                        <td class="text-right">
                                            <?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id, $invoice->created_by, $invoice->workspace)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo e(__('Issue Date:')); ?></td>
                                        <td class="text-right">
                                            <?php echo e(company_date_formate($invoice->issue_date, $invoice->created_by, $invoice->workspace)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo e(__('Due Date')); ?>:</td>
                                        <td class="text-right">
                                            <?php echo e(company_date_formate($invoice->due_date, $invoice->created_by, $invoice->workspace)); ?>

                                        </td>
                                    </tr>

                                    <?php if(!empty($customFields) && count($invoice->customField) > 0): ?>
                                        <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($field->name); ?>:</td>
                                                <td class="text-right" style="white-space: normal;">
                                                    <?php if($field->type == 'attachment'): ?>
                                                        <a href="<?php echo e(get_file($invoice->customField[$field->id])); ?>"
                                                            target="_blank">
                                                            <img src=" <?php echo e(get_file($invoice->customField[$field->id])); ?> "
                                                                class="wid-75 rounded me-3">
                                                        </a>
                                                    <?php else: ?>
                                                        <p><?php echo e(!empty($invoice->customField[$field->id]) ? $invoice->customField[$field->id] : '-'); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>
        <div class="invoice-body">
            <table>
                <tbody>
                    <tr>
                        <?php if($invoice->invoice_module != 'Fleet'): ?>
                            <td>
                                <p class="mb-3">
                                    <strong class="h5 mb-1"><?php echo e(__('Name ')); ?>:
                                    </strong><?php echo e(!empty($customer->name) ? $customer->name : ''); ?>

                                </p>
                                <?php if(!empty($customer->billing_name) && !empty($customer->billing_address) && !empty($customer->billing_zip)): ?>
                                    <strong style="margin-bottom: 10px; display:block;"><?php echo e(__('Bill To')); ?>:</strong>
                                    <p>
                                        <?php echo e(!empty($customer->billing_name) ? $customer->billing_name : ''); ?><br>
                                        <?php echo e(!empty($customer->billing_address) ? $customer->billing_address : ''); ?><br>
                                        <?php echo e(!empty($customer->billing_city) ? $customer->billing_city . ' ,' : ''); ?>

                                        <?php echo e(!empty($customer->billing_state) ? $customer->billing_state . ' ,' : ''); ?>

                                        <?php echo e(!empty($customer->billing_zip) ? $customer->billing_zip : ''); ?><br>
                                        <?php echo e(!empty($customer->billing_country) ? $customer->billing_country : ''); ?><br>
                                        <?php echo e(!empty($customer->billing_phone) ? $customer->billing_phone : ''); ?><br>
                                    </p>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <p class="mb-3">
                                    <strong class="h5 mb-1"><?php echo e(__('Email ')); ?>:
                                    </strong><?php echo e(!empty($customer->email) ? $customer->email : ''); ?>

                                </p>
                                <?php if($settings['shipping_display'] == 'on'): ?>
                                    <?php if(!empty($customer->shipping_name) && !empty($customer->shipping_address) && !empty($customer->shipping_zip)): ?>
                                        <strong
                                            style="margin-bottom: 10px; display:block;"><?php echo e(__('Ship To')); ?>:</strong>
                                        <p>
                                            <?php echo e(!empty($customer->shipping_name) ? $customer->shipping_name : ''); ?><br>
                                            <?php echo e(!empty($customer->shipping_address) ? $customer->shipping_address : ''); ?><br>
                                            <?php echo e(!empty($customer->shipping_city) ? $customer->shipping_city . ' ,' : ''); ?>

                                            <?php echo e(!empty($customer->shipping_state) ? $customer->shipping_state . ' ,' : ''); ?>

                                            <?php echo e(!empty($customer->shipping_zip) ? $customer->shipping_zip : ''); ?><br>
                                            <?php echo e(!empty($customer->shipping_country) ? $customer->shipping_country : ''); ?><br>
                                            <?php echo e(!empty($customer->shipping_phone) ? $customer->shipping_phone : ''); ?><br>
                                        </p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        <?php if($invoice->invoice_module == 'Fleet'): ?>
                    <tr>
                        <td style="font-size: 13px;">
                            <label class="form-label" for="customer_name"
                                class="form-label"><?php echo e(__('Name : ')); ?></label>
                            <?php echo e($commonCustomer['name']); ?>

                        </td>
                        <td style="font-size: 13px;">
                            <label class="form-label" for="customer_name"
                                class="form-label"><?php echo e(__('Email : ')); ?></label>
                            <?php echo e($commonCustomer['email']); ?>

                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if($invoice->invoice_module == 'sales'): ?>
                        <tr>
                            <td>
                                <strong style="margin-bottom: 10px; display:block;"><?php echo e(__('Bill To')); ?>:</strong>
                                <p>
                                    <?php echo e(!empty($sales_invoice->contacts->name ?? '') ? $sales_invoice->contacts->name ?? '' : ''); ?><br>
                                    <?php echo e(!empty($sales_invoice->contacts->email ?? '') ? $sales_invoice->contacts->email ?? '' : ''); ?><br>
                                    <?php echo e(!empty($sales_invoice->contacts->phone ?? '') ? $sales_invoice->contacts->phone ?? '' : ''); ?><br>
                                    <?php echo e(!empty($sales_invoice->billing_address) ? $sales_invoice->billing_address : ''); ?><br>
                                    <?php echo e(!empty($sales_invoice->billing_city) ? $sales_invoice->billing_city : '' . ', '); ?>

                                    <?php echo e(!empty($sales_invoice->billing_state) ? $sales_invoice->billing_state : ''); ?>,<?php echo e(!empty($sales_invoice->billing_country) ? $sales_invoice->billing_country : ''); ?><br>
                                    <?php echo e(!empty($sales_invoice->billing_postalcode) ? $sales_invoice->billing_postalcode : ''); ?>

                                </p>
                            </td>
                            <?php if($settings['shipping_display'] == 'on'): ?>
                                <td class="text-right">
                                    <strong style="margin-bottom: 10px; display:block;"><?php echo e(__('Ship To')); ?>:</strong>
                                    <p>
                                        <?php echo e(!empty($sales_invoice->shipping_contacts->name ?? '') ? $sales_invoice->shipping_contacts->name ?? '' : ''); ?><br>
                                        <?php echo e(!empty($sales_invoice->shipping_contacts->email ?? '') ? $sales_invoice->shipping_contacts->email ?? '' : ''); ?><br>
                                        <?php echo e(!empty($sales_invoice->shipping_contacts->phone ?? '') ? $sales_invoice->shipping_contacts->phone ?? '' : ''); ?><br>
                                        <?php echo e(!empty($sales_invoice->shipping_address) ? $sales_invoice->shipping_address : ''); ?><br>
                                        <?php echo e(!empty($sales_invoice->shipping_city) ? $sales_invoice->shipping_city : '' . ', '); ?>,<?php echo e(!empty($sales_invoice->shipping_state) ? $sales_invoice->shipping_state : ''); ?>,<?php echo e(!empty($sales_invoice->shipping_country) ? $sales_invoice->shipping_country : ''); ?><br>
                                        <?php echo e(!empty($sales_invoice->shipping_postalcode) ? $sales_invoice->shipping_postalcode : ''); ?>

                                    </p>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                    </tr>
                </tbody>
            </table>
            <table class="add-border invoice-summary" style="margin-top: 30px;">
                <thead style="background-color: var(--theme-color); color:  <?php echo e($font_color); ?>;">
                    <tr>
                        <?php if($invoice->invoice_module == 'account'): ?>
                            <th><?php echo e(__('Item Type')); ?></th>
                        <?php endif; ?>
                        <?php if($invoice->invoice_module == 'Fleet'): ?>
                            <th><?php echo e(__('Distance')); ?></th>
                        <?php endif; ?>
                        <?php if($invoice->invoice_module != 'Fleet'): ?>
                            <th><?php echo e(__('Item')); ?></th>
                            <th><?php echo e(__('Quantity')); ?></th>
                        <?php endif; ?>
                        <th><?php echo e(__('Rate')); ?></th>
                        <?php if($invoice->invoice_module == 'Fleet'): ?>
                            <th><?php echo e(__('Discription')); ?></th>
                        <?php endif; ?>
                        <?php if($invoice->invoice_module != 'Fleet'): ?>
                            <th><?php echo e(__('Discount')); ?></th>
                            <th><?php echo e(__('Tax')); ?> (%)</th>
                        <?php endif; ?>
                        <th><?php echo e(__('Price')); ?><small><?php echo e(__('After discount & tax')); ?></small></th>

                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($invoice->itemData) && count($invoice->itemData) > 0): ?>
                        <?php $__currentLoopData = $invoice->itemData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <?php if($invoice->invoice_module == 'account'): ?>
                                    <td><?php echo e(!empty($item->product_type) ? Str::ucfirst($item->product_type) : '--'); ?>

                                    </td>
                                <?php endif; ?>
                                <td><?php echo e($item->name); ?></td>
                                <?php if($invoice->invoice_module != 'Fleet'): ?>
                                    <td><?php echo e($item->quantity); ?></td>
                                <?php endif; ?>
                                <td><?php echo e(currency_format_with_sym($item->price, $invoice->created_by, $invoice->workspace)); ?>

                                </td>
                                <?php if($invoice->invoice_module == 'Fleet'): ?>
                                    <th><?php echo e($item->description); ?></th>
                                <?php endif; ?>
                                <?php if($invoice->invoice_module != 'Fleet'): ?>
                                    <td><?php echo e($item->discount != 0 ? currency_format_with_sym($item->discount, $invoice->created_by, $invoice->workspace) : '-'); ?>

                                    </td>
                                    <td>
                                        <?php if(!empty($item->itemTax)): ?>
                                            <?php $__currentLoopData = $item->itemTax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span><?php echo e($taxes['name']); ?> </span><span> (<?php echo e($taxes['rate']); ?>)
                                                </span>
                                                <span><?php echo e($taxes['price']); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <p>-</p>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>

                                <?php if($invoice->invoice_module == 'Fleet'): ?>
                                    <?php
                                        $distance = !empty($item->name) ? $item->name : 0;
                                        $price = $item->price * $item->name;
                                    ?>
                                    <td><?php echo e(currency_format_with_sym($price, $invoice->created_by, $invoice->workspace)); ?>

                                    </td>
                                <?php else: ?>
                                    <td><?php echo e(currency_format_with_sym($item->price * $item->quantity - $item->discount + (isset($item->tax_price) ? $item->tax_price : 0), $invoice->created_by, $invoice->workspace)); ?>

                                    </td>
                                <?php endif; ?>
                                <?php if($invoice->invoice_module != 'Fleet'): ?>
                                    <?php if($item->description != null): ?>
                            <tr class="border-0 itm-description ">
                                <td colspan="6"><?php echo e($item->description); ?> </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <p>-</p>
                            <p>-</p>
                        </td>
                        <td>-</td>
                        <td>-</td>
                    <tr class="border-0 itm-description ">
                        <td colspan="6">-</td>
                    </tr>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <?php if($invoice->invoice_module == 'account'): ?>
                            <td></td>
                        <?php endif; ?>
                        <td><?php echo e(__('Total')); ?></td>
                        <?php if($invoice->invoice_module == 'Fleet'): ?>
                            <td><b><?php echo e(currency_format_with_sym($invoice->totalRate, $invoice->created_by, $invoice->workspace)); ?></b>
                            </td>
                            <td></td>
                        <?php else: ?>
                            <td><?php echo e($invoice->totalQuantity); ?></td>

                            <td><?php echo e(currency_format_with_sym($invoice->totalRate, $invoice->created_by, $invoice->workspace)); ?>

                            </td>
                            <td><?php echo e(currency_format_with_sym($invoice->totalDiscount, $invoice->created_by, $invoice->workspace)); ?>

                            </td>
                            <td><?php echo e(currency_format_with_sym($invoice->totalTaxPrice, $invoice->created_by, $invoice->workspace)); ?>

                            </td>
                            <td><?php echo e(currency_format_with_sym($invoice->getSubTotal() - $invoice->getTotalDiscount() + $invoice->getTotalTax(), $invoice->created_by, $invoice->workspace)); ?>

                            </td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php
                            $colspan = 4;
                            if ($invoice->invoice_module == 'account') {
                                $colspan = 5;
                            }
                        ?>
                        <td colspan="<?php echo e($colspan); ?>"></td>
                        <td colspan="2" class="sub-total">
                            <table class="total-table">
                                <?php if($invoice->invoice_module != 'Fleet'): ?>

                                    <tr>

                                        <td><?php echo e(__('Subtotal')); ?>:</td>
                                        <td><?php echo e(currency_format_with_sym($invoice->getSubTotal(), $invoice->created_by, $invoice->workspace)); ?>

                                        </td>
                                    </tr>
                                    <?php if($invoice->getTotalDiscount()): ?>
                                        <tr>
                                            <td><?php echo e(__('Discount')); ?>:</td>
                                            <td><?php echo e(currency_format_with_sym($invoice->getTotalDiscount(), $invoice->created_by, $invoice->workspace)); ?>

                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if(!empty($invoice->taxesData)): ?>
                                    <?php $__currentLoopData = $invoice->taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($taxName); ?> :</td>
                                            <td><?php echo e(currency_format_with_sym($taxPrice, $invoice->created_by, $invoice->workspace)); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <tr>
                                    <td><?php echo e(__('Total')); ?>:</td>
                                    <?php if($invoice->invoice_module == 'Fleet'): ?>
                                        <td><?php echo e(currency_format_with_sym($invoice->getFleetSubTotal(), $invoice->created_by, $invoice->workspace)); ?>

                                        </td>
                                    <?php else: ?>
                                        <td><?php echo e(currency_format_with_sym($invoice->getSubTotal() - $invoice->getTotalDiscount() + $invoice->getTotalTax(), $invoice->created_by, $invoice->workspace)); ?>

                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <td><?php echo e(__('Paid')); ?>:</td>
                                    <td><?php echo e(currency_format_with_sym($invoice->getTotal() - $invoice->getDue() - $invoice->invoiceTotalCreditNote(), $invoice->created_by, $invoice->workspace)); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo e(__('Credit Note')); ?>:</td>
                                    <td><?php echo e(currency_format_with_sym($invoice->invoiceTotalCreditNote(), $invoice->created_by, $invoice->workspace)); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo e(__('Due Amount')); ?>:</td>
                                    <td><?php echo e(currency_format_with_sym($invoice->getDue(), $invoice->created_by, $invoice->workspace)); ?>

                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <table class="add-border bank-details" style="margin-top: 30px;">
                <thead style="background-color: var(--theme-color);color: <?php echo e($font_color); ?>;">
                    <tr>
                        <th><?php echo e(__('Name')); ?></th>
                        <th><?php echo e(__('Bank')); ?></th>
                        <th><?php echo e(__('Account Number')); ?></th>
                        <th><?php echo e(__('Contact Number')); ?></th>
                        <th><?php echo e(__('Bank Address')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($bank_details_list) && count($bank_details_list) > 0): ?>
                        <?php $__currentLoopData = $bank_details_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($bank->holder_name); ?></td>
                                <td><?php echo e($bank->bank_name); ?></td>
                                <td><?php echo e($bank->account_number); ?></td>
                                <td><?php echo e($bank->contact_number); ?></td>
                                <td><?php echo e($bank->bank_address); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="invoice-footer">
                <p><?php echo e($settings['footer_notes']); ?></p>
                <h6><?php echo e($settings['footer_title']); ?></h6>
            </div>
        </div>
    </div>
    <?php if(!isset($preview)): ?>
        <?php echo $__env->make('invoice.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\invoice\templates\template4.blade.php ENDPATH**/ ?>
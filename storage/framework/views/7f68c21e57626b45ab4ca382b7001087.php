<?php
    $company_settings = getCompanyAllSetting();
?>

<h5 class="h4 d-inline-block font-weight-400 mb-4"><?php echo e(__('Items')); ?></h5>
<div class="card repeater" <?php if($acction == 'edit'): ?> data-value='<?php echo json_encode($invoice->items); ?>' <?php endif; ?>>
    <div class="item-section p-3 pb-0">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-12 d-flex align-items-center justify-content-md-end px-4">
                <a href="#" data-repeater-create="" class="btn btn-primary mr-2" data-toggle="modal"
                    data-target="#add-bank">
                    <i class="ti ti-plus"></i> <?php echo e(__('Add Item')); ?>

                </a>
            </div>
        </div>
    </div>
    <div class="card-body table-border-style">
        <div class="table-responsive">
            <table class="table  mb-0 table-custom-style" data-repeater-list="items" id="sortable-table">
                <thead>
                    <tr>
                        <th><?php echo e(__('Item Type')); ?></th>
                        <th><?php echo e(__('Items')); ?></th>
                        <th><?php echo e(__('Quantity')); ?></th>
                        <th><?php echo e(__('Price')); ?> </th>
                        <th><?php echo e(__('Discount')); ?></th>
                        <th><?php echo e(__('Tax')); ?> (%)</th>
                        <th class="text-end"><?php echo e(__('Amount')); ?> <br><small
                                class="text-danger font-weight-bold"><?php echo e(__('After discount & tax')); ?></small></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody class="ui-sortable" data-repeater-item>
                    <tr>
                        <?php echo e(Form::hidden('id', null, ['class' => 'form-control id'])); ?>

                        <td class="form-group pt-0">
                            <?php echo e(Form::select('product_type', $product_type, null, ['class' => 'form-control product_type ', 'required' => 'required', 'placeholder' => '--'])); ?>

                        </td>
                        <td width="25%" class="form-group pt-0 product_div">
                            <select name="item" class="form-control product_id item  js-searchBox"
                                data-url="<?php echo e(route('invoice.product')); ?>" required>
                                <option value="0"><?php echo e('--'); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $product_services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($product_service); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($product_services_count)): ?>
                                <div class=" text-xs"><?php echo e(__('Please create Product first.')); ?><a
                                        href="<?php echo e(route('product-service.index')); ?>"><b><?php echo e(__('Add Product')); ?></b></a>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td>
                            <div class="form-group price-input input-group search-form mb-0" style="width: 160px">
                                <?php echo e(Form::text('quantity', '', ['class' => 'form-control quantity', 'required' => 'required', 'placeholder' => __('Qty'), 'required' => 'required'])); ?>

                                <span class="unit input-group-text bg-transparent"></span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group price-input input-group search-form mb-0" style="width: 160px">
                                <?php echo e(Form::text('price', '', ['class' => 'form-control price', 'required' => 'required', 'placeholder' => __('Price'), 'required' => 'required'])); ?>

                                <span
                                    class="input-group-text bg-transparent"><?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : ''); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group price-input input-group search-form mb-0" style="width: 160px">
                                <?php echo e(Form::text('discount', '', ['class' => 'form-control discount', 'required' => 'required', 'placeholder' => __('Discount')])); ?>

                                <span
                                    class="input-group-text bg-transparent"><?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : ''); ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group mb-0">
                                <div class="input-group colorpickerinput">
                                    <div class="taxes"></div>
                                    <?php echo e(Form::hidden('tax', '', ['class' => 'form-control tax text-dark'])); ?>

                                    <?php echo e(Form::hidden('itemTaxPrice', '', ['class' => 'form-control itemTaxPrice'])); ?>

                                    <?php echo e(Form::hidden('itemTaxRate', '', ['class' => 'form-control itemTaxRate'])); ?>

                                </div>
                            </div>
                        </td>

                        <td class="text-end amount"><?php echo e(__('0.00')); ?></td>
                        <td>
                            <a href="#" class="action-btn ms-2 float-end" data-repeater-delete>
                                <div class="mx-3 btn btn-sm d-inline-flex align-items-center m-2 p-2 bg-danger">
                                    <i class="ti ti-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="Delete"></i>
                                </div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-group mb-0">
                                <?php echo e(Form::textarea('description', null, ['class' => 'form-control pro_description', 'rows' => '2', 'placeholder' => __('Description')])); ?>

                            </div>
                        </td>
                        <td colspan="5"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td></td>
                        <td><strong><?php echo e(__('Sub Total')); ?>

                                (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : ''); ?>)</strong>
                        </td>
                        <td class="text-end subTotal"><?php echo e(__('0.00')); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td></td>
                        <td><strong><?php echo e(__('Discount')); ?>

                                (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : ''); ?>)</strong>
                        </td>
                        <td class="text-end totalDiscount"><?php echo e(__('0.00')); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td></td>
                        <td><strong><?php echo e(__('Tax')); ?>

                                (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : ''); ?>)</strong>
                        </td>
                        <td class="text-end totalTax"><?php echo e(__('0.00')); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="blue-text"><strong><?php echo e(__('Total Amount')); ?>

                                (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : ''); ?>)</strong>
                        </td>
                        <td class="text-end totalAmount blue-text"><?php echo e(__('0.00')); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    var selector = "body";
    if ($(selector + " .repeater").length) {
        var $dragAndDrop = $("body .repeater tbody").sortable({
            handle: '.sort-handler'
        });
        var $repeater = $(selector + ' .repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'status': 1
            },
            show: function() {
                $(this).slideDown();
                var file_uploads = $(this).find('input.multi');
                if (file_uploads.length) {
                    $(this).find('input.multi').MultiFile({
                        max: 3,
                        accept: 'png|jpg|jpeg',
                        max_size: 2048
                    });
                }
                // for item SearchBox ( this function is  custom Js )
                JsSearchBox();
            },
            hide: function(deleteElement) {
                var $row = $(this); // The current row
                var id = $row.find('.id').val(); // Get the item ID

                // Call the global delete function
                deleteInvoiceItem($row, id, function() {
                    // Call the global delete function
                    var totalItemTaxPrice = 0;
                    var itemTaxPriceInput = $('.itemTaxPrice');
                    for (var j = 0; j < itemTaxPriceInput.length; j++) {
                        totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                    }
                    var totalItemPrice = 0;
                    var inputs_quantity = $(".quantity");
                    var priceInput = $('.price');
                    for (var j = 0; j < priceInput.length; j++) {
                        totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
                    }
                    var inputs = $(".amount");
                    var subTotal = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                    }
                    var totalItemDiscountPrice = 0;
                    var itemDiscountPriceInput = $('.discount');
                    for (var k = 0; k < itemDiscountPriceInput.length; k++) {
                        if (itemDiscountPriceInput[k].value == '') {
                            itemDiscountPriceInput[k].value = parseFloat(0);
                        }
                        totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
                    }
                    $('.subTotal').html(totalItemPrice.toFixed(2));
                    $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                    $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
                    $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));
                });
            },
            ready: function(setIndexes) {
                $dragAndDrop.on('drop', setIndexes);
            },
            isFirstItemUndeletable: true
        });
        var value = $(selector + " .repeater").attr('data-value');
        if (typeof value != 'undefined' && value.length != 0) {
            value = JSON.parse(value);
            $repeater.setList(value);
        }
    }
</script>
<script>
    $(document).on('change', '.product_type', function() {
        ProductType($(this));
    });

    function ProductType(data, id = null, type = null) {
        var product_type = data.val();
        var selector = data;
        var itemSelect = selector.parent().parent().find('.product_id.item').attr('name');
        
        var productItem = $('.product_id');
        var values = [];
        
        for (var j = 0; j < productItem.length; j++) {
            var val = productItem[j].value.trim();
            if (val !== '') {
                values.push(val);
            }
        }
        var productItems = values.join(',');
        var account_type = $('#account_type').val();
        $.ajax({
            url: '<?php echo e(route('get.item')); ?>',
            type: 'POST',
            data: {
                "product_type": product_type,
                "productItems": productItems,
                "type": type,
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            beforeSend: function() {
                    $(".loader-wrapper").removeClass('d-none');
                },
            success: function(data) {

                if(account_type == 'SalesAgent'){
                    var product_select = `<select class="form-control product_id item" name="${itemSelect}"
                                        placeholder="Select Item" data-url="<?php echo e(route('invoice.product')); ?>" required = 'required' disabled>
                                        </select>`;
                }
                else {
                    var product_select = `<select class="form-control product_id item js-searchBox" name="${itemSelect}"
                                            placeholder="Select Item" data-url="<?php echo e(route('invoice.product')); ?>" required = 'required'>
                                            </select>`;
                }
                
                selector.parent().parent().find('.product_id').empty();
                selector.parent().parent().find('.product_div').html(product_select);

                selector.parent().parent().find('.product_id').append(
                    '<option value="0"> <?php echo e(__('Select Item')); ?> </option>');
                $.each(data, function(key, value) {
                    var selected = (key == id) ? 'selected' : '';
                    selector.parent().parent().find('.product_id').append('<option value="' + key +
                        '" ' + selected + '>' + value + '</option>');
                });
                if (type == 'edit') {
                    changeItem(selector.parent().parent().find('.product_id'));
                } else {
                    items(selector.parent().parent().find('.product_id'));
                }
                // Initialize your searchBox here if needed
                selector.parent().parent().find(".js-searchBox").searchBox({
                    elementWidth: '250'
                });
                selector.parent().parent().find('.unit.input-group-text').text("");
                $(".loader-wrapper").addClass('d-none');
            }
        });
    }
</script>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($acction == 'edit'): ?>
    <script>
        $(document).ready(function() {
            $("#customer").trigger('change');

            var value = $(selector + " .repeater").attr('data-value');
            var type = '<?php echo e($type); ?>';
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);

                // Remove delete button for first row
                $('.repeater [data-repeater-item]').first().find('[data-repeater-delete]').remove();
                
                for (var i = 0; i < value.length; i++) {
                    var tr = $('#sortable-table .id[value="' + value[i].id + '"]').parent();
                    tr.find('.item').val(value[i].product_id);
                    if (type == 'product' || type == 'salesagent') {
                        var element = tr.find('.product_type');
                        var product_id = value[i].product_id;
                        ProductType(element, product_id, 'edit');
                    }
                    if(type == 'salesagent')
                    {
                        $('.item-section').addClass('d-none');
                    }
                }
            }
            const elementsToRemove = document.querySelectorAll('.bs-pass-para.repeater-action-btn');
            if (elementsToRemove.length > 0) {
                elementsToRemove[0].remove();
            }
        });
    </script>
    <script>
        var invoice_id = '<?php echo e($invoice->id); ?>';

        function changeItem(element) {

            var iteams_id = element.val();

            var url = element.data('url');
            var el = element;

            $.ajax({
                url: '<?php echo e(route('invoice.items')); ?>',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'invoice_id': invoice_id,
                    'product_id': iteams_id,
                },

                cache: false,
                success: function(data) {
                    var item = JSON.parse(data);
                    var invoiceItems = item.items;

                    if (invoiceItems != null) {
                        var amount = (invoiceItems.price * invoiceItems.quantity);

                        $(el.parent().parent().find('.quantity')).val(invoiceItems
                            .quantity);
                        $(el.parent().parent().find('.price')).val(invoiceItems.price);
                        $(el.parent().parent().find('.discount')).val(invoiceItems
                            .discount);
                    } else {
                        $(el.parent().parent().find('.quantity')).val(1);
                        $(el.parent().parent().find('.price')).val(item.product.sale_price);
                        $(el.parent().parent().find('.discount')).val(0);
                    }


                    var taxes = '';
                    var tax = [];

                    var totalItemTaxRate = 0;
                    for (var i = 0; i < item.taxes.length; i++) {
                        taxes +=
                            '<span class="badge bg-primary p-2 px-3 me-1">' +
                            item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' +
                            '</span>';
                        tax.push(item.taxes[i].id);
                        totalItemTaxRate += parseFloat(item.taxes[i].rate);
                    }

                    if (invoiceItems != null) {
                        var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (
                            invoiceItems.price * invoiceItems.quantity));
                    } else {
                        var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (item
                            .product.sale_price * 1));
                    }

                    $(el.parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(
                        2));
                    $(el.parent().parent().find('.itemTaxRate')).val(totalItemTaxRate
                        .toFixed(2));
                    $(el.parent().parent().find('.taxes')).html(taxes);
                    $(el.parent().parent().find('.tax')).val(tax);
                    $(el.parent().parent().find('.unit')).html(item.unit);

                    $(".discount").trigger('change');
                }
            });
        }
    </script>


<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\invoice\main.blade.php ENDPATH**/ ?>
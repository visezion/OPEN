
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
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                    $(this).remove();

                    $(document).on('click', '[data-repeater-delete]', function ()
                    {
                        var el = $(this).parent().parent();
                        var id = $(el.find('.id')).val();

                        $.ajax({
                            url: '<?php echo e(route('bill.product.destroy')); ?>',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': jQuery('#token').val()
                            },
                            data: {
                                'id': id
                            },
                            cache: false,
                            success: function (data) {
                                if (data.error) {
                                        toastrs('Error', data.error, 'error');
                                } else {
                                        toastrs('Success', data.success, 'success');
                                }
                            },
                            error: function (data) {
                                console.log(data);

                                toastrs('Error','<?php echo e(__("something went wrong please try again")); ?>', 'error');
                            },
                        });
                    });

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
                }
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
    $(document).on('change', '.product_type', function()
    {
        ProductType($(this));
    });
    function ProductType(data,id= null,type=null){
        var product_type = data.val();
        var selector = data;
        var itemSelect = selector.parent().parent().find('.product_id.item').attr('name');

        $.ajax({
            url: '<?php echo e(route('get.item')); ?>',
            type: 'POST',
            data: {
                "product_type": product_type,
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function(data) {
                selector.parent().parent().find('.product_id').empty();
                var product_select = `<select class="form-control product_id item js-searchBox" name="${itemSelect}"
                                        placeholder="Select Item" data-url="<?php echo e(route('bill.product')); ?>" required = 'required'>
                                        </select>`;
                selector.parent().parent().find('.product_div').html(product_select);

                selector.parent().parent().find('.product_id').append('<option value="0"> <?php echo e(__('Select Item')); ?> </option>');
                $.each(data, function(key, value) {
                    var selected = (key == id) ? 'selected' : '';
                    selector.parent().parent().find('.product_id').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                });
                if(type == 'edit')
                {
                    changeItem(selector.parent().parent().find('.product_id'));
                }
                else
                {
                    items(selector.parent().parent().find('.product_id'));
                }
                // Initialize your searchBox here if needed
                selector.parent().parent().find(".js-searchBox").searchBox({ elementWidth: '250' });
                selector.parent().parent().find('.unit.input-group-text').text("");
            }
        });
    }
</script>
<?php if($acction == 'edit'): ?>
    <script>
        $(document).ready(function() {
            $("#vendor").trigger('change');
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
                    if (type == 'product') {
                        var element = tr.find('.product_type');
                        var product_id = value[i].product_id;
                        ProductType(element,product_id,'edit');
                        changeItem(tr.find('.item'));
                    }
                }
            }
        });
    </script>
    <?php if($type == 'product'): ?>
        <script>
            var bill_id = '<?php echo e($bill->id); ?>';

            function changeItem(element) {
                var iteams_id = element.val();

                var url = element.data('url');
                var el = element;
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('#token').val()
                    },
                    data: {
                        'product_id': iteams_id
                    },
                    cache: false,
                    success: function(data) {
                        var item = JSON.parse(data);

                        $.ajax({
                            url: '<?php echo e(route('bill.items')); ?>',
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': jQuery('#token').val()
                            },
                            data: {
                                'bill_id': bill_id,
                                'product_id': iteams_id,
                            },

                            cache: false,
                            success: function(data) {
                                var billItems = JSON.parse(data);
                                if (billItems != null) {
                                    var amount = (billItems.price * billItems.quantity);

                                    $(el.parent().parent().find('.quantity')).val(billItems
                                    .quantity);
                                    $(el.parent().parent().find('.price')).val(billItems.price);
                                    $(el.parent().parent().find('.discount')).val(billItems.discount);
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

                                if (billItems != null) {
                                    var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (
                                        billItems.price * billItems.quantity));
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
                    },
                });
            }
            $(document).on('click', '[data-repeater-create]', function() {
                $('.item :selected').each(function() {
                    var id = $(this).val();
                    $(".item option[value=" + id + "]").addClass("d-none");
                });
            })
        </script>
    <?php elseif($type == 'project'): ?>
        <script>
            $(document).ready(function() {
                $(".price").trigger("keyup");
                $(".discount").trigger("change");
                $("#tax_project").trigger('change');
            });
        </script>
    <?php endif; ?>
<?php endif; ?>
<script>
     $(document).on('click', '[data-repeater-create]', function() {
        $('.item :selected').each(function() {
            var id = $(this).val();
            if(id != '')
            {
                $(".item option[value=" + id + "]").addClass("d-none");
            }
        });
    })

    $(".tax_get").click(function() {
        myFunction();

    });
    $(".get_tax").change(function() {
        myFunction();
    });

    function myFunction() {
        var tax_id = $('.get_tax').val();

        if (tax_id != "") {
            $.ajax({
                url: '<?php echo e(route('get.taxes')); ?>',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'tax_id': tax_id,
                },
                cache: false,
                success: function(data) {
                    var obj = jQuery.parseJSON(data);


                    var taxes = '';
                    var tax = [];
                    $.each(obj, function() {

                        taxes += '<span class="badge bg-primary p-2 px-3 me-1">' +
                            this.name + ' ' + '(' + this.rate + '%)' +
                            '</span>';
                        tax.push(this.id);

                    });

                    $('.taxes').html(taxes);
                },
            });
        } else {
            $('.taxes').html("");
        }
    }
</script>
<?php
    $company_settings = getCompanyAllSetting();
?>
<?php if($type == 'product'): ?>
    <h5 class="h4 d-inline-block font-weight-400 mb-4"><?php echo e(__('Items')); ?></h5>
    <div class="card repeater" <?php if($acction == 'edit'): ?> data-value='<?php echo json_encode($bill->items); ?>' <?php endif; ?>>
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
        <div class="card-body table-border-style mt-2">
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
                                    <select name="item" class="form-control product_id item  js-searchBox" data-url="<?php echo e(route('bill.product')); ?>" required>
                                        <option value="0"><?php echo e('--'); ?></option>
                                        <?php $__currentLoopData = $product_services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$product_service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($product_service); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                <?php if(empty($product_services_count)): ?>
                                    <div class=" text-xs"><?php echo e(__('Please create Product first.')); ?><a
                                            href="<?php echo e(route('product-service.index')); ?>"><b><?php echo e(__('Add Product')); ?></b></a>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="form-group price-input input-group search-form" style="width: 160px">
                                    <?php echo e(Form::number('quantity', '', ['class' => 'form-control quantity', 'required' => 'required', 'placeholder' => __('Qty'), 'required' => 'required','step'=>'0.01'])); ?>

                                    <span class="unit input-group-text bg-transparent"></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group price-input input-group search-form" style="width: 160px">
                                    <?php echo e(Form::number('price', '', ['class' => 'form-control price', 'required' => 'required', 'placeholder' => __('Price'), 'required' => 'required','step'=>'0.01'])); ?>

                                    <span class="input-group-text bg-transparent"><?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group price-input input-group search-form" style="width: 160px">
                                    <?php echo e(Form::number('discount', '', ['class' => 'form-control discount', 'required' => 'required', 'placeholder' => __('Discount'),'step'=>'0.01'])); ?>

                                    <span
                                        class="input-group-text bg-transparent"><?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group colorpickerinput">
                                        <div class="taxes"></div>
                                        <?php echo e(Form::hidden('tax', '', ['class' => 'form-control tax text-dark'])); ?>

                                        <?php echo e(Form::hidden('itemTaxPrice', '', ['class' => 'form-control itemTaxPrice'])); ?>

                                        <?php echo e(Form::hidden('itemTaxRate', '', ['class' => 'form-control itemTaxRate'])); ?>

                                    </div>
                                </div>
                            </td>

                            <td class="text-end amount">0.00</td>
                            <td>
                                <a href="#" class="action-btn ms-2 float-end" data-repeater-delete="">
                                    <div class="mx-3 btn btn-sm d-inline-flex align-items-center m-2 p-2 bg-danger" bis_skin_checked="1">
                                        <i class="ti ti-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="Delete"></i>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="form-group">
                                <?php echo e(Form::textarea('description', null, ['class'=>'form-control pro_description','rows'=>'2','placeholder'=>__('Description')])); ?>

                            </td>
                            <td></td>

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

                                    (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?>)</strong>
                            </td>
                            <td class="text-end subTotal">0.00</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td><strong><?php echo e(__('Discount')); ?>

                                    (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?>)</strong>
                            </td>
                            <td class="text-end totalDiscount">0.00</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td><strong><?php echo e(__('Tax')); ?> (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?>)</strong>
                            </td>
                            <td class="text-end totalTax">0.00</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="blue-text"><strong><?php echo e(__('Total Amount')); ?>

                                    (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?>)</strong></td>
                            <td class="text-end totalAmount blue-text">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
<?php elseif($type == 'project'): ?>
    <h5 class="h4 d-inline-block font-weight-400 mb-4 pro_name"><?php echo e(__('Project')); ?></h5>
    <?php echo e(Form::hidden('itemTaxRate', null, ['class' => 'form-control itemTaxRate'])); ?>



    <div class="card repeater" <?php if($acction == 'edit'): ?> data-value='<?php echo json_encode($bill->items); ?>' <?php endif; ?>>
        <div class="item-section p-3 pb-0">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-12 d-flex align-items-center justify-content-md-end px-4">
                    <a href="#" data-repeater-create="" class="btn btn-primary tax_get mr-2" data-toggle="modal"
                        data-target="#add-bank">
                        <i class="ti ti-plus"></i> <?php echo e(__('Add Item')); ?>

                    </a>
                </div>
            </div>
        </div>
        <div class="card-body table-border-style mt-2">
            <div class="table-responsive">
                <table class="table  mb-0 table-custom-style" data-repeater-list="items" id="sortable-table">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Items')); ?></th>
                            <th><?php echo e(__('Price')); ?> </th>
                            <th><?php echo e(__('Discount')); ?></th>
                            <th width="200px"><?php echo e(__('Tax')); ?> (%)</th>
                            <th class="text-end"><?php echo e(__('Amount')); ?> <br><small
                                    class="text-danger font-weight-bold"><?php echo e(__('After discount & tax')); ?></small></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="ui-sortable" data-repeater-item>
                        <tr>
                            <td width="25%" class="form-group pt-0">
                                <?php echo e(Form::hidden('id', null, ['class' => 'form-control id'])); ?>

                                <?php echo e(Form::select('item', $tasks, null, ['class' => 'form-control item js-searchBox', 'required' => 'required'])); ?>

                            </td>
                            <td>
                                <div class="form-group price-input input-group search-form" style="width: 160px">
                                    <?php echo e(Form::number('price', '', ['class' => 'form-control price','placeholder' => __('Price'), 'required' => 'required','step'=>'0.01'])); ?>

                                    <span
                                        class="input-group-text bg-transparent"><?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?></span>
                                </div>
                            </td>
                            <?php echo e(Form::hidden('quantity',1, ['class' => 'form-control quantity', 'placeholder' => __('Qty'), 'required' => 'required'])); ?>

                            <td>
                                <div class="form-group price-input input-group search-form" style="width: 160px">
                                    <?php echo e(Form::number('discount', '', ['class' => 'form-control discount', 'placeholder' => __('Discount'),'step'=>'0.01'])); ?>

                                    <span
                                        class="input-group-text bg-transparent"><?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="taxes"></div>
                                        <?php echo e(Form::hidden('tax', null, ['class' => 'form-control tax'])); ?>

                                        <?php echo e(Form::hidden('itemTaxPrice', '', ['class' => 'form-control itemTaxPrice'])); ?>

                                        <?php echo e(Form::hidden('itemTaxRate', '', ['class' => 'form-control itemTaxRate'])); ?>

                                    </div>
                                </div>
                            </td>
                            <td class="text-end amount">0.00</td>
                            <td>
                                <div class="action-btn ms-2 float-end" data-repeater-delete>
                                    <a href="#!"
                                        class="mx-3 btn btn-sm d-inline-flex align-items-center m-2 p-2 bg-danger">
                                          <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                          data-bs-original-title="<?php echo e(__('Delete')); ?>" ></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2', 'placeholder' => __('Description')])); ?>

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
                            <td></td>
                            <td><strong><?php echo e(__('Sub Total')); ?>

                                    (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?>)</strong>
                            </td>
                            <td class="text-end subTotal">0.00</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td><strong><?php echo e(__('Discount')); ?>

                                    (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?>)</strong>
                            </td>
                            <td class="text-end totalDiscount">0.00</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td><strong><?php echo e(__('Tax')); ?> (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?>)</strong>
                            </td>
                            <td class="text-end totalTax">0.00</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="blue-text"><strong><?php echo e(__('Total Amount')); ?>

                                    (<?php echo e(isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] :  ''); ?>)</strong></td>
                            <td class="text-end totalAmount blue-text">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bill\section.blade.php ENDPATH**/ ?>
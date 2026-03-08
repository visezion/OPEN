<?php
    $userprice = !empty($plan) ? $plan->price_per_user_monthly : 0;
    $userpriceyearly = !empty($plan) ? $plan->price_per_user_yearly : 0;

    $workspaceprice = !empty($plan) ? $plan->price_per_workspace_monthly : 0;
    $workspacepriceyearly = !empty($plan) ? $plan->price_per_workspace_yearly : 0;

    $planprice = !empty($plan) ? $plan->package_price_monthly : 0;
    $planpriceyearly = !empty($plan) ? $plan->package_price_yearly : 0;
    $currancy_symbol = admin_setting('defult_currancy_symbol');

    $currency_setting = json_encode(Arr::only(getAdminAllSetting(), ['site_currency_symbol_position','currency_format','currency_space','site_currency_symbol_name','defult_currancy_symbol','defult_currancy','float_number','decimal_separator','thousand_separator']));
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Pricing')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Pricing')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- [ Main Content ] start -->
    <?php if((admin_setting('custome_package') == 'on') && (admin_setting('plan_package') == 'on')): ?>
        <div class=" col-12">
            <div class="">
                <div class="card-body package-card-inner  d-flex align-items-center justify-content-center mb-4">
                    <div class="tab-main-div">
                        <div class="nav-pills">
                            <a class="nav-link  p-2"   href="<?php echo e(route('active.plans')); ?>" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo e(__('Pre-Packaged Subscription')); ?></a>
                    </div>
                    <div class="nav-pills">
                        <a class="nav-link active p-2"   href="<?php echo e(route('plans.index',['type'=>'subscription'])); ?>" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo e(__('Usage Subscription')); ?></a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-8 col-xl-7">
                    <div class="row">
                        <?php if(SubscriptionDetails()['status'] == true): ?>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body package-card-inner  d-flex align-items-center">
                                        <div class="package-itm theme-avtar border border-secondary">
                                            <img src="<?php echo e((!empty(admin_setting('favicon')) && check_file(admin_setting('favicon'))) ? get_file(admin_setting('favicon')) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?'.time()); ?>" alt="">
                                        </div>
                                        <div class="package-content flex-grow-1  px-3">
                                            <h4><?php echo e(__('Current Subscription')); ?></h4>
                                            <div class="text-muted"> <a href="#activated-add-on"><?php echo e(count($purchaseds). __(' Premium Add-on Activated')); ?></a></div>
                                        </div>
                                        <div class="price text-end">
                                            <small><?php echo e((SubscriptionDetails()['status'] == true) ? SubscriptionDetails()['billing_type'] : ''); ?></small>
                                            <h5><?php echo e((SubscriptionDetails()['status'] == true) ? SubscriptionDetails()['total_user'].' '.__('Users') : ''); ?></h5>
                                            <h5><?php echo e((SubscriptionDetails()['status'] == true) ? SubscriptionDetails()['total_workspace'].' '.__('Workspace') : ''); ?></h5>
                                            <span class="time-lbl text-muted"><?php echo e(((SubscriptionDetails()['status'] == true) && (SubscriptionDetails()['plan_expire_date'] != null)) ? __('Expired At ').SubscriptionDetails()['plan_expire_date'] : ''); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body package-card-inner  d-flex align-items-center">
                                    <div class="package-itm theme-avtar border border-secondary">
                                        <img src="<?php echo e((!empty(admin_setting('favicon')) && check_file(admin_setting('favicon'))) ? get_file(admin_setting('favicon')) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?'.time()); ?>" alt="">
                                    </div>
                                    <div class="package-content flex-grow-1  px-3">
                                        <h4><?php echo e(__('Basic Package')); ?></h4>
                                        <div class="text-muted"><a href="#add-on-list"><?php echo e(('+'.count($modules)+count($purchaseds).__(' Premium Add-on'))); ?></a></div>
                                    </div>
                                    <div class="price text-end">
                                        <ins class="plan-price-text"><?php echo e(super_currency_format_with_sym($planprice)); ?></ins>
                                        <span class="time-lbl text-muted plan-time-text"><?php echo e(__('/Month')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(count($modules) > 0): ?>
                        <h5 class="mb-1" id="add-on-list"><?php echo e(__('Modules')); ?></h5>
                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!isset($module->display) || $module->display == true): ?>
                                <div class="col-xxl-3 col-xl-4 col-lg-6 col-sm-6 product-card ">
                                    <div class="product-card-inner">
                                        <div class="card user_module">
                                            <div class="product-img">
                                                <div class="theme-avtar">
                                                    <img src="<?php echo e($module->image); ?>"
                                                        alt="<?php echo e($module->name); ?>" class="img-user"
                                                        style="max-width: 100%">
                                                </div>
                                                <div class="checkbox-custom">
                                                        <input type="checkbox" <?php echo e(((isset($session) && !empty($session) && ( in_array($module->name,explode(',',$session['user_module'])) ))) ? 'checked' :''); ?>

                                                            class="form-check-input pointer user_module_check"
                                                            data-module-img="<?php echo e($module->image); ?>"
                                                            data-module-price-monthly="<?php echo e(ModulePriceByName($module->name)['monthly_price']); ?>"
                                                            data-module-price-yearly="<?php echo e(ModulePriceByName($module->name)['yearly_price']); ?>"
                                                            data-module-alias="<?php echo e($module->alias); ?>"
                                                            value="<?php echo e($module->name); ?>">
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h4> <?php echo e($module->alias); ?></h4>
                                                <p class="text-muted text-sm mb-0">
                                                    <?php echo e($module->description ?? ''); ?>

                                                </p>
                                                <div class="price d-flex justify-content-between">
                                                    <ins class="m-price-monthly"><span class="currency-type"><?php echo e(super_currency_format_with_sym(ModulePriceByName($module->name)['monthly_price'])); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Month')); ?></span></ins>
                                                    <ins class="m-price-yearly d-none"><span class="currency-type"><?php echo e(super_currency_format_with_sym(ModulePriceByName($module->name)['yearly_price'])); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Year')); ?></span></ins>
                                                </div>
                                                <a href="<?php echo e(route('software.details',$module->alias)); ?>" target="_new" class="btn  btn-outline-secondary w-100 mt-2"><?php echo e(__('View Details')); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="col-lg-12 col-md-12">
                                <div class="card p-5">
                                    <div class="d-flex justify-content-center">
                                        <div class="ms-3 text-center">
                                            <h3><?php echo e(__('Add-on Not Available')); ?></h3>
                                            <p class="text-muted"><?php echo e(__('Click ')); ?><a
                                                    href="<?php echo e(url('/')); ?>"><?php echo e(__('here')); ?></a>
                                                <?php echo e(__('to back home')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                            <hr>
                        <?php if(!empty($purchaseds)): ?>
                        <h5 class="mb-3" id="activated-add-on"><?php echo e(__('Activated')); ?></h5>
                        <?php $__currentLoopData = $purchaseds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchased): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!isset($purchased->display) || $purchased->display == true): ?>
                            <div class="col-xxl-3 col-xl-4 col-lg-6 col-sm-6 product-card ">
                                <div class="card active_module">
                                    <div class="product-img">
                                        <div class="theme-avtar">
                                            <img src="<?php echo e($purchased->image); ?>"
                                                            alt="<?php echo e($purchased->name); ?>" class="img-user"
                                                            style="max-width: 100%">
                                        </div>
                                        <div class="checkbox-custom">
                                            <div class="action-btn">
                                                <?php echo e(Form::open(array('route'=>array('cancel.add.on',\Illuminate\Support\Facades\Crypt::encrypt($purchased->name)),'class' => 'm-0'))); ?>

                                                <?php echo method_field('GET'); ?>
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="<?php echo e(__('Cancel Add-on')); ?>"
                                                        aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('Cancel Add-on. Do you want to continue?')); ?>"  data-confirm-yes="delete-form-<?php echo e($purchased->name); ?>">
                                                        <i class="ti ti-x text-white text-white"></i>
                                                    </a>
                                                <?php echo e(Form::close()); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">

                                        <h4> <?php echo e($purchased->alias); ?></h4>
                                        <p class="text-muted text-sm mb-0">
                                            <?php echo e(isset($json['description']) ? $json['description'] : ''); ?>

                                        </p>
                                        <div class="price d-flex justify-content-between">
                                            <ins class="m-price-monthly"><span class="currency-type"><?php echo e(super_currency_format_with_sym($purchased->monthly_price)); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Month')); ?></span></ins>
                                            <ins class="m-price-yearly d-none"><span class="currency-type"><?php echo e(super_currency_format_with_sym($purchased->yearly_price)); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Year')); ?></span></ins>
                                        </div>
                                        <a href="<?php echo e(route('software.details',$purchased->alias)); ?>" target="_new" class="btn  btn-outline-secondary w-100 mt-2"><?php echo e(__('View Details')); ?></a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5">
                    <div class="card subscription-counter">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="mt-1"><?php echo e(__('Basic Package')); ?></h5>
                            <label class="switch ">
                                <span class="lbl time-monthly text-primary"><?php echo e(__('Monthly')); ?></span>
                                <input type="checkbox" <?php echo e(((isset($session) && !empty($session) && ($session['time_period'] == 'Year'))) ? 'checked' :''); ?> name="time-period" class="switch-change">
                                <span class="slider round"></span>
                                <span class="lbl time-yearly"><?php echo e(__('Yearly')); ?></span>
                            </label>
                        </div>
                        <div class="card-body">
                            <div class="subscription-summery">
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <span class="cart-sum-left"> <i class="ti ti-vector-bezier m-2 ti-20" ></i><?php echo e(__('Workspace ')); ?>:</span>
                                        <span class="cart-sum-right workspace_counter_text">0</span>
                                    </li>
                                    <li>
                                        <span class="cart-sum-left"> <i class="ti ti-users m-2 ti-20"></i><?php echo e(__('Users ')); ?>:</span>
                                        <span class="cart-sum-right user_counter_text">0</span>
                                    </li>

                                    <li class="pointer extension-trigger" data-bs-toggle="collapse" data-bs-target="#extension_div">
                                        <span class="cart-sum-left"><i class="ti ti-3d-cube-sphere m-2 ti-20"></i><?php echo e(__('Extension')); ?>:</span>
                                        <span class="cart-sum-right module_counter_text">0</span>
                                    </li>
                                    <div class="row align-items-center my-4 collapse" id="extension_div">
                                    </div>

                                </ul>

                                <div class="summery-footer">
                                    <div class="user-qty">
                                        <div class="lbl"> <?php echo e(__('Choose Workspace')); ?>:</div>
                                        <div class="qty-spinner">
                                            <button type="button" class="quantity-decrement" data-name = "workspace">
                                                <i class="ti ti-circle-minus m-2 ti-25"></i>
                                            </button>
                                            <input id="workspace_counter" type="number" data-cke-saved-name="quantity" name="quantity" class="quantity" step="1" value="0" min="0" max="1000" data-name = "workspace">
                                            <button type="button" class="quantity-increment " data-name = "workspace">
                                                <i class="ti ti-circle-plus m-2 ti-25"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="user-qty">
                                        <div class="lbl"> <?php echo e(__('Choose Users')); ?>:</div>
                                        <div class="qty-spinner">
                                            <button type="button" class="quantity-decrement" data-name = "user">
                                                <i class="ti ti-circle-minus m-2 ti-25"></i>
                                            </button>
                                            <input id="user_counter" type="number" data-cke-saved-name="quantity" name="quantity" class="quantity" step="1" value="0" min="0" max="1000" data-name = "user">
                                            <button type="button" class="quantity-increment " data-name = "user">
                                                <i class="ti ti-circle-plus m-2 ti-25"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <span class="cart-sum-left"><h6 class="mb-0"><?php echo e(__('Basic Package')); ?></h6></span>
                                            <span class="cart-sum-right"><b class="planpricetext "> <span class="final_price"><?php echo e(($planprice > 0 ) ? super_currency_format_with_sym($planprice) : 'Free'); ?></span></b></span>
                                        </li>
                                        <li>
                                            <span class="cart-sum-left"><h6 class="mb-0"><?php echo e(__('Workspace')); ?> <small
                                                class="text-muted workspace-price"><?php echo e('( ' . __('Per Workspace') . super_currency_format_with_sym($workspaceprice) . ' )'); ?></small></h6></span>
                                            <span class="cart-sum-right"><b class="workspacepricetext final_price"><?php echo e(super_currency_format_with_sym(0)); ?></b></span>
                                        </li>
                                        <li>
                                            <span class="cart-sum-left"><h6 class="mb-0"><?php echo e(__('Users')); ?> <small
                                                class="text-muted user-price"><?php echo e('( ' . __('Per User') . super_currency_format_with_sym($userprice) .' )'); ?></small></h6></span>
                                            <span class="cart-sum-right"><b class="userpricetext final_price"><?php echo e(super_currency_format_with_sym(0)); ?></b></span>
                                        </li>
                                        <li>
                                            <span class="cart-sum-left"><h6 class="mb-0"><?php echo e(__('Extension')); ?>:</h6></span>
                                            <span class="cart-sum-right"><b class="module_price_text final_price"><?php echo e(super_currency_format_with_sym(0)); ?></b></span>
                                        </li>
                                    </ul>
                                    <div class="row coupon_section">
                                        <div class="col-sm-12 col-lg-12 col-md-12">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group w-100">
                                                    <label for="coupon" class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="coupon" name="coupon" class="form-control coupon" placeholder="Enter Coupon Code">
                                                    <small class="text-danger"><?php echo e(__('Coupon apply only plan actual price. ')); ?></small>
                                                </div>
                                                <div class="form-group  ms-3 mt-2 apply-coupon">
                                                        <button type="button" class="btn  btn-primary"  data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Apply')); ?>" id="coupon-apply" ><i class="ti ti-square-check btn-apply "></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="cart-sum-left"><h6 class=""><?php echo e(__('Payment Method')); ?>:</h6></span>
                                    <div class="row">
                                        <?php if(admin_setting('bank_transfer_payment_is_on') == 'on' ): ?>
                                            <div class="col-sm-12 col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div class="">
                                                                    <label for="bank-payment">
                                                                        <h5 class="mb-0 pointer"><?php echo e(__('Bank Transfer')); ?></h5>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input payment_method" name="payment_method" id="bank-payment" type="radio" data-payment-action="<?php echo e(route('plan.pay.with.bank')); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <label
                                                                        class="form-label"><?php echo e(__('Bank Details :')); ?></label>
                                                                        <p class="">
                                                                            <?php echo admin_setting('bank_number'); ?>

                                                                        </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label class="form-label"><?php echo e(__('Payment Receipt')); ?></label>
                                                                    <div class="choose-files text-end">
                                                                    <label for="temp_receipt">
                                                                        <div class=" bg-primary "> <i class="ti ti-upload px-1"></i></div>
                                                                        <input type="file" class="form-control temp_receipt" accept="image/png, image/jpeg, image/jpg, .pdf" name="temp_receipt" id="temp_receipt" data-filename="temp_receipt" onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
                                                                    </label>
                                                                    <p class="text-danger error_msg d-none"><?php echo e(__('This field is required')); ?></p>

                                                                    <img class="mt-2" width="70px" src=""  id="blah3">
                                                                </div>
                                                                    <div class="invalid-feedback"><?php echo e(__('invalid form file')); ?></div>
                                                                </div>
                                                            </div>
                                                            <small class="text-danger"><?php echo e(__('first, make a payment and take a screenshot or download the receipt and upload it.')); ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php echo $__env->yieldPushContent('company_plan_payment'); ?>
                                    </div>
                                    <div class="cart-footer-total-row bg-primary text-white rounded p-3 d-flex align-items-center justify-content-between">
                                        <div class="mini-total-price">
                                            <div class="price">
                                                <h3 class="text-white mb-0 total"><?php echo e(super_currency_format_with_sym(0)); ?></h3>
                                                <span class="time-lbl plan-time-text"><?php echo e(__('/Month')); ?></span>
                                            </div>
                                        </div>
                                        <?php echo e(Form::open(array('','method'=>'post','id'=>'payment_form','enctype' => 'multipart/form-data'))); ?>

                                            <input type="hidden" name="workspaceprice_input" value="0" class="workspaceprice_input">
                                            <input type="hidden" name="workspace_counter_input" value="0" class="workspace_counter_input">
                                            <input type="hidden" name="user_counter_input" value="0" class="user_counter_input">
                                            <input type="hidden" name="user_module_input" value="" name="user_module_input"
                                                class="user_module_input">
                                            <input type="hidden" name="userprice_input" value="0" class="userprice_input">
                                            <input type="hidden" name="user_module_price_input" value="0" class="user_module_price_input">
                                            <input type="hidden" name="time_period" value="Month" class="time_period_input">
                                            <input type="hidden" name="workspace_module_price_input" value="0" class="workspace_module_price_input">
                                            <input type="hidden" name="plan_id" value="<?php echo e($plan->id); ?>" class="plan_id">
                                            <input type="hidden" name="coupon_code" value="" class="coupon_code">
                                            <div class="text-end form-btn">
                                            </div>
                                        <?php echo e(Form::close()); ?>

                                    </div>
                                    <div class="cart-reset text-center  mt-3">
                                        <a href="<?php echo e(route('module.reset')); ?>" class="reset-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                <path d="M6 0.625C3.036 0.625 0.625 3.0365 0.625 6C0.625 8.9635 3.036 11.375 6 11.375C8.964 11.375 11.375 8.9635 11.375 6C11.375 3.0365 8.964 0.625 6 0.625ZM6 10.625C3.4495 10.625 1.375 8.5505 1.375 6C1.375 3.4495 3.4495 1.375 6 1.375C8.5505 1.375 10.625 3.4495 10.625 6C10.625 8.5505 8.5505 10.625 6 10.625ZM7.765 4.76501L6.53 6L7.765 7.23499C7.9115 7.38149 7.9115 7.619 7.765 7.7655C7.692 7.8385 7.596 7.87549 7.5 7.87549C7.404 7.87549 7.308 7.839 7.235 7.7655L6 6.53049L4.765 7.7655C4.692 7.8385 4.596 7.87549 4.5 7.87549C4.404 7.87549 4.308 7.839 4.235 7.7655C4.0885 7.619 4.0885 7.38149 4.235 7.23499L5.47 6L4.235 4.76501C4.0885 4.61851 4.0885 4.381 4.235 4.2345C4.3815 4.088 4.619 4.088 4.7655 4.2345L6.0005 5.46951L7.2355 4.2345C7.382 4.088 7.61951 4.088 7.76601 4.2345C7.91151 4.381 7.9115 4.61901 7.765 4.76501Z" fill="#737373"></path>
                                            </svg><?php echo e(__('Reset')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {

            var userprice = '<?php echo e($userprice); ?>';
            var planprice = '<?php echo e($planprice); ?>';
            if(planprice  == 0){
                $(".coupon_section").addClass("d-none");
            }else{
                $(".coupon_section").removeClass("d-none");
            }
            if ($('.switch-change').prop('checked')==true)
            {
                userprice = '<?php echo e($userpriceyearly); ?>';
                planprice = '<?php echo e($planpriceyearly); ?>';
            }
            var user = parseInt($('.user_counter_input').val());
            var userpricetext = userprice * user;

            var currancy_symbol = '<?php echo e($currancy_symbol); ?>';
            var total = parseFloat(userpricetext) + parseFloat(planprice);
            $(".total").text(formatCurrency(total,'<?php echo e($currency_setting); ?>'));
        });
        $(document).on("click", ".user_module_check", function() {
            if ($(this).closest(".user_module").hasClass("active_module"))
            {
                $(this).closest(".user_module").removeClass("active_module");

            } else {
                $(this).closest(".user_module").addClass("active_module");
            }
            ChangeModulePrice();
            ChangePrice();

        });
        $(document).on("click","#coupon-apply",function() {
            ApplyCoupon()
        });
        function ApplyCoupon(type = null){
            var coupon = $('#coupon').val();
            var duration = $('.time_period_input').val();
            var plan_id = '<?php echo e($plan->id); ?>';
            if(coupon == ''){
                if(type == null)
                {
                    toastrs('Error', "<?php echo e(__('Coupon code required.')); ?>", 'error');
                }
            }else{
                $.ajax({
                    url: '<?php echo e(route('apply.coupon')); ?>',
                    type: 'GET',
                    data: {
                        "plan_id": plan_id,
                        "coupon": coupon,
                        "duration": duration,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data)
                    {
                        if (data != '' ) {
                            if (data.is_success == true) {
                                var currancy_symbol = '<?php echo e($currancy_symbol); ?>';
                                var finalPrice = data.final_price + currancy_symbol;
                                var originalPrice = data.final_price + currancy_symbol;

                                $('.planpricetext').html('<span class="original-price">' + formatCurrency(data.price,'<?php echo e($currency_setting); ?>')+ '</span> / ' + '<span class="final_price">'+finalPrice + '</span>');
                                // Apply text-decoration: line-through to the original price
                                $('.original-price').css("text-decoration", "line-through");
                                var final_price_input = parseFloat($('.after_coupon_final_price').val());
                                if (final_price_input) {
                                    $('.after_coupon_final_price').val(data.final_price);
                                }
                                else
                                {
                                    $('#payment_form').append('<input type="hidden" name="after_coupon_final_price" value="'+data.final_price+'" class="after_coupon_final_price">');
                                }
                                $('.coupon_code').val(coupon);
                                ChangePrice();
                                if(type == null)
                                {
                                    toastrs('success', data.message, 'success');
                                }
                            } else {
                                $('.coupon_code').val("");
                                if(type == null)
                                {
                                    toastrs('Error', data.message, 'error');
                                }
                            }

                        } else {
                            toastrs('Error', "<?php echo e(__('Coupon code required.')); ?>", 'error');
                        }
                    }
                });
            }
        }
    </script>
    <script>
         $(document).on('keyup mouseup', '#user_counter, #workspace_counter' , function() {
            var name = $(this).attr('data-name');
            var counter = parseInt($(this).val());
            if (counter <= 0 || counter > 1000 || $(this).val() == '')
            {
                $(this).val(0)
                var counter = 0;
            }
            if(name == "user")
            {
                $(".user_counter_text").text(counter);
                $(".user_counter_input").val(counter);
                ChangePrice(counter)
            }
            else if(name == "workspace")
            {
                $(".workspace_counter_text").text(counter);
                $(".workspace_counter_input").val(counter);
                ChangePrice(null,counter)
            }
        });
    </script>
    <script>
        function ChangePrice(user = null,workspace = null,user_module_price = 0) {
            var userprice = '<?php echo e($userprice); ?>';
            var workspaceprice = '<?php echo e($workspaceprice); ?>';
            var planprice = '<?php echo e($planprice); ?>';

            if ($('.switch-change').prop('checked')==true)
            {
                userprice = '<?php echo e($userpriceyearly); ?>';
                workspaceprice = '<?php echo e($workspacepriceyearly); ?>';
                planprice = '<?php echo e($planpriceyearly); ?>';

            }

            if (user == null) {
                var user = parseInt($('.user_counter_input').val());
            }
            if (user_module_price == 0) {
                var user_module_price = parseFloat($('.user_module_price_input').val());
            }
            if (workspace == null) {
                var  workspace= parseInt($('.workspace_counter_input').val());
            }

            var final_price = parseFloat($('.after_coupon_final_price').val());
            if (final_price) {
                planprice = final_price;
            }

            var userpricetext = userprice * user;
            var workspacepricetext = workspaceprice * workspace;

            var total = userpricetext + user_module_price + workspacepricetext + parseFloat(planprice);

            $(".total").text(formatCurrency(total,'<?php echo e($currency_setting); ?>'));

            $(".userpricetext").text(formatCurrency(userpricetext,'<?php echo e($currency_setting); ?>'));
            $(".workspacepricetext").text(formatCurrency(workspacepricetext,'<?php echo e($currency_setting); ?>'));
            $(".userprice_input").val(userpricetext);
            $(".workspaceprice_input").val(workspacepricetext);

        }
        function ChangeModulePrice() {
            var user_module_input = new Array();
            var user_module_price = parseFloat(0);
            var currancy_symbol = '<?php echo e($currancy_symbol); ?>';
            var n = jQuery(".user_module_check:checked").length;

            var time = '/Month';
            if ($('.switch-change').prop('checked')==true)
            {
                time = '/Year';
            }

            $("#extension_div").empty();

            if (n > 0) {
                jQuery(".user_module_check:checked").each(function() {

                    var alias = $(this).attr('data-module-alias');
                    var img = $(this).attr('data-module-img');
                    var price = parseFloat($(this).attr('data-module-price-monthly'));

                    if ($('.switch-change').prop('checked')==true)
                    {
                        price = parseFloat($(this).attr('data-module-price-yearly'));
                    }

                    $("#extension_div").append(`<div class="col-md-6 col-sm-6  my-2">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar">
                                            <img src="` + img + `" alt="` + img + `" class="img-user" style="max-width: 100%">
                                        </div>
                                        <div class="ms-2">
                                            <p class="text-muted text-sm mb-0">` + alias + `</p>
                                            <h4 class="mb-0 text-primary">` + formatCurrency(price,'<?php echo e($currency_setting); ?>') + `<span class="text-sm">`+time+`</span></h4>
                                        </div>
                                    </div>
                                </div>`);

                    user_module_input.push($(this).val());
                    user_module_price = user_module_price + price;
                });
            }
            $(".module_counter_text").text(n);
            $(".module_price_text").text(formatCurrency(user_module_price,'<?php echo e($currency_setting); ?>'));
            $(".user_module_input").val(user_module_input);
            $(".user_module_price_input").val(user_module_price);
        }
    /********* qty spinner ********/
    var quantity = 0;
    $('.quantity-increment').click(function()
    {
        var id = $(this).attr('data-name');
        var t = $(this).siblings('.quantity');
        var quantity = parseInt($(t).val());
        if(quantity < 1000 || $(this).val() != '')
        {
            $(t).val(quantity + 1);
            if(id == 'user')
            {
                $(".user_counter_text").text(quantity + 1);
                $(".user_counter_input").val(quantity + 1);
            }
            else if(id == 'workspace')
            {
                $(".workspace_counter_text").text(quantity + 1);
                $(".workspace_counter_input").val(quantity + 1);
            }
        }
        else
        {
            $(t).val(1000);
            if(id == 'user')
            {
                $(".user_counter_text").text(1000);
                $(".user_counter_input").val(1000);
            }
            else if(id == 'workspace')
            {
                $(".workspace_counter_text").text(1000);
                $(".workspace_counter_input").val(1000);
            }
        }

        ChangePrice()
    });
    $('.quantity-decrement').click(function()
    {
        var id = $(this).attr('data-name');
        var t = $(this).siblings('.quantity');
        var quantity = parseInt($(t).val());
        if(quantity > 1)
        {
            $(t).val(quantity - 1);
            if(id == 'user')
            {
                $(".user_counter_text").text(quantity - 1);
                $(".user_counter_input").val(quantity - 1);
            }
            else if(id == 'workspace')
            {
                $(".workspace_counter_text").text(quantity - 1);
                $(".workspace_counter_input").val(quantity - 1);
            }

        }
        else
        {
            $(t).val(0);
            if(id == 'user')
            {
                $(".user_counter_text").text(0);
                $(".user_counter_input").val(0);
            }
            else if(id == 'workspace')
            {
                $(".workspace_counter_text").text(0);
                $(".workspace_counter_input").val(0);
            }
        }
        ChangePrice()
    });
    </script>
    <script>
        $(document).on("click",".switch-change",function()
        {
            SwitchChange()
        });

        function SwitchChange()
        {
            var workspaceprice = '<?php echo e($workspaceprice); ?>';
            var userprice = '<?php echo e($userprice); ?>';
            var planprice = '<?php echo e($planprice); ?>';
            var currancy_symbol = '<?php echo e($currancy_symbol); ?>';
            var user = parseInt($('.user_counter_input').val());
            var workspace = parseInt($('.workspace_counter_input').val());
            var time = '/Month';


            if ($('.switch-change').prop('checked') == true)
            {

                $(".time-monthly").removeClass("text-primary");
                $(".time-yearly").addClass("text-primary");

                $(".m-price-yearly").removeClass("d-none");
                $(".m-price-monthly").addClass("d-none");

                userprice = '<?php echo e($userpriceyearly); ?>';
                workspaceprice = '<?php echo e($workspacepriceyearly); ?>';
                planprice = '<?php echo e($planpriceyearly); ?>';

                time = '/Year';

                $(".time_period_input").val('Year');

            }
            else
            {
                $(".time-yearly").removeClass("text-primary");
                $(".time-monthly").addClass("text-primary");

                $(".m-price-monthly").removeClass("d-none");
                $(".m-price-yearly").addClass("d-none");

                $(".time_period_input").val('Month');

            }

            var userpricetext = userprice * user;
            var workspacepricetext = workspaceprice * workspace;

            $(".plan-price-text").text(formatCurrency(planprice,'<?php echo e($currency_setting); ?>'));
            $(".plan-time-text").text(time);

            $(".planpricetext").html('<span class="final_price">'+ formatCurrency(planprice,'<?php echo e($currency_setting); ?>') + '</span>');
            $(".user-price").text('( <?php echo e(__("Per User")); ?> '+ formatCurrency(userprice,'<?php echo e($currency_setting); ?>')+')');
            $(".userpricetext").text(formatCurrency(userpricetext,'<?php echo e($currency_setting); ?>'));
            $(".workspace-price").text('( <?php echo e(__("Per Workspace" )); ?> '+ formatCurrency(workspaceprice,'<?php echo e($currency_setting); ?>')+')');
            $(".workspacepricetext").text(formatCurrency(workspacepricetext,'<?php echo e($currency_setting); ?>'));

            if(planprice  == 0){
                $(".coupon_section").addClass("d-none");
            }else{
                $(".coupon_section").removeClass("d-none");
            }
            ApplyCoupon('switch')
            ChangeModulePrice()
            ChangePrice()
        }
    </script>
    <script>
        $(document).ready(function () {
            var numItems = $('.payment_method').length
            if(numItems > 0)
            {
                $('.form-btn').append('<button type="submit" class="btn btn-dark payment-btn" ><?php echo e(__("Buy Now")); ?></button>');
                setTimeout(() => {
                    $(".payment_method").first().attr('checked', true);
                    $(".payment_method").first().trigger('click');
                }, 200);
            }
            else
            {
                $('.form-btn').append("<span class='text-danger'><?php echo e(__('Admin payment settings not set')); ?></span>");
            }
        });
        $( "#payment_form" ).on( "submit", function( event ) {
            "<?php echo e(session()->put('Subscription','custom_subscription')); ?>";
        });
        $(document).on("click",".payment_method",function() {
            var payment_action = $(this).attr("data-payment-action");
            if(payment_action != '' && payment_action != undefined)
            {
                $("#payment_form").attr("action",payment_action);
            }
            else
            {
                $("#payment_form").attr("action",'');
            }
            if ($('#bank-payment').prop('checked'))
            {
                $(".temp_receipt").attr("required", "required");
            }
            else
            {
                $(".temp_receipt").removeAttr("required");
            }
        });
    </script>
    
    <?php if(isset($session) && !empty($session)): ?>
    <script>
        $(document).ready(function () {
            $('#user_counter').val("<?php echo e($session['user_counter']); ?>");
            $('#user_counter').trigger('keyup')
            $('#workspace_counter').val("<?php echo e($session['workspace_counter']); ?>");
            $('#workspace_counter').trigger('keyup')
            SwitchChange();
        });
    </script>
    <?php endif; ?>
<?php if(admin_setting('bank_transfer_payment_is_on') == 'on'): ?>
<script>

    $('#payment_form').submit(function(e)
    {
        if ($('#bank-payment').prop('checked'))
        {
            e.preventDefault(); // Prevent form submission


            var file = document.getElementById('temp_receipt').files[0];

            if(file != undefined)
            {
                $('.error_msg').addClass('d-none');

                // Create a new FormData object
                const formData = new FormData();

                // Add file data from the file input element
                const file = $('#temp_receipt')[0].files[0];
                formData.append('payment_receipt', file, file.name);

                // Add data from the form's input elements
                $('#payment_form input').each(function() {
                formData.append(this.name, this.value);
                });

                var url = $('#payment_form').attr('action');


                $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status == 'success')
                    {
                        toastrs('Success', response.msg, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    else
                    {
                        toastrs('Error', response.msg, 'error');
                    }
                    // Handle success response
                },
                error: function(xhr, status, error) {
                    toastrs('Error',error, 'error');
                    // Handle error response
                }
                });

            }
            else
            {
                $('.error_msg').removeClass('d-none');
            }
        }
    });

</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\plans\marketplace.blade.php ENDPATH**/ ?>
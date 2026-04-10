<?php
    $userprice = !empty($plan) ? $plan->price_per_user_monthly : 0;
    $userpriceyearly = !empty($plan) ? $plan->price_per_user_yearly : 0;

    $workspaceprice = !empty($plan) ? $plan->price_per_workspace_monthly : 0;
    $workspacepriceyearly = !empty($plan) ? $plan->price_per_workspace_yearly : 0;

    $planprice = !empty($plan) ? $plan->package_price_monthly : 0;
    $planpriceyearly = !empty($plan) ? $plan->package_price_yearly : 0;
    $currancy_symbol = admin_setting('defult_currancy_symbol');
    $subscriptionDetail = SubscriptionDetails($user->id);
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
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-8 col-xl-7">
                    <div class="row">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subscriptionDetail['status'] == true): ?>
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
                                            <small><?php echo e(($subscriptionDetail['status'] == true) ? $subscriptionDetail['billing_type'] : ''); ?></small>
                                            <h5><?php echo e(($subscriptionDetail['status'] == true) ? $subscriptionDetail['total_user'].' '.__('Users') : ''); ?></h5>
                                            <h5><?php echo e(($subscriptionDetail['status'] == true) ? $subscriptionDetail['total_workspace'].' '.__('Workspace') : ''); ?></h5>
                                            <span class="time-lbl text-muted"><?php echo e((($subscriptionDetail['status'] == true) && ($subscriptionDetail['plan_expire_date'] != null)) ? __('Expired At ').$subscriptionDetail['plan_expire_date'] : ''); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body package-card-inner  d-flex align-items-center">
                                    <div class="package-itm theme-avtar border border-secondary">
                                        <img src="<?php echo e((!empty(admin_setting('favicon')) && check_file(admin_setting('favicon'))) ? get_file(admin_setting('favicon')) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?'.time()); ?>" alt="">
                                    </div>
                                    <div class="package-content flex-grow-1  px-3">
                                        <h4><?php echo e(__('Basic Package')); ?></h4>
                                        <div class="text-muted"><a href="#add-on-list"><?php echo e(__('+'.count($modules)+count($purchaseds).' Premium Add-on')); ?></a></div>
                                    </div>
                                    <div class="price text-end">
                                        <ins class="plan-price-text"><?php echo e(super_currency_format_with_sym($planprice)); ?></ins>
                                        <span class="time-lbl text-muted plan-time-text"><?php echo e(__('/Month')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($modules) > 0): ?>
                            <div class="d-flex justify-content-between bd-highlight">
                                <h5 class="mb-1" id="add-on-list"><?php echo e(__('Modules')); ?></h5>
                                <h5>
                                    <label for="check-all-module" class="form-check-label pointer mx-2"><?php echo e(__('Select All Add-on')); ?></label>
                                    <input type="checkbox" id="check-all-module" class="form-check-input pointer">
                                </h5>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!isset($module->display) || $module->display == true): ?>
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
                                                        data-module-price-monthly="<?php echo e($module->monthly_price); ?>"
                                                        data-module-price-yearly="<?php echo e($module->yearly_price); ?>"
                                                        data-module-alias="<?php echo e($module->alias); ?>"
                                                        value="<?php echo e($module->name); ?>">
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h4> <?php echo e($module->alias); ?></h4>
                                                <p class="text-muted text-sm mb-0">
                                                    <?php echo e(isset($module->description) ? $module->description : ''); ?>

                                                </p>
                                                <div class="price d-flex justify-content-between">
                                                    <ins class="m-price-monthly"><span class="currency-type"><?php echo e(super_currency_format_with_sym($module->monthly_price)); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Month')); ?></span></ins>
                                                    <ins class="m-price-yearly d-none"><span class="currency-type"><?php echo e(super_currency_format_with_sym($module->yearly_price)); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Year')); ?></span></ins>
                                                </div>
                                                <a href="<?php echo e(route('software.details',$module->alias)); ?>" target="_new" class="btn  btn-outline-secondary w-100 mt-2"><?php echo e(__('View Details')); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <hr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($purchaseds)): ?>
                        <h5 class="mb-3" id="activated-add-on"><?php echo e(__('Activated')); ?></h5>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $purchaseds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchased): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!isset($purchased->display) || $purchased->display == true): ?>
                            <div class="col-xxl-3 col-xl-4 col-lg-6 col-sm-6 product-card ">
                                <div class="card active_module">
                                    <div class="product-img">
                                        <div class="theme-avtar">
                                            <img src="<?php echo e($purchased->image); ?>"
                                                            alt="<?php echo e($purchased->name); ?>" class="img-user"
                                                            style="max-width: 100%">
                                        </div>
                                        <div class="checkbox-custom">
                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo e(Form::open(array('route'=>array('cancel.add.on',[\Illuminate\Support\Facades\Crypt::encrypt($purchased->name),$user->id]),'class' => 'm-0'))); ?>

                                                <?php echo method_field('GET'); ?>
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
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
                                            <?php echo e(isset($purchased->description) ? $purchased->description : ''); ?>

                                        </p>
                                        <div class="price d-flex justify-content-between">
                                            <ins class="m-price-monthly"><span class="currency-type"><?php echo e(super_currency_format_with_sym($purchased->monthly_price)); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Month')); ?></span></ins>
                                            <ins class="m-price-yearly d-none"><span class="currency-type"><?php echo e(super_currency_format_with_sym($purchased->yearly_price)); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Year')); ?></span></ins>
                                        </div>
                                        <a href="<?php echo e(route('software.details',$purchased->alias)); ?>" target="_new" class="btn  btn-outline-secondary w-100 mt-2"><?php echo e(__('View Details')); ?></a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5">
                    <div class="card subscription-counter">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="mt-1"><?php echo e(__('Basic Package')); ?></h5>
                            <label class="switch ">
                                <span class="lbl time-monthly text-primary"><?php echo e(__('Monthly')); ?></span>
                                <input type="checkbox" name="time-period" class="switch-change">
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
                                                class="text-muted workspace-price"><?php echo e('( ' . __('Per Workspace') .  super_currency_format_with_sym($workspaceprice)  . ' )'); ?></small></h6></span>
                                            <span class="cart-sum-right"><b class="workspacepricetext final_price"><?php echo e(super_currency_format_with_sym(0)); ?></b></span>
                                        </li>
                                        <li>
                                            <span class="cart-sum-left"><h6 class="mb-0"><?php echo e(__('Users')); ?> <small
                                                class="text-muted user-price"><?php echo e('( '. __('Per User') . super_currency_format_with_sym($userprice) . ' )'); ?></small></h6></span>
                                            <span class="cart-sum-right"><b class="userpricetext final_price"><?php echo e(super_currency_format_with_sym(0)); ?></b></span>
                                        </li>
                                        <li>
                                            <span class="cart-sum-left"><h6 class="mb-0"><?php echo e(__('Extension')); ?>:</h6></span>
                                            <span class="cart-sum-right"><b class="module_price_text final_price"><?php echo e(super_currency_format_with_sym(0)); ?></b></span>
                                        </li>
                                    </ul>

                                    <div class="cart-footer-total-row bg-primary text-white rounded p-3 d-flex align-items-center justify-content-between">
                                        <div class="mini-total-price">
                                            <div class="price">
                                                <h3 class="text-white mb-0 total"><?php echo e(super_currency_format_with_sym(0)); ?></h3>
                                                <span class="time-lbl plan-time-text"><?php echo e(__('/Month')); ?></span>
                                            </div>
                                        </div>
                                        <?php echo e(Form::open(array('route'=>['assign.plan.user',[Crypt::encrypt($plan->id),Crypt::encrypt($user->id)]],'method'=>'POST'))); ?>

                                            <input type="hidden" name="workspaceprice_input" value="0" class="workspaceprice_input">
                                            <input type="hidden" name="workspace_counter_input" value="0" class="workspace_counter_input">
                                            <input type="hidden" name="user_counter_input" value="0" class="user_counter_input">
                                            <input type="hidden" name="user_module_input" value="" name="user_module_input"
                                                class="user_module_input">
                                            <input type="hidden" name="userprice_input" value="0" class="userprice_input">
                                            <input type="hidden" name="user_module_price_input" value="0" class="user_module_price_input">
                                            <input type="hidden" name="time_period" value="Month" class="time_period_input">
                                            <input type="hidden" name="workspace_module_price_input" value="0" class="workspace_module_price_input">
                                            <input type="hidden" name="coupon_code" value="" class="coupon_code">

                                            <div class="text-end form-btn">
                                                <button type="submit" class="btn btn-dark payment-btn"  ><?php echo e(__("Assign Now")); ?></button>
                                            </div>
                                        <?php echo e(Form::close()); ?>

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
        $(document).on("click", "#check-all-module", function() {
            if ($('#check-all-module').prop('checked')==true)
            {
                $('.user_module_check').prop('checked',true);
            }
            else
            {
                $('.user_module_check').prop('checked',false);
            }
            ChangeModulePrice();
            ChangePrice();
        });

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
        function ChangePrice(user = null,workspace = null,user_module_price = 0 ) {
            var userprice = '<?php echo e($userprice); ?>';
            var workspaceprice = '<?php echo e($workspaceprice); ?>';
            var planprice = '<?php echo e($planprice); ?>';

            if ($('.switch-change').prop('checked')==true)
            {
                userprice = '<?php echo e($userpriceyearly); ?>';
                workspaceprice = '<?php echo e($workspacepriceyearly); ?>';
                planprice = '<?php echo e($planpriceyearly); ?>';

            }

            var currancy_symbol = '<?php echo e($currancy_symbol); ?>';
            if (user == null) {
                var user = parseInt($('.user_counter_input').val());
            }
            if (user_module_price == 0) {
                var user_module_price = parseFloat($('.user_module_price_input').val());
            }
            if (workspace == null) {
                var  workspace= parseInt($('.workspace_counter_input').val());
            }

            var userpricetext = userprice * user;
            var workspacepricetext = workspaceprice * workspace;

            var total = userpricetext + user_module_price + workspacepricetext + parseFloat(planprice);

            $(".total").text(formatCurrency(total,'<?php echo e($currency_setting); ?>'));

            $(".userpricetext").text(formatCurrency(userpricetext,'<?php echo e($currency_setting); ?>'));
            $(".workspacepricetext").text(formatCurrency(workspacepricetext,'<?php echo e($currency_setting); ?>'));
            $(".userprice_input").val(formatCurrency(userpricetext,'<?php echo e($currency_setting); ?>'));
            $(".workspaceprice_input").val(formatCurrency(workspacepricetext,'<?php echo e($currency_setting); ?>'));

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

            $(".planpricetext").html('<span class="final_price">'+ formatCurrency(planprice,'<?php echo e($currency_setting); ?>')  + '</span>');
            $(".user-price").text('( <?php echo e(__("Per User")); ?>'+ formatCurrency(userprice,'<?php echo e($currency_setting); ?>') +')');
            $(".userpricetext").text(formatCurrency(userpricetext,'<?php echo e($currency_setting); ?>'));
            $(".workspace-price").text('( <?php echo e(__("Per Workspace")); ?> '+ formatCurrency(workspaceprice,'<?php echo e($currency_setting); ?>') +')');
            $(".workspacepricetext").text(formatCurrency(workspacepricetext,'<?php echo e($currency_setting); ?>'));

            if(planprice  == 0){
                $(".coupon_section").addClass("d-none");
            }else{
                $(".coupon_section").removeClass("d-none");
            }
            ChangeModulePrice()
            ChangePrice()
        }
    </script>
    <script>

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
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($session) && !empty($session)): ?>
    <script>
        $(document).ready(function () {
            $('#user_counter').val("<?php echo e($session['user_counter']); ?>");
            $('#user_counter').trigger('keyup')
            $('#workspace_counter').val("<?php echo e($session['workspace_counter']); ?>");
            $('#workspace_counter').trigger('keyup')
            SwitchChange();
        });
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(admin_setting('bank_transfer_payment_is_on') == 'on'): ?>
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
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/users/modules.blade.php ENDPATH**/ ?>
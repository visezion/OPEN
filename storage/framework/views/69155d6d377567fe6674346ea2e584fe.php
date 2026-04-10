<?php
    $planprice = !empty($plan) ? $plan->package_price_monthly : 0;
    $planpriceyearly = !empty($plan) ? $plan->package_price_yearly : 0;
    $currancy_symbol = admin_setting('defult_currancy_symbol');
    $plan_modules = explode(',',$plan->modules);

    $currency_setting = json_encode(Arr::only(getAdminAllSetting(), ['site_currency_symbol_position','currency_format','currency_space','site_currency_symbol_name','defult_currancy_symbol','defult_currancy','float_number','decimal_separator','thousand_separator']));
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plan Assign')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Plan Assign')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-8 col-xl-7">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body package-card-inner  d-flex align-items-center">
                                    <div class="package-itm theme-avtar border border-secondary">
                                        <img src="<?php echo e((!empty(admin_setting('favicon')) && check_file(admin_setting('favicon'))) ? get_file(admin_setting('favicon')) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?'.time()); ?>" alt="">
                                    </div>
                                    <div class="package-content flex-grow-1  px-3">
                                        <h4><?php echo e($plan->name); ?></h4>
                                        <div class="text-muted"> <a href="#activated-add-on"><?php echo e(__(count($plan_modules).' Premium Add-on')); ?></a></div>
                                    </div>
                                    <div class="price text-end">
                                        <ins class="plan-price-text"><?php echo e(super_currency_format_with_sym($planprice)); ?></ins>
                                        <span class="time-lbl text-muted plan-time-text"><?php echo e(__('/Month')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((count($plan_modules) > 0) && ( count($modules) > 0)): ?>
                        <h5 class="mb-1" id="add-on-list"><?php echo e(__('Modules')); ?></h5>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($module->name,$plan_modules)): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!isset($module->display) || $module->display == true): ?>
                                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-sm-6 product-card ">
                                            <div class="product-card-inner">
                                                <div class="card active_module">
                                                    <div class="product-img">
                                                        <div class="theme-avtar">
                                                            <img src="<?php echo e($module->image); ?>"
                                                                alt="<?php echo e($module->name); ?>" class="img-user"
                                                                style="max-width: 100%">
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        <h4> <?php echo e($module->alias); ?></h4>
                                                        <p class="text-muted text-sm mb-0">
                                                            <?php echo e(isset($module->description) ? $module->description : ''); ?>

                                                        </p>
                                                        <a href="<?php echo e(route('software.details',$module->alias)); ?>" target="_new" class="btn  btn-outline-secondary w-100 mt-2"><?php echo e(__('View Details')); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5">
                    <div class="card subscription-counter">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="mt-1"><?php echo e($plan->name); ?></h5>
                            <label class="switch ">
                                <span class="lbl time-monthly text-primary"><?php echo e(__('Monthly')); ?></span>
                                <input type="checkbox" name="time-period" class="switch-change">
                                <span class="slider round"></span>
                                <span class="lbl time-yearly"><?php echo e(__('Yearly')); ?></span>
                            </label>
                        </div>
                        <div class="card-body">
                            <div class="subscription-summery">
                                <div class="">
                                    <span class="cart-sum-left"><h6 class=""><?php echo e(__('Payment Method')); ?>:</h6></span>
                                    <div class="cart-footer-total-row bg-primary text-white rounded p-3 d-flex align-items-center justify-content-between">
                                        <div class="mini-total-price">
                                            <div class="price">
                                                <h3 class="text-white mb-0 total"><?php echo e(super_currency_format_with_sym($plan->package_price_monthly)); ?></h3>
                                                <span class="time-lbl plan-time-text"><?php echo e(__('/Month')); ?></span>
                                            </div>
                                        </div>

                                        <?php echo e(Form::open(array('route'=>['assign.plan.user',[Crypt::encrypt($plan->id),Crypt::encrypt($user->id)]],'method'=>'post'))); ?>

                                            <input type="hidden" name="time_period" value="Month" class="time_period_input">
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
        $(document).on("click",".switch-change",function()
        {
            SwitchChange()
        });

        function SwitchChange()
        {
            var planprice = '<?php echo e($planprice); ?>';
            var currancy_symbol = '<?php echo e($currancy_symbol); ?>';
            var user = parseInt($('.user_counter_input').val());
            var time = '/Month';


            if ($('.switch-change').prop('checked') == true)
            {

                $(".time-monthly").removeClass("text-primary");
                $(".time-yearly").addClass("text-primary");

                $(".m-price-yearly").removeClass("d-none");
                $(".m-price-monthly").addClass("d-none");

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

            $(".plan-price-text").text(formatCurrency(planprice,'<?php echo e($currency_setting); ?>'));
            $(".plan-time-text").text(time);

            ChangeModulePrice()
            ChangePrice()
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
                                            <p class="text-muted text-sm mb-0 text-capitalize">` + alias + `</p>
                                            <h4 class="mb-0 text-primary">` + formatCurrency(price,'<?php echo e($currency_setting); ?>') + `<span class="text-sm">`+time+`</span></h4>
                                        </div>
                                    </div>
                                </div>`);

                    user_module_input.push($(this).val());
                    user_module_price = user_module_price + price;
                });
            }
            $(".module_counter_text").text(n);
            $(".module_price_text").text(parseFloat(user_module_price).toFixed(2) + currancy_symbol);
            // $(".user_module_input").val(user_module_input);
            $(".user_module_price_input").val(user_module_price);
        }

        function ChangePrice(user = null, user_module_price = 0)
        {
            var planprice = '<?php echo e(super_currency_format_with_sym($planprice)); ?>';
            if ($('.switch-change').prop('checked')==true)
            {
                planprice = '<?php echo e(super_currency_format_with_sym($planpriceyearly)); ?>';
            }

            var currancy_symbol = '<?php echo e($currancy_symbol); ?>';
            if (user == null) {
                var user = parseInt($('.user_counter_input').val());
            }
            if (user_module_price == 0) {
                var user_module_price = parseFloat($('.user_module_price_input').val());
            }

            $(".total").text(planprice);

        }
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/users/plan-detail.blade.php ENDPATH**/ ?>
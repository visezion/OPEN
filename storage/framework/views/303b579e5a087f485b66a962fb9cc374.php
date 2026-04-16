<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Referral Program')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Referral Program')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script>
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')

        });

        $('.tab-link').on('click', function() {
            var tabId = $(this).data('tab');
            $('.tabcontent').addClass('d-none');
            $('#' + tabId).removeClass('d-none');

            $('.tab-link').removeClass('active');
            $(this).addClass('active');
        });
    </script>
<?php $__env->stopPush(); ?>
<?php
    $companyName = $company_settings['company_name'] ?? \Auth::user()->name;
?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#" class="list-group-item list-group-item-action border-0 tab-link active"
                                data-tab="guideline"><?php echo e(__('GuideLine')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 tab-link"
                                data-tab="referral-transaction"><?php echo e(__('Referral Transaction')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 tab-link"
                                data-tab="payout"><?php echo e(__('Payout')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    

                    <!--Site Settings-->
                    <div id="guideline" class="card tabcontent">
                        <div class="card-header">
                            <h5><?php echo e(__('GuideLine')); ?></h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-md-6 ">
                                    <div class = "border border-2 p-3">
                                        <h4><?php echo e(__('Refer ') . $companyName .  __(' and earn ') . (isset($setting) ? $setting->percentage . '%' : '') . __(' per paid signup!')); ?></h4>
                                        <?php echo isset($setting) ? $setting->guideline : ''; ?>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 mt-5">
                                    <h4 class="text-center"><?php echo e(__('Share Your Link')); ?></h4>
                                    <div class="d-flex justify-content-between">
                                        <a href="#!" class="btn btn-sm btn-light-primary w-100 cp_link"
                                            data-link="<?php echo e(route('register', ['ref_id' => \Auth::user()->referral_code])); ?>"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                            data-bs-original-title="Click to copy business link">
                                            <?php echo e(route('register', ['ref' => \Auth::user()->referral_code])); ?>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-copy ms-1">
                                                <rect x="9" y="9" width="13" height="13" rx="2"
                                                    ry="2"></rect>
                                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($setting) && $setting->is_enable == 0 || !isset($setting)): ?>
                                        <h6 class="text-end text-danger text-md mt-2"><?php echo e(__('Note : super admin has disabled the referral program.')); ?></h6>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div id="referral-transaction" class="card tabcontent d-none">
                        <div class="card-header">
                            <h5><?php echo e(__('Referral Transaction')); ?></h5>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('Company Name')); ?></th>
                                            <th><?php echo e(__('Plan Name')); ?></th>
                                            <th><?php echo e(__('Plan Price')); ?></th>
                                            <th><?php echo e(__('Commission (%)')); ?></th>
                                            <th><?php echo e(__('Commission Amount')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e(++$key); ?> </td>
                                                <td><?php echo e(!empty($transaction->company_id) ? $transaction->user_name : '-'); ?>

                                                </td>
                                                <td><?php echo e(!empty($transaction->plan_name) ? $transaction->plan_name : 'Basic Package'); ?>

                                                </td>
                                                <td><?php echo e(super_currency_format_with_sym($transaction->plan_price)); ?></td>
                                                <td><?php echo e($transaction->commission); ?></td>
                                                <td><?php echo e(super_currency_format_with_sym(($transaction->plan_price * $transaction->commission) / 100)); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="payout" class="tabcontent d-none">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class=""><?php echo e(__('PayOut')); ?></h5>
                                    </div>
                                    <div class="col-6 text-end">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->commission_amount > $paidAmount): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentRequest == null): ?>
                                                <a href="#"
                                                    data-url = "<?php echo e(route('request.amount.sent', [\Illuminate\Support\Facades\Crypt::encrypt(\Auth::user()->id)])); ?>"
                                                    data-ajax-popup="true" class="btn btn-primary btn-sm"
                                                    data-title="<?php echo e(__('Send Request')); ?>" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Send Request')); ?>">
                                                    <span class="btn-inner--icon"><i
                                                            class="ti ti-corner-up-right"></i></span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('request.amount.cancel', \Auth::user()->id)); ?>"
                                                    class="btn btn-danger btn-sm" data-title="<?php echo e(__('Cancel Request')); ?>"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Cancel Request')); ?>">
                                                    <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center justify-content-between">

                                    <div class="col-lg-6 col-md-12">
                                        <div class="border border-2 p-3">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="theme-avtar badge bg-primary">
                                                            <i class="ti ti-report-money"></i>
                                                        </div>
                                                        <div class="ms-3">
                                                            <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                                            <h6 class="m-0"><?php echo e(__('Commission Amount')); ?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto text-end">
                                                    <h4 class="m-0"><?php echo e(super_currency_format_with_sym(\Auth::user()->commission_amount)); ?>

                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="border border-2 p-3">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="theme-avtar badge bg-primary">
                                                            <i class="ti ti-report-money"></i>
                                                        </div>
                                                        <div class="ms-3">
                                                            <small class="text-muted"><?php echo e(__('Paid')); ?></small>
                                                            <h6 class="m-0"><?php echo e(__('Paid Amount')); ?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto text-end">
                                                    <h4 class="m-0"><?php echo e(super_currency_format_with_sym($paidAmount)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class=""><?php echo e(__('Payout History')); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo e(__('Company Name')); ?></th>
                                                <th><?php echo e(__('Requested Date')); ?></th>
                                                <th><?php echo e(__('Status')); ?></th>
                                                <th><?php echo e(__('Requested Amount')); ?></th>
                                                <th><?php echo e(__('Coupon Code')); ?></th>
                                                <th><?php echo e(__('Coupon Status')); ?></th>
                                                <th><?php echo e(__('Coupon Expiry Date')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $transactionsOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(++$key); ?></td>
                                                    <td><?php echo e(\Auth::user()->name); ?></td>
                                                    <td><?php echo e($transaction->date); ?></td>
                                                    <td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->status == 0): ?>
                                                            <span
                                                                class="status_badge badge bg-danger p-2 px-3"><?php echo e(__(\App\Models\TransactionOrder::$status[$transaction->status])); ?></span>
                                                        <?php elseif($transaction->status == 1): ?>
                                                            <span
                                                                class="status_badge badge bg-warning p-2 px-3"><?php echo e(__(\App\Models\TransactionOrder::$status[$transaction->status])); ?></span>
                                                        <?php elseif($transaction->status == 2): ?>
                                                            <span
                                                                class="status_badge badge bg-primary p-2 px-3"><?php echo e(__(\App\Models\TransactionOrder::$status[$transaction->status])); ?></span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(super_currency_format_with_sym($transaction->req_amount)); ?></td>
                                                    <td><?php echo e($transaction->coupon_code ?? '-'); ?></td>
                                                    <td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($coupon) && $coupon->limit == $usedCoupun): ?>
                                                            <span class="p-2 px-3 status_badge badge bg-primary"><?php echo e(__('Used')); ?></span>
                                                        <?php elseif(!empty($coupon)): ?>
                                                            <span class="p-2 px-3 status_badge badge bg-danger"><?php echo e(__('Not Used')); ?></span>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(!empty($transaction->expiry_date) ? company_date_formate($transaction->expiry_date):'-'); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\referral-program\company.blade.php ENDPATH**/ ?>
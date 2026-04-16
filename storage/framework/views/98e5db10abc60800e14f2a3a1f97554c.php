<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Referral Program')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Referral Program')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>

    <script>
        summernote();

        $('.tab-link').on('click', function () {
        var tabId = $(this).data('tab');
        $('.tabcontent').addClass('d-none');
        $('#' + tabId).removeClass('d-none');

        $('.tab-link').removeClass('active');
        $(this).addClass('active');
    });

    </script>

<script type="text/javascript">
    $(document).on('click', '#is_enable', function() {
        if ($('#is_enable').prop('checked')) {
            $('.referralDiv').removeClass('disabledCookie');
        } else {
            $('.referralDiv').addClass('disabledCookie');
        }
    });
</script>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#transaction"
                                class="list-group-item list-group-item-action border-0 tab-link active" data-tab="transaction"><?php echo e(__('Transaction')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#payout-request"
                                class="list-group-item list-group-item-action border-0 tab-link" data-tab="payout-request"><?php echo e(__('Payout Request')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#settings" class="list-group-item list-group-item-action border-0 tab-link" data-tab="settings"><?php echo e(__('Settings')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    

                    <!--Site Settings-->
                    <div id="transaction" class="card tabcontent">
                        <div class="card-header">
                            <h5><?php echo e(__('Transaction')); ?></h5>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table pc-dt-simple" id="transaction">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('Company Name')); ?></th>
                                            <th><?php echo e(__('Referral Company Name')); ?></th>
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
                                                <td><?php echo e(!empty($transaction->referral_code) ? $transaction->company_name : '-'); ?>

                                                </td>
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

                    <div id="payout-request" class="card tabcontent d-none">
                        <div class="card-header">
                            <h5><?php echo e(__('Payout Request')); ?></h5>
                        </div>
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table pc-dt-simple" id="payout-request">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo e(__('Company Name')); ?></th>
                                                <th><?php echo e(__('Requested Date')); ?></th>
                                                <th><?php echo e(__('Requested Amount')); ?></th>
                                                <th><?php echo e(__('Action')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $payRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td> <?php echo e(( ++ $key)); ?> </td>
                                                    <td><?php echo e(!empty( $transaction->req_user_id) ? $transaction->company_name : '-'); ?></td>
                                                    <td><?php echo e($transaction->date); ?></td>
                                                    <td><?php echo e(super_currency_format_with_sym($transaction->req_amount)); ?></td>
                                                    <td>
                                                        <a href="<?php echo e(route('amount.request',[$transaction->id,1])); ?>" class="btn btn-success btn-sm me-2">
                                                            <i class="ti ti-check"></i>
                                                        </a>
                                                        <a href="<?php echo e(route('amount.request',[$transaction->id,0])); ?>" class="btn btn-danger btn-sm">
                                                        <i class="ti ti-x"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <div id="settings" class="card tabcontent d-none">
                        <?php echo e(Form::open(['route' => 'referral-program.store', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="card-header flex-column flex-lg-row d-flex align-items-lg-center gap-2 justify-content-between">
                            <h5><?php echo e(__('Settings')); ?></h5>
                            <div class="form-check form-switch custom-switch-v1" >
                                <input type="checkbox" name="is_enable" class="form-check-input input-primary"
                                       id="is_enable" <?php echo e(isset($setting) && $setting->is_enable == '1' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_enable"><?php echo e(__('Enable')); ?></label>
                            </div>
                        </div>
                        <div class="card-body referralDiv <?php echo e(isset($setting) && $setting->is_enable == '0' ? 'disabledCookie ' : ''); ?>">
                            <div class="row">
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('percentage', __('Commission Percentage (%)'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('percentage', isset($setting) ? $setting->percentage : '', ['class' => 'form-control', 'placeholder' => __('Enter Commission Percentage')])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('minimum_threshold_amount', __('Minimum Threshold Amount'), ['class' => 'form-label'])); ?>

                                            <div class="input-group">
                                                <span class="input-group-prepend"><span
                                                    class="input-group-text"><?php echo e(admin_setting('defult_currancy_symbol')); ?></span></span>
                                            <?php echo e(Form::number('minimum_threshold_amount', isset($setting) ? $setting->minimum_threshold_amount : '', ['class' => 'form-control', 'placeholder' => __('Enter Minimum Payout')])); ?>

                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <?php echo e(Form::label('guideline', __('GuideLines'), ['class' => 'form-label text-dark'])); ?>

                                        <textarea name="guideline" id="guideline" class="summernote form-control"><?php echo e(isset($setting) ? $setting->guideline : ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn-submit btn btn-primary" type="submit">
                                <?php echo e(__('Save Changes')); ?>

                            </button>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>



                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\referral-program\index.blade.php ENDPATH**/ ?>
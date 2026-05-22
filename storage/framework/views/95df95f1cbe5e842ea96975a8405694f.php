<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Account Statement Summary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Report')); ?>,
    <?php echo e(__('Account Statement Summary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('packages/workdo/Account/src/Resources/assets/js/html2pdf.bundle.min.js')); ?>"></script>
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
<?php $__env->startSection('page-action'); ?>
    <div>
        <a  class="btn btn-sm btn-primary" onclick="saveAsPDF()"  data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Download')); ?>">
            <i class="ti ti-download"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class=" multi-collapse mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::open(array('route' => array('report.account.statement'),'method'=>'get','id'=>'report_account'))); ?>

                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                        <?php echo e(Form::label('start_month', __('Start Month'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::month('start_month',isset($_GET['start_month'])?$_GET['start_month']:date('Y-m'),array('class'=>'month-btn form-control'))); ?>

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                        <?php echo e(Form::label('end_month', __('End Month'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:date('Y-m'),array('class'=>'month-btn form-control'))); ?>

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                        <?php echo e(Form::label('account', __('Account'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('account', $account,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control ','placeholder' => 'Select Account'))); ?>

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                        <?php echo e(Form::label('type', __('Type'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('type',$types,isset($_GET['type'])?$_GET['type']:'', array('class' => 'form-control ','placeholder' => 'Select Type'))); ?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto float-end ms-2 mt-4">
                                        <a  class="btn btn-sm btn-primary me-1"
                                            onclick="document.getElementById('report_account').submit(); return false;"
                                            data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                            data-original-title="<?php echo e(__('apply')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="<?php echo e(route('report.account.statement')); ?>" class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>"
                                            data-original-title="<?php echo e(__('Reset')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
    <div id="printableArea">
        <div class="row mt-3">
            <div class="col-md-6 col-12">
                <input type="hidden" value="<?php echo e(__('Account Statement').' '.$filter['type'].' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']); ?>" id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h6 class="report-text mb-0 mt-1"><?php echo e(__('Account Statement Summary')); ?></h6>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filter['account']!=__('All')): ?>
                <div class="col-md-6 col-12">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Account')); ?> :</h5>
                        <h6 class="report-text mb-0 mt-1"><?php echo e($filter['account']); ?></h6>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filter['type']!=__('All')): ?>
                <div class="col-md-6 col-12">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Type')); ?> :</h5>
                        <h6 class="report-text mb-0 mt-1"><?php echo e($filter['type']); ?></h6>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="col-md-6 col-12">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h5>
                    <h6 class="report-text mb-0 mt-1"><?php echo e($filter['startDateRange'].' to '.$filter['endDateRange']); ?></h6>
                </div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($reportData['revenueAccounts'])): ?>
            <div class="row">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['revenueAccounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="card p-4 mb-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($account->holder_name =='Cash'): ?>
                                <h5 class="report-text gray-text mb-0"><?php echo e($account->holder_name); ?></h5>
                            <?php elseif(empty($account->holder_name)): ?>
                                <h5 class="report-text gray-text mb-0"><?php echo e(__('Stripe / Paypal')); ?></h5>
                            <?php else: ?>
                                <h5 class="report-text gray-text mb-0"><?php echo e($account->holder_name.' - '.$account->bank_name); ?></h5>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h6 class="report-text mb-0"><?php echo e(currency_format_with_sym($account->total)); ?></h6>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($reportData['paymentAccounts'])): ?>
            <div class="row">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['paymentAccounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="card p-4 mb-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($account->holder_name =='Cash'): ?>
                                <h5 class="report-text gray-text mb-0"><?php echo e($account->holder_name); ?></h5>
                            <?php elseif(empty($account->holder_name)): ?>
                                <h5 class="report-text gray-text mb-0"><?php echo e(__('Stripe / Paypal')); ?></h5>
                            <?php else: ?>
                                <h5 class="report-text gray-text mb-0"><?php echo e($account->holder_name.' - '.$account->bank_name); ?></h5>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h5 class="report-text mb-0"><?php echo e(currency_format_with_sym($account->total)); ?></h5>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($reportData['revenues'])): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['revenues']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revenue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="font-style">
                                            <td><?php echo e(company_date_formate($revenue->date)); ?></td>
                                            <td><?php echo e(currency_format_with_sym($revenue->amount)); ?></td>
                                            <td><?php echo e($revenue->description); ?> </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($reportData['payments'])): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['payments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="font-style">
                                            <td><?php echo e(company_date_formate($payments->date)); ?></td>
                                            <td><?php echo e(currency_format_with_sym($payments->amount)); ?></td>
                                            <td><?php echo e(!empty($payments->description)?$payments->description:'-'); ?> </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\report\statement_report.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Account Drilldown Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Chart of Account')); ?>,
    <?php echo e(__('Account Drilldown Report')); ?>,
    <?php echo e(ucwords($account->code. ' - ' .$account->name)); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::open(array('route' => array('chart-of-account.show',$account->id),'method' => 'GET','id'=>'report_drilldown'))); ?>

                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('start_date', __('Start Date'),['class'=>'form-label'])); ?>

                                            <?php echo e(Form::date('start_date',$filter['startDateRange'], array('class' => 'month-btn form-control'))); ?>

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('end_date', __('End Date'),['class'=>'form-label'])); ?>

                                            <?php echo e(Form::date('end_date',$filter['endDateRange'], array('class' => 'month-btn form-control'))); ?>

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('account', __('Account'),['class'=>'form-label'])); ?>

                                            <?php echo e(Form::select('account',$accounts,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control select'))); ?>                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4 d-flex">
                                        <a href="#" class="btn btn-sm btn-primary me-2" onclick="document.getElementById('report_drilldown').submit(); return false;" data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>" data-original-title="<?php echo e(__('apply')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="<?php echo e(route('chart-of-account.show',$account->id)); ?>" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="<?php echo e(__('Reset')); ?>" data-original-title="<?php echo e(__('Reset')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
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
        <div class="row mt-2">
            <div class="col-3">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0"><?php echo e(__('Report')); ?> :</h6>
                    <label class="text-sm mb-0"><?php echo e(__('Account Drilldown')); ?></label>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($account)): ?>
                <div class="col-3">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0"><?php echo e(__('Account Name')); ?> :</h6>
                        <label class="text-sm mb-0"><?php echo e($account->name); ?></label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0"><?php echo e(__('Account Code')); ?> :</h6>
                        <label class="text-sm mb-0"><?php echo e($account->code); ?></label>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="col-3">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0"><?php echo e(__('Duration')); ?> :</h6>
                    <label class="text-sm mb-0"><?php echo e($filter['startDateRange'].' to '.$filter['endDateRange']); ?></label>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th> <?php echo e(__('Account Name')); ?></th>
                                    <th> <?php echo e(__('Name')); ?></th>
                                    <th> <?php echo e(__('Transaction Type')); ?></th>
                                    <th> <?php echo e(__('Transaction Date')); ?></th>
                                    <th> <?php echo e(__('Debit')); ?></th>
                                    <th> <?php echo e(__('Credit')); ?></th>
                                    <th> <?php echo e(__('Balance')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $balance     = 0;
                                    $totalDebit  = 0;
                                    $totalCredit = 0;
                                    $chartDatas  = \Workdo\Account\Entities\AccountUtility::getAccountData($account->id,$filter['startDateRange'],$filter['endDateRange']);
                                    $accountName = \Workdo\Account\Entities\ChartOfAccount::find($account->id);
                                ?>
                                <?php
                                    $debitTotal = 0;
                                    $creditTotal = 0;
                                ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $chartDatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $account = \Workdo\Account\Entities\ChartOfAccount::find($transaction->account_id);
                                        $debit = -$transaction->debit;
                                        $credit = $transaction->credit;
                                        $debitTotal += $debit;
                                        $creditTotal += $credit;
                                        $balance = $debitTotal + $creditTotal;
                                    ?>

                                    <tr>
                                        <td><?php echo e($accountName->name); ?></td>
                                        <td><?php echo e(!empty($transaction->user_name) ? $transaction->user_name : '-'); ?></td>
                                        <td><?php echo e($transaction->reference); ?></td>
                                        <td><?php echo e($transaction->date); ?></td>
                                        <td><?php echo e(!empty($transaction->debit) ? $transaction->debit :'-'); ?></td>
                                        <td><?php echo e(!empty($transaction->credit) ? $transaction->credit :'-'); ?></td>
                                        <td><?php echo e($balance); ?></td>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\chartOfAccount\show.blade.php ENDPATH**/ ?>
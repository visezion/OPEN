<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Chart of Accounts')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Chart of Account')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('change', '#sub_type', function() {
            $('.acc_check').removeClass('d-none');
            var type = $(this).val();
            $.ajax({
                url: '<?php echo e(route('charofAccount.subType')); ?>',
                type: 'POST',
                data: {
                    "type": type,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    $('#parent').empty();
                    $.each(data, function(key, value) {
                        $('#parent').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }
            });
        });
        $(document).on('click', '#account', function() {
            const element = $('#account').is(':checked');
            $('.acc_type').addClass('d-none');
            if (element==true) {
                $('.acc_type').removeClass('d-none');
            } else {
                $('.acc_type').addClass('d-none');
            }
        });

    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <?php echo $__env->yieldPushContent('header_button'); ?>
        <?php if (app('laratrust')->hasPermission('product&service create')) : ?>
            <a href="<?php echo e(route('category.index')); ?>" data-size="md"  class="me-2 btn btn-sm btn-primary" data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>">
                <i class="ti ti-settings"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('chartofaccount create')) : ?>
            <a href="#" data-url="<?php echo e(route('chart-of-account.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Create Account')); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mt-2" id="multiCollapseExample1">
                <div class="card" id="show_filter">
                    <div class="card-body">
                        <?php echo e(Form::open(['route' => ['chart-of-account.index'], 'method' => 'GET', 'id' => 'report_bill_summary'])); ?>

                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::date('start_date', $filter['startDateRange'], ['class' => 'startDate form-control'])); ?>

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::date('end_date', $filter['endDateRange'], ['class' => 'endDate form-control'])); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-sm btn-primary me-1"
                                           onclick="document.getElementById('report_bill_summary').submit(); return false;"
                                           data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                           data-original-title="<?php echo e(__('apply')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="<?php echo e(route('chart-of-account.index')); ?>" class="btn btn-sm btn-danger "
                                           data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>"
                                           data-original-title="<?php echo e(__('Reset')); ?>">
                                        <span class="btn-inner--icon">
                                            <i class="ti ti-trash-off text-white-off "></i></span>
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

    <div class="row">
        <?php $__currentLoopData = $chartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeId=>$accounts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6><?php echo e($types->find($typeId)->name); ?></h6>
                    </div>
                    <div class="card-body table-border-style" id="type-section-<?php echo e($typeId); ?>">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%"> <?php echo e(__('Code')); ?></th>
                                        <th width="30%"> <?php echo e(__('Name')); ?></th>
                                        <th width="20%"> <?php echo e(__('Type')); ?></th>
                                        <th width="20%"> <?php echo e(__('Parent Account Name')); ?></th>
                                        <th width="20%"> <?php echo e(__('Balance')); ?></th>
                                        <th width="10%"> <?php echo e(__('Status')); ?></th>
                                        <th width="10%"> <?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $balance = 0;
                                            $totalDebit   = 0;
                                            $totalCredit  = 0;
                                            $totalBalance = \Workdo\Account\Entities\AccountUtility::getAccountBalance($account->id , $filter['startDateRange'] , $filter['endDateRange']);
                                        ?>

                                        <tr>
                                            <td><?php echo e(!empty($account->code) ? $account->code  :'-'); ?></td>

                                            <?php if(module_is_active('DoubleEntry')): ?>
                                                <td>
                                                    <a href="<?php echo e(route('report.ledger', $account->id)); ?>?account=<?php echo e($account->id); ?>"><?php echo e($account->name); ?></a>
                                                </td>
                                            <?php else: ?>
                                                <td class="text-primary"><?php echo e($account->name); ?></td>
                                            <?php endif; ?>

                                            <td><?php echo e(!empty($account->subType)?$account->subType->name:'-'); ?></td>
                                            <td><?php echo e(!empty($account->parentAccount) ? $account->parentAccount->name : '-'); ?></td>

                                            <td>
                                                <?php if(!empty($totalBalance)): ?>
                                                    <?php echo e(currency_format_with_sym($totalBalance)); ?>

                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if($account->is_enabled==1): ?>
                                                    <span class="badge bg-primary p-2 px-3"><?php echo e(__('Enabled')); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger p-2 px-3"><?php echo e(__('Disabled')); ?></span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="Action">

                                                <?php if(module_is_active('DoubleEntry')): ?>
                                                    <?php echo $__env->make('double-entry::setting.add_button',['account_id'=> $account->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endif; ?>

                                                
                                                <?php if($account->name != 'Accounts Receivable' && $account->name != 'Accounts Payable'): ?>
                                                    <?php if (app('laratrust')->hasPermission('chartofaccount edit')) : ?>
                                                        <div class="action-btn me-2">
                                                            <a href="#" class="bg-info mx-3 btn btn-sm align-items-center" data-url="<?php echo e(route('chart-of-account.edit',$account->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Account')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; // app('laratrust')->permission ?>
                                                    <?php if (app('laratrust')->hasPermission('chartofaccount delete')) : ?>
                                                        <div class="action-btn">
                                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['chart-of-account.destroy', $account->id]]); ?>

                                                            <a href="#!" class=" bg-danger btn btn-sm align-items-center text-white show_confirm" data-bs-toggle="tooltip" title='Delete'>
                                                                <i class="ti ti-trash"></i>
                                                            </a>
                                                            <?php echo Form::close(); ?>

                                                        </div>
                                                    <?php endif; // app('laratrust')->permission ?>
                                                <?php else: ?>
                                                    <div class="action-btn me-2">
                                                            <a href="#" class="bg-black mx-3 btn btn-sm align-items-center">
                                                                <i class="ti ti-lock text-white"></i>
                                                            </a>
                                                    </div>
                                                <?php endif; ?>                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <?php echo $accounts->links('vendor.pagination.global-pagination'); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();

            let url = $(this).attr('href'); // Get the pagination link URL
            let targetSection = $(this).closest('.table-border-style').attr('id'); // Identify section to reload

            // Load paginated data via AJAX
            $.ajax({
                url: url,
                success: function (data) {
                    // Replace the target section with updated data
                    $('#' + targetSection).html($(data).find('#' + targetSection).html());
                },
                error: function () {
                    alert('Failed to load data.');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\chartOfAccount\index.blade.php ENDPATH**/ ?>
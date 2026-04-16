<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Account')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <style>
    .nav-pills .nav-item a:hover,
    .nav-pills .nav-item a:focus {
        color: #0CAF60;
    }

    .nav-pills .nav-item a.active {
        text-decoration: none;
    }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="row row-gap mb-4 ">
        <div class="col-xl-6 col-12">
            <div class="dashboard-card">
                <img src="<?php echo e(asset('assets/images/layer.png')); ?>" class="dashboard-card-layer" alt="layer">
                <div class="card-inner">
                    <div class="card-content">
                        <h2><?php echo e(Auth::user()->ActiveWorkspaceName()); ?></h2>
                        <p><?php echo e(__('Simplifies accounting with streamlined invoicing, bill tracking, and real-time financial insights.')); ?></p>
                    </div>
                    <div class="card-icon  d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="118" height="118" viewBox="0 0 118 118" fill="none">
                        <path opacity="0.6" d="M103.25 58.7416V88.4877C103.25 98.321 98.3333 103.238 88.5 103.238H29.5C19.6667 103.238 14.75 98.321 14.75 88.4877V58.6924C16.225 60.4132 18.0933 61.741 20.3058 62.626C25.7142 64.7401 33.1383 67.2479 41.7917 69.0179C43.8075 69.4112 45.7741 68.4275 46.905 66.7558C49.56 62.7733 53.985 59.8729 59 59.8729C64.015 59.8729 68.44 62.7733 71.095 66.7558C72.275 68.4275 74.2416 69.4112 76.2575 69.0179C84.9108 67.2479 92.335 64.7401 97.6941 62.626C99.8575 61.741 101.775 60.4133 103.25 58.7416Z" fill="#18BF6B"/>
                        <path d="M103.25 44.2412V58.7451C101.775 60.4168 99.8575 61.7445 97.6941 62.6295C92.335 64.7437 84.9108 67.2514 76.2575 69.0214C74.2416 69.4147 72.275 68.431 71.095 66.7593C68.44 62.7768 64.015 59.8765 59 59.8765C53.985 59.8765 49.56 62.7768 46.905 66.7593C45.7741 68.431 43.8075 69.4147 41.7917 69.0214C33.1383 67.2514 25.7142 64.7437 20.3058 62.6295C18.0933 61.7445 16.225 60.4168 14.75 58.6959V44.2412C14.75 34.4079 19.6667 29.4912 29.5 29.4912H88.5C98.3333 29.4912 103.25 34.4079 103.25 44.2412Z" fill="#18BF6B"/>
                        <path opacity="0.6" d="M82.3504 22.1247V29.4997H74.9754V22.1247C74.9754 21.4363 74.4346 20.8955 73.7463 20.8955H44.2463C43.5579 20.8955 43.0171 21.4363 43.0171 22.1247V29.4997H35.6421V22.1247C35.6421 17.4047 39.4771 13.5205 44.2463 13.5205H73.7463C78.4663 13.5205 82.3504 17.4047 82.3504 22.1247Z" fill="#18BF6B"/>
                        <path d="M59.0061 78.6663C56.297 78.6663 54.0796 76.4637 54.0796 73.7497C54.0796 71.0357 56.2577 68.833 58.9668 68.833H59.0061C61.7152 68.833 63.9129 71.0357 63.9129 73.7497C63.9129 76.4637 61.7152 78.6663 59.0061 78.6663Z" fill="#18BF6B"/>
                    </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="row dashboard-wrp">
                <div class="col-sm-6 col-12">
                    <div class="dashboard-project-card">
                        <div class="card-inner  d-flex justify-content-between">
                            <div class="card-content">
                                <div class="theme-avtar bg-white">
                                    <i class="ti ti-users text-danger"></i>
                                </div>
                                <a href="<?php echo e(route('customer.index')); ?>"><h3 class="mt-3 mb-0 text-danger"><?php echo e(__('Customers')); ?></h3>                                </a>
                            </div>
                            <h3 class="mb-0"><?php echo e(\Workdo\Account\Entities\AccountUtility::countCustomers()); ?>

                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="dashboard-project-card">
                        <div class="card-inner  d-flex justify-content-between">
                            <div class="card-content">
                                <div class="theme-avtar bg-white">
                                    <i class="ti ti-note"></i>
                                </div>
                                <a href="<?php echo e(route('vendors.index')); ?>"><h3 class="mt-3 mb-0"><?php echo e(__('Vendors')); ?></h3></a>
                            </div>
                            <h3 class="mb-0"><?php echo e(\Workdo\Account\Entities\AccountUtility::countVendors()); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="dashboard-project-card">
                        <div class="card-inner  d-flex justify-content-between">
                            <div class="card-content">
                                <div class="theme-avtar bg-white">
                                    <i class="ti ti-file-invoice"></i>
                                </div>
                                <a href="<?php echo e(route('invoice.index')); ?>"><h3 class="mt-3 mb-0"><?php echo e(__('Invoices')); ?></h3></a>
                            </div>
                            <h3 class="mb-0"><?php echo e(\App\Models\Invoice::countInvoices()); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="dashboard-project-card">
                        <div class="card-inner d-flex justify-content-between">
                            <div class="card-content">
                                <div class="theme-avtar bg-white">
                                    <i class="ti ti-report-money"></i>
                                </div>
                                <a href="<?php echo e(route('bill.index')); ?>"><h3 class="mt-3 mb-0"><?php echo e(__('Bills')); ?></h3></a>
                            </div>
                            <h3 class="mb-0"><?php echo e(\Workdo\Account\Entities\AccountUtility::countBills()); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-xxl-7 d-flex flex-column">
                <div class="card h-100" >
                    <div class="card-header">
                        <h5 class="mt-1 mb-0"><?php echo e(__('Account Balance')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar account-info-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Bank')); ?></th>
                                        <th><?php echo e(__('Holder Name')); ?></th>
                                        <th><?php echo e(__('Balance')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bankAccountDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bankAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="font-style">
                                            <td><?php echo e($bankAccount->bank_name); ?></td>
                                            <td class="text-capitalize"><?php echo e($bankAccount->holder_name); ?></td>
                                            <td><?php echo e(currency_format_with_sym($bankAccount->opening_balance)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4">
                                                <div class="text-center">
                                                    <h6><?php echo e(__('there is no account balance')); ?></h6>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0"><?php echo e(__('Cashflow')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div id="cash-flow"></div>
                    </div>
                </div>

            </div>

            <div class="col-xxl-7">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('Income & Expense')); ?>

                            <span class="float-end text-muted"><?php echo e(__('Current Year') . ' - ' . $currentYear); ?></span>
                        </h5>

                    </div>
                    <div class="card-body">
                        <div id="incExpBarChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 d-flex flex-column">
                <div class="card h-100">
                    <div class="card-header">
                        <h5><?php echo e(__('Income By Category')); ?>

                            <span class="float-end text-muted"><?php echo e(__('Year') . ' - ' . $currentYear); ?></span>
                        </h5>

                    </div>
                    <div class="card-body d-flex flex-column justify-content-center h-100">
                        <div id="incomeByCategory"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0"><?php echo e(__('Latest Income')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar account-info-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Date')); ?></th>
                                        <th><?php echo e(__('Customer')); ?></th>
                                        <th><?php echo e(__('Amount Due')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $latestIncome; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(company_date_formate($income->date)); ?></td>
                                            <td><?php echo e(!empty($income->customer) ? $income->customer->name : '-'); ?></td>
                                            <td><?php echo e(currency_format_with_sym($income->amount)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 d-flex flex-column">
                <div class="card h-100">
                    <div class="card-header">
                        <h5><?php echo e(__('Expense By Category')); ?>

                            <span class="float-end text-muted"><?php echo e(__('Year') . ' - ' . $currentYear); ?></span>
                        </h5>

                    </div>
                    <div class="card-body d-flex flex-column justify-content-center h-100">
                        <div id="expenseByCategory"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-7 d-flex flex-column">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0"><?php echo e(__('Latest Expense')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar account-info-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Date')); ?></th>
                                        <th><?php echo e(__('Vendor')); ?></th>
                                        <th><?php echo e(__('Amount Due')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $latestExpense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(company_date_formate($expense->date)); ?></td>
                                            <td><?php echo e(!empty($expense->vendor) ? $expense->vendor->name : '-'); ?></td>
                                            <td><?php echo e(currency_format_with_sym($expense->amount)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 d-flex flex-column">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0"><?php echo e(__('Income Vs Expense')); ?></h5>
                    </div>
                    <div class="card-body h-100">
                        <div class="row row-gap">

                            <div class="col-md-6 col-12 d-flex flex-column justify-content-center">
                                <div class="d-flex align-items-start">
                                    <div class="badge theme-avtar bg-primary">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0"><?php echo e(__('Income Today')); ?></p>
                                        <h4 class="mb-0 text-success">
                                            <?php echo e(currency_format_with_sym(\Workdo\Account\Entities\AccountUtility::todayIncome())); ?>

                                        </h4>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 d-flex flex-column justify-content-center">
                                <div class="d-flex align-items-start">
                                    <div class="badge theme-avtar bg-info">
                                        <i class="ti ti-file-invoice"></i>
                                    </div>
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0"><?php echo e(__('Expense Today')); ?></p>
                                        <h4 class="mb-0 text-info">
                                            <?php echo e(currency_format_with_sym(\Workdo\Account\Entities\AccountUtility::todayExpense())); ?>

                                        </h4>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 d-flex flex-column justify-content-center">
                                <div class="d-flex align-items-start">
                                    <div class="badge theme-avtar bg-warning">
                                        <i class="ti ti-report-money"></i>
                                    </div>
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0"><?php echo e(__('Income This Month')); ?></p>
                                        <h4 class="mb-0 text-warning">
                                            <?php echo e(currency_format_with_sym(\Workdo\Account\Entities\AccountUtility::incomeCurrentMonth())); ?>

                                        </h4>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 d-flex flex-column justify-content-center">
                                <div class="d-flex align-items-start">
                                    <div class="badge theme-avtar bg-danger">
                                        <i class="ti ti-file-invoice"></i>
                                    </div>
                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0"><?php echo e(__('Expense This Month')); ?></p>
                                        <h4 class="mb-0 text-danger">
                                            <?php echo e(currency_format_with_sym(\Workdo\Account\Entities\AccountUtility::expenseCurrentMonth())); ?>

                                        </h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-7 d-flex flex-column">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0"><?php echo e(__('Recent Invoices')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar account-info-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Customer')); ?></th>
                                        <th><?php echo e(__('Issue Date')); ?></th>
                                        <th><?php echo e(__('Due Date')); ?></th>
                                        <th><?php echo e(__('Amount')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id)); ?>

                                            </td>
                                            <td><?php echo e(!empty($invoice->customer) ? $invoice->customer->name : ''); ?> </td>
                                            <td><?php echo e(company_date_formate($invoice->issue_date)); ?></td>
                                            <td><?php echo e(company_date_formate($invoice->due_date)); ?></td>
                                            <td><?php echo e(currency_format_with_sym($invoice->getTotal())); ?></td>
                                            <td>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->status == 0): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-info"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php elseif($invoice->status == 1): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-primary"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php elseif($invoice->status == 2): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-secondary"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php elseif($invoice->status == 3): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-warning"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php elseif($invoice->status == 4): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-success"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 d-flex flex-column">
                <div class="card h-100">
                    <div class="card-header">
                        <ul class="nav nav-pills information-tab" id="pills-tab" role="tablist" style="width: fit-content">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-Dashboard-tab" data-bs-toggle="pill"
                                    href="#invoice_weekly_statistics" role="tab" aria-controls="pills-home"
                                    aria-selected="true"><?php echo e(__('Invoices Weekly Statistics')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    href="#invoice_monthly_statistics" role="tab" aria-controls="pills-profile"
                                    aria-selected="false"><?php echo e(__('Invoices Monthly Statistics')); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="invoice_weekly_statistics" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0 ">
                                        <tbody class="list">
                                            <tr>
                                                <td class="border-top-0">
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Invoice Generated')); ?>

                                                    </p>

                                                </td>
                                                <td class="border-top-0">
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($weeklyInvoice['invoiceTotal'])); ?>

                                                    </h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Paid')); ?></p>
                                                </td>
                                                <td>
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($weeklyInvoice['invoicePaid'])); ?>

                                                    </h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Due')); ?></p>
                                                </td>
                                                <td>
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($weeklyInvoice['invoiceDue'])); ?>

                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="invoice_monthly_statistics" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0 ">
                                        <tbody class="list">
                                            <tr>
                                                <td class="border-top-0">
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Invoice Generated')); ?>

                                                    </p>

                                                </td>
                                                <td class="border-top-0">
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($monthlyInvoice['invoiceTotal'])); ?>

                                                    </h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Paid')); ?></p>
                                                </td>
                                                <td>
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($monthlyInvoice['invoicePaid'])); ?>

                                                    </h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Due')); ?></p>
                                                </td>
                                                <td>
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($monthlyInvoice['invoiceDue'])); ?>

                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-7 d-flex flex-column">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mt-1 mb-0"><?php echo e(__('Recent Bills')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive  custom-scrollbar account-info-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('Vendor')); ?></th>
                                        <th><?php echo e(__('Bill Date')); ?></th>
                                        <th><?php echo e(__('Due Date')); ?></th>
                                        <th><?php echo e(__('Amount')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentBill; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(\Workdo\Account\Entities\Bill::billNumberFormat($bill->bill_id)); ?>

                                            </td>
                                            <td><?php echo e(!empty($bill->vendor_name) ? $bill->vendor_name : ''); ?> </td>
                                            <td><?php echo e(company_date_formate($bill->bill_date)); ?></td>
                                            <td><?php echo e(company_date_formate($bill->due_date)); ?></td>
                                            <td><?php echo e(currency_format_with_sym($bill->getTotal())); ?></td>
                                            <td>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status == 0): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-info"><?php echo e(__(\Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php elseif($bill->status == 1): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-primary"><?php echo e(__(\Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php elseif($bill->status == 2): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-secondary"><?php echo e(__(\Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php elseif($bill->status == 3): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-warning"><?php echo e(__(\Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php elseif($bill->status == 4): ?>
                                                    <span
                                                        class="p-2 px-3 badge bg-success"><?php echo e(__(\Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 d-flex flex-column">
                <div class="card h-100">
                    <div class="card-header">
                        <ul class="nav nav-pills information-tab" id="pills-tab" role="tablist" style="width: fit-content">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    href="#bills_weekly_statistics" role="tab" aria-controls="pills-home"
                                    aria-selected="true"><?php echo e(__('Bills Weekly Statistics')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    href="#bills_monthly_statistics" role="tab" aria-controls="pills-profile"
                                    aria-selected="false"><?php echo e(__('Bills Monthly Statistics')); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="bills_weekly_statistics" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0 ">
                                        <tbody class="list">
                                            <tr>
                                                <td class="border-top-0">
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Bill Generated')); ?></p>

                                                </td>
                                                <td class="border-top-0">
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($weeklyBill['billTotal'])); ?></h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Paid')); ?></p>
                                                </td>
                                                <td>
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($weeklyBill['billPaid'])); ?></h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Due')); ?></p>
                                                </td>
                                                <td>
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($weeklyBill['billDue'])); ?></h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="bills_monthly_statistics" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0 ">
                                        <tbody class="list">
                                            <tr>
                                                <td class="border-top-0">
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Bill Generated')); ?></p>

                                                </td>
                                                <td class="border-top-0">
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($monthlyBill['billTotal'])); ?></h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Paid')); ?></p>
                                                </td>
                                                <td>
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($monthlyBill['billPaid'])); ?></h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><?php echo e(__('Total')); ?></h5>
                                                    <p class="text-muted text-sm mb-0"><?php echo e(__('Due')); ?></p>
                                                </td>
                                                <td>
                                                    <h4 class="text-muted">
                                                        <?php echo e(currency_format_with_sym($monthlyBill['billDue'])); ?></h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Goal')): ?>
                <?php echo $__env->make('goal::dashboard.dshboard_div', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script>
        (function() {
            var chartBarOptions = {
                series: [{
                        name: "<?php echo e(__('Income')); ?>",
                        data: <?php echo json_encode($incExpLineChartData['income']); ?>

                    },
                    {
                        name: "<?php echo e(__('Expense')); ?>",
                        data: <?php echo json_encode($incExpLineChartData['expense']); ?>

                    }
                ],

                chart: {
                    height: 300,
                    type: 'area',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: <?php echo json_encode($incExpLineChartData['day']); ?>,
                    title: {
                        text: '<?php echo e(__('Date')); ?>'
                    }
                },
                colors: ['#ffa21d', '#FF3A6E'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                yaxis: {
                    title: {
                        text: '<?php echo e(__('Amount')); ?>'
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#cash-flow"), chartBarOptions);
            arChart.render();
        })();

        (function() {
            var options = {
                chart: {
                    height: 180,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: "<?php echo e(__('Income')); ?>",
                    data: <?php echo json_encode($incExpBarChartData['income']); ?>

                }, {
                    name: "<?php echo e(__('Expense')); ?>",
                    data: <?php echo json_encode($incExpBarChartData['expense']); ?>

                }],
                xaxis: {
                    categories: <?php echo json_encode($incExpBarChartData['month']); ?>,
                },
                colors: ['#3ec9d6', '#FF3A6E'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                markers: {
                    size: 4,
                    colors: ['#3ec9d6', '#FF3A6E', ],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#incExpBarChart"), options);
            chart.render();
        })();

        (function() {
            var options = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: <?php echo json_encode($expenseCatAmount); ?>,
                colors: <?php echo json_encode($expenseCategoryColor); ?>,
                labels: <?php echo json_encode($expenseCategory); ?>,
                legend: {
                    show: true
                }
            };
            var chart = new ApexCharts(document.querySelector("#expenseByCategory"), options);
            chart.render();
        })();

        (function() {
            var options = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: <?php echo json_encode($incomeCatAmount); ?>,
                colors: <?php echo json_encode($incomeCategoryColor); ?>,
                labels: <?php echo json_encode($incomeCategory); ?>,
                legend: {
                    show: true
                }
            };
            var chart = new ApexCharts(document.querySelector("#incomeByCategory"), options);
            chart.render();
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\dashboard\dashboard.blade.php ENDPATH**/ ?>
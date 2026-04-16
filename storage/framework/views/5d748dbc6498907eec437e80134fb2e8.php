<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Bill Summary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Report')); ?>,
    <?php echo e(__('Bill Summary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style>
    .bill_status{
        min-width: 94px;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script>
        (function() {
            var chartBarOptions = {
                 series: [{
                    name: '<?php echo e(__('Bill')); ?>',
                    data: <?php echo json_encode($billTotal); ?>,

                },{
                    name: '<?php echo e(__('Purchase')); ?>',
                    data: <?php echo json_encode($purchaseTotal); ?>,

                } ],
                chart: {
                    height: 300,
                    type: 'bar',
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
                    categories: <?php echo json_encode($monthList); ?>,
                    title: {
                        text: '<?php echo e(__('Months')); ?>'
                    }
                },
                colors: ['#6fd944', '#FF3A6E'],

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
                    colors: ['#6fd944', '#FF3A6E'],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    title: {
                        text: '<?php echo e(__('Bill / Purchase')); ?>'
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#chart-sales"), chartBarOptions);
            arChart.render();
        })();
    </script>
    <script src="<?php echo e(asset('packages/workdo/Account/src/Resources/assets/js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A2'
                }
            };
            html2pdf().set(opt).from(element).save();
        }


    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
    <div>
        <a  class="btn btn-sm btn-primary" onclick="saveAsPDF()" data-bs-toggle="tooltip"
            data-bs-original-title="<?php echo e(__('Download')); ?>">
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
                        <?php echo e(Form::open(['route' => ['report.bill.summary'], 'method' => 'GET', 'id' => 'report_bill_summary'])); ?>

                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('start_month', __('Start Month'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::month('start_month', isset($_GET['start_month']) ? $_GET['start_month'] : date('Y-01'), ['class' => 'month-btn form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('end_month', __('End Month'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::month('end_month', isset($_GET['end_month']) ? $_GET['end_month'] : date('Y-12'), ['class' => 'month-btn form-control'])); ?>

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('vendor', __('Vendor'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('vendor', $vendor, isset($_GET['vendor']) ? $_GET['vendor'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Vendor'])); ?>

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('status', $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Status'])); ?>

                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">
                                        <a  class="btn btn-sm btn-primary me-1"
                                            onclick="document.getElementById('report_bill_summary').submit(); return false;"
                                            data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                            data-original-title="<?php echo e(__('apply')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="<?php echo e(route('report.bill.summary')); ?>" class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>"
                                            data-original-title="<?php echo e(__('Reset')); ?>">
                                            <span class="btn-inner--icon"><i
                                                    class="ti ti-trash-off text-white-off "></i></span>
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
            <div class="col">
                <input type="hidden"
                    value="<?php echo e($filter['status'] . ' ' . __('Bill') . ' ' . 'Report of' . ' ' . $filter['startDateRange'] . ' to ' . $filter['endDateRange'] . ' ' . __('of') . ' ' . $filter['vendor']); ?>"
                    id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h6 class="report-text mb-0 mt-1"><?php echo e(__('Bill Summary')); ?></h6>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filter['vendor'] != __('All')): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Vendor')); ?> :</h5>
                        <h6 class="report-text mb-0 mt-1"><?php echo e($filter['vendor']); ?></h6>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filter['status'] != __('All')): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Status')); ?> :</h5>
                        <h6 class="report-text mb-0 mt-1"><?php echo e($filter['status']); ?></h6>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h5>
                    <h6 class="report-text mb-0 mt-1"><?php echo e($filter['startDateRange'] . ' to ' . $filter['endDateRange']); ?></h6>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Bill')); ?></h5>
                    <h6 class="report-text mb-0"><?php echo e(currency_format_with_sym($totalBill)); ?></h6>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Paid')); ?></h5>
                    <h6 class="report-text mb-0"><?php echo e(currency_format_with_sym($totalPaidBill)); ?></h6>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Due')); ?></h5>
                    <h6 class="report-text mb-0"><?php echo e(currency_format_with_sym($totalDueBill)); ?></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="bill-container">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item me-1">
                                    <a class="nav-link active" id="profile-tab3" data-bs-toggle="pill" href="#summary"
                                        role="tab" aria-controls="pills-summary"
                                        aria-selected="true"><?php echo e(__('Summary')); ?></a>
                                </li>
                                <li class="nav-item me-1">
                                    <a class="nav-link" id="contact-tab4" data-bs-toggle="pill" href="#bills"
                                        role="tab" aria-controls="pills-invoice"
                                        aria-selected="false"><?php echo e(__('Bills')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab5" data-bs-toggle="pill" href="#purchase"
                                        role="tab" aria-controls="pills-invoice"
                                        aria-selected="false"><?php echo e(__('Purchase')); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="tab-content" id="myTabContent2">
                                    <div class="table-responsive tab-pane fade fade" id="bills" role="tabpanel"
                                        aria-labelledby="profile-tab3">
                                        <table class="table table-flush" id="report-dataTable">
                                            <thead>
                                                <tr>
                                                    <th> <?php echo e(__('Bill')); ?></th>
                                                    <th> <?php echo e(__('Date')); ?></th>
                                                    <th> <?php echo e(__('Vendor')); ?></th>
                                                    <th> <?php echo e(__('Category')); ?></th>
                                                    <th> <?php echo e(__('Status')); ?></th>
                                                    <th> <?php echo e(__('Paid Amount')); ?></th>
                                                    <th> <?php echo e(__('Due Amount')); ?></th>
                                                    <th> <?php echo e(__('Payment Date')); ?></th>
                                                    <th> <?php echo e(__('Amount')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td class="Id">
                                                            <a href="<?php echo e(route('bill.show', \Crypt::encrypt($bill->id))); ?>"
                                                                class="btn btn-outline-primary"><?php echo e(\Workdo\Account\Entities\Bill::billNumberFormat($bill->bill_id)); ?></a>
                                                        </td>
                                                        </td>
                                                        <td><?php echo e(company_date_formate($bill->send_date)); ?></td>
                                                        <td> <?php echo e(!empty($bill->vendor_name) ? $bill->vendor_name : '-'); ?> </td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService')): ?>
                                                            <td><?php echo e(!empty($bill->categories_name) ? $bill->categories_name : '-'); ?>

                                                            </td>
                                                        <?php else: ?>
                                                            <td>-</td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <td>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->status == 0): ?>
                                                                <span
                                                                    class="badge  bg-info p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                            <?php elseif($bill->status == 1): ?>
                                                                <span
                                                                    class="badge  bg-primary p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                            <?php elseif($bill->status == 2): ?>
                                                                <span
                                                                    class="badge  bg-secondary p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                            <?php elseif($bill->status == 3): ?>
                                                                <span
                                                                    class="badge  bg-warning p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                            <?php elseif($bill->status == 4): ?>
                                                                <span
                                                                    class="badge  bg-success p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </td>
                                                        <td> <?php echo e(currency_format_with_sym($bill->getTotal() - $bill->getDue())); ?>

                                                        </td>
                                                        <td> <?php echo e(currency_format_with_sym($bill->getDue())); ?></td>
                                                        <td><?php echo e(!empty($bill->lastpayment_date) ? company_date_formate($bill->lastpayment_date) : ''); ?>

                                                        </td>
                                                        <td> <?php echo e(currency_format_with_sym($bill->getTotal())); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive tab-pane fade fade" id="purchase" role="tabpanel"
                                        aria-labelledby="profile-tab3">
                                        <table class="table table-flush" id="report-dataTable">
                                            <thead>
                                                <tr>
                                                    <th> <?php echo e(__('Purchase')); ?></th>
                                                    <th> <?php echo e(__('Date')); ?></th>
                                                    <th> <?php echo e(__('Vendor')); ?></th>
                                                    <th> <?php echo e(__('Category')); ?></th>
                                                    <th> <?php echo e(__('Status')); ?></th>
                                                    <th> <?php echo e(__('Paid Amount')); ?></th>
                                                    <th> <?php echo e(__('Due Amount')); ?></th>
                                                    <th> <?php echo e(__('Payment Date')); ?></th>
                                                    <th> <?php echo e(__('Amount')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td class="Id">
                                                            <a href="<?php echo e(route('purchases.show', \Crypt::encrypt($purchase->id))); ?>"
                                                                class="btn btn-outline-primary"><?php echo e(\App\Models\Purchase::purchaseNumberFormat($purchase->purchase_id)); ?></a>
                                                        </td>
                                                        </td>
                                                        <td><?php echo e(company_date_formate($purchase->send_date)); ?></td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($purchase->vender_name)): ?>
                                                                <td> <?php echo e((!empty( $purchase->vender_name)?$purchase->vender_name:'')); ?> </td>
                                                        <?php elseif(empty($purchase->vender_name)): ?>
                                                            <td><?php echo e(($purchase->user->name)); ?></td>
                                                        <?php else: ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account')): ?>
                                                                <td> <?php echo e((!empty( $purchase->vender)?$purchase->vender->name:'')); ?> </td>
                                                            <?php else: ?>
                                                                <td>-</td>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService')): ?>
                                                            <td><?php echo e(!empty($purchase->categories_name) ? $purchase->categories_name : '-'); ?>

                                                            </td>
                                                        <?php else: ?>
                                                            <td>-</td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <td>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status == 0): ?>
                                                                <span
                                                                    class="badge bg-info p-2 px-3 purchase_status"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                            <?php elseif($purchase->status == 1): ?>
                                                                <span
                                                                    class="badge bg-primary p-2 px-3 purchase_status"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                            <?php elseif($purchase->status == 2): ?>
                                                                <span
                                                                    class="badge bg-secondary p-2 px-3 purchase_status"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                            <?php elseif($purchase->status == 3): ?>
                                                                <span
                                                                    class="badge bg-warning p-2 px-3 purchase_status"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                            <?php elseif($purchase->status == 4): ?>
                                                                <span
                                                                    class="badge bg-success p-2 px-3 purchase_status"><?php echo e(__(App\Models\Purchase::$statues[$purchase->status])); ?></span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </td>
                                                        <td> <?php echo e(currency_format_with_sym($purchase->getTotal() - $purchase->getDue())); ?>

                                                        </td>
                                                        <td> <?php echo e(currency_format_with_sym($purchase->getDue())); ?></td>
                                                        <td><?php echo e(!empty($purchase->lastpayment_date) ? company_date_formate($purchase->lastpayment_date) : ''); ?>

                                                        </td>
                                                        <td> <?php echo e(currency_format_with_sym($purchase->getTotal())); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade fade show active" id="summary" role="tabpanel"
                                        aria-labelledby="profile-tab3">
                                        <div class="scrollbar-inner">
                                            <div id="chart-sales" data-color="primary" data-type="bar"
                                                data-height="300"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\report\bill_report.blade.php ENDPATH**/ ?>
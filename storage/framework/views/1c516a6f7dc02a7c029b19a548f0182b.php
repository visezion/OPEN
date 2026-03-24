<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Expense Summary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Report')); ?>,
    <?php echo e(__('Expense Summary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script>
        (function() {
            var chartBarOptions = {
                series: [{
                    name: '<?php echo e(__('Expense')); ?>',
                    data: <?php echo json_encode($chartExpenseArr); ?>,
                }, ],
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
                    categories: <?php echo json_encode($monthList); ?>,
                    title: {
                        text: '<?php echo e(__('Months')); ?>'
                    }
                },
                colors: ['#6fd944', '#6fd944'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },

                yaxis: {
                    title: {
                        text: '<?php echo e(__('Expense')); ?>'
                    },
                }
            };
            var arChart = new ApexCharts(document.querySelector("#chart-sales"), chartBarOptions);
            arChart.render();
        })();
    </script>
    <script src="<?php echo e(asset('packages/workdo/Account/src/Resources/assets/js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var year = '<?php echo e($currentYear); ?>';
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
    <div class="d-flex">
        <a class="btn btn-sm btn-primary" onclick="saveAsPDF()" data-bs-toggle="tooltip"
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
                        <?php echo e(Form::open(['route' => ['report.expense.summary'], 'method' => 'GET', 'id' => 'report_expense_summary'])); ?>

                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mb-2">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('year', __('Year'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('year', $yearList, isset($_GET['year']) ? $_GET['year'] : date('Y'), ['class' => 'form-control ', 'placeholder' => 'Select Year'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('category', __('Category'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('category', $category, isset($_GET['category']) ? $_GET['category'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Category'])); ?>

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('vendor', __('Vendor'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('vendor', $vendor, isset($_GET['vendor']) ? $_GET['vendor'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Vendor'])); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto float-end ms-2 mt-4">
                                        <a class="btn btn-sm btn-primary me-1"
                                            onclick="document.getElementById('report_expense_summary').submit(); return false;"
                                            data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                            data-original-title="<?php echo e(__('apply')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="<?php echo e(route('report.expense.summary')); ?>" class="btn btn-sm btn-danger"
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
            <div class="col-sm-6 col-12">
                <input type="hidden"
                    value="<?php echo e($filter['category'] . ' ' . __('Expense Summary') . ' ' . 'Report of' . ' ' . $filter['startDateRange'] . ' to ' . $filter['endDateRange']); ?>"
                    id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h6 class="report-text mb-0 mt-1"><?php echo e(__('Expense Summary')); ?></h6>
                </div>
            </div>
            <?php if($filter['category'] != __('All')): ?>
                <div class="col-sm-6 col-12">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Category')); ?> :</h5>
                        <h6 class="report-text mb-0 mt-1"><?php echo e($filter['category']); ?></h6>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($filter['vendor'] != __('All')): ?>
                <div class="col-sm-6 col-12">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Vendor')); ?> :</h5>
                        <h6 class="report-text mb-0 mt-1"><?php echo e($filter['vendor']); ?></h6>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-sm-6 col-12">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h5>
                    <h6 class="report-text mb-0 mt-1"><?php echo e($filter['startDateRange'] . ' to ' . $filter['endDateRange']); ?></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="chart-container">
                <div class="card">
                    <div class="card-body">
                        <div class="scrollbar-inner">
                            <div id="chart-sales" data-color="primary" data-height="300"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Category')); ?></th>
                                        <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo e($month); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="13" class="text-dark"><span><?php echo e(__('Payment :')); ?></span></td>
                                    </tr>
                                    <?php $__currentLoopData = $expenseArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(!empty($expense['category']) ? $expense['category'] : ''); ?></td>
                                            <?php $__currentLoopData = $expense['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td><?php echo e(currency_format_with_sym($data)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td colspan="13" class="text-dark"><span><?php echo e(__('Bill :')); ?></span></td>
                                    </tr>
                                    <?php $__currentLoopData = $billArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(!empty($bill['category']) ? $bill['category'] : ''); ?></td>
                                            <?php $__currentLoopData = $bill['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td><?php echo e(currency_format_with_sym($data)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td colspan="13" class="text-dark"><span><?php echo e(__('Purchase :')); ?></span></td>
                                    </tr>
                                    <?php $__currentLoopData = $purchaseArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(!empty($purchase['category']) ? $purchase['category'] : ''); ?></td>
                                            <?php $__currentLoopData = $purchase['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td><?php echo e(currency_format_with_sym($data)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(module_is_active('Hrm') || module_is_active('Hrm') && module_is_active('Training')): ?>
                                        <tr>
                                            <td colspan="13" class="text-dark"><span><?php echo e(__('Employee Salary :')); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo e(__('Employee Salary')); ?></td>
                                            <?php $__currentLoopData = $EmpSalary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $empsal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td><?php echo e(currency_format_with_sym($empsal)); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                        <?php if(module_is_active('Training')): ?>
                                            <tr>
                                                <td colspan="13" class="text-dark"><span><?php echo e(__('Training Cost :')); ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e(__('Training Cost')); ?></td>
                                                <?php $__currentLoopData = $TrainingCost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $trainingcost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td><?php echo e(currency_format_with_sym($trainingcost)); ?></td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                            <tr>
                                                <td colspan="13" class="text-dark">
                                                    <span><?php echo e(__('Expense = Payment + Bill + Employee Salary + Training Cost :')); ?></span>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="13" class="text-dark">
                                                    <span><?php echo e(__('Expense = Payment + Bill + Employee Salary :')); ?></span>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="13" class="text-dark">
                                                <span><?php echo e(__('Expense = Payment + Bill + Purchase :')); ?></span>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="text-dark">
                                            <h6><?php echo e(__('Total')); ?></h6>
                                        </td>
                                        <?php $__currentLoopData = $chartExpenseArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(currency_format_with_sym($expense)); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\report\expense_summary.blade.php ENDPATH**/ ?>
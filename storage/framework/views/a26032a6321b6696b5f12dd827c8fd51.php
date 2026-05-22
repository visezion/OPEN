<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Purchase')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Report')); ?>,
    <?php echo e(__('Daily Purchase Report')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>

    <script>
        (function () {
            var chartBarOptions = {
                series: [
                    {
                        name: '<?php echo e(__("Purchase")); ?>',
                        data:   <?php echo json_encode($data); ?>,
                    },
                ],

                chart: {
                    height: 300,
                    type: 'area',
                    // type: 'line',
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
                        text: '<?php echo e(__("Months")); ?>'
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
                        text: '<?php echo e(__("Amount")); ?>'
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#monthly-purchase"), chartBarOptions);
            arChart.render();
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>

    <div>
        <a class="btn btn-sm btn-primary" onclick="saveAsPDF()" data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Download')); ?>">
            <i class="ti ti-download"></i>
        </a>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="pills-home-tab" data-bs-toggle="pill"
               href="<?php echo e(route('reports.daily.purchase')); ?>"
               onclick="window.location.href = '<?php echo e(route('reports.daily.purchase')); ?>'" role="tab"
               aria-controls="pills-home" aria-selected="true"><?php echo e(__('Daily')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" href="#monthly-chart" role="tab"
               aria-controls="pills-profile" aria-selected="false"><?php echo e(__('Monthly')); ?></a>
        </li>
    </ul>

    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " >
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::open(['route' => ['reports.monthly.purchase'], 'method' => 'GET', 'id' => 'monthly_purchase_report_submit'])); ?>

                        <div class="row d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    <?php echo e(Form::label('year', __('Year'),['class'=>'form-label'])); ?>

                                    <?php echo e(Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control select'))); ?>

                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <?php echo e(Form::label('warehouse', __('Warehouse'),['class'=>'form-label'])); ?>

                                    <?php echo e(Form::select('warehouse',$warehouse,isset($_GET['warehouse'])?$_GET['warehouse']:'', array('class' => 'form-control select'))); ?>

                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <?php echo e(Form::label('vendor', __('Vendor'),['class'=>'form-label'])); ?>

                                    <?php echo e(Form::select('vendor',$vendor,isset($_GET['vendor'])?$_GET['vendor']:'', array('class' => 'form-control select'))); ?>

                                </div>
                            </div>

                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary me-1"
                                   onclick="document.getElementById('monthly_purchase_report_submit').submit(); return false;"
                                   data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>" title="<?php echo e(__('Apply')); ?>">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="<?php echo e(route('reports.monthly.purchase')); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                   data-original-title="<?php echo e(__('Reset')); ?>" title="<?php echo e(__('Reset')); ?>">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                                </a>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="printableArea">
        <div class="row mt-0">
            <div class="col">
                <input type="hidden" value="<?php echo e($filter['warehouse'].' '.__('Monthly Purchase').' '.'Report of'.' '.$filter['startMonth'].' to '.$filter['endMonth']); ?>" id="filename">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h7>
                    <h6 class="report-text mb-0"><?php echo e(__('Monthly Purchase Report')); ?></h6>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($filter['warehouse'])): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h7 class="report-text gray-text mb-0"><?php echo e(__('Warehouse')); ?> :</h7>
                        <h6 class="report-text mb-0"><?php echo e($filter['warehouse']); ?></h6>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($filter['vendor'])): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h7 class="report-text gray-text mb-0"><?php echo e(__('Vendor')); ?> :</h7>
                        <h6 class="report-text mb-0"><?php echo e($filter['vendor']); ?></h6>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="col">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h7>
                    <h6 class="report-text mb-0"><?php echo e($filter['startMonth'].' to '.$filter['endMonth']); ?></h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="setting-tab">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="monthly-chart" role="tabpanel">
                                <div class="col-lg-12">
                                    <div class="card-header">
                                        <div class="row ">
                                            <div class="col-6">
                                                <h6><?php echo e(__('Monthly Report')); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="monthly-purchase"></div>
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




<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\report\monthly_purchase.blade.php ENDPATH**/ ?>
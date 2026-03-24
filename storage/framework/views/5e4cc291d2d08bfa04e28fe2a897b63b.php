<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Warehouse Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Report')); ?>,
    <?php echo e(__('Warehouse Report')); ?>

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
                        name: '<?php echo e(__("Product")); ?>',
                        data:  <?php echo json_encode($warehouseProductData); ?>,
                        // data:  [150,90,160,80],
                    },
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
                    categories: <?php echo json_encode($warehousename); ?>,
                    title: {
                        text: '<?php echo e(__("Warehouse")); ?>'
                    }
                },
                colors: ['#6fd944'],


                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },

                
                
                
                

                

            };
            var arChart = new ApexCharts(document.querySelector("#warehouse_report"), chartBarOptions);
            arChart.render();
        })();

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
    <style>
        .apexcharts-xaxis-label tspan {
            font-size: 11px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <div>
        <a  class="btn btn-sm btn-primary" onclick="saveAsPDF()"  data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Download')); ?>">
            <i class="ti ti-download"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div id="printableArea">
        <div class="row mt-4">
            <input type="hidden" value="<?php echo e(__('Warehouse Report')); ?>" id="filename">
            <div class="col">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h7>
                    <h6 class="report-text mb-0"><?php echo e(__('Warehouse Report')); ?></h6>
                </div>
            </div>
            <div class="col">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0"><?php echo e(__('Total Warehouse')); ?> :</h7>
                    <h6 class="report-text mb-0"><?php echo e($totalWarehouse); ?></h6>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0"><?php echo e(__('Total Product')); ?> :</h7>
                    <h6 class="report-text mb-0"><?php echo e($totalProduct); ?></h6>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row ">
                            <div class="col-6">
                                <h6><?php echo e(__('Warehouse Report')); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="warehouse_report"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\report\warehouse.blade.php ENDPATH**/ ?>
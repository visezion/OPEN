<?php
    $modules = getshowModuleList();
?>
    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a href="<?php echo e(route('landingpage.index')); ?>" class="nav-link text-capitalize <?php echo e((Request::route()->getName() == 'landingpage.index') ? ' active' : ''); ?>"><?php echo e(__('Details')); ?> <div class="float-end"></div></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('landingpage.custom')); ?>" class="nav-link text-capitalize <?php echo e((Request::route()->getName() == 'landingpage.custom') ? ' active' : ''); ?>"><?php echo e(__('Custom')); ?> <div class="float-end"></div></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('join_us.index')); ?>" class="nav-link text-capitalize <?php echo e((Request::route()->getName() == 'join_us.index') ? ' active' : ''); ?>"><?php echo e(__('Newsletter')); ?> <div class="float-end"></div></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('landing.change.blocks')); ?>" class="nav-link text-capitalize <?php echo e((Request::route()->getName() == 'landing.change.blocks') ? ' active' : ''); ?>"><?php echo e(__('Change Blocks')); ?> <div class="float-end"></div></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('landing.seo')); ?>" class="nav-link text-capitalize <?php echo e((Request::route()->getName() == 'landing.seo') ? ' active' : ''); ?>"><?php echo e(__('SEO')); ?> <div class="float-end"></div></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('landing.pwa')); ?>" class="nav-link text-capitalize <?php echo e((Request::route()->getName() == 'landing.pwa') ? ' active' : ''); ?>"><?php echo e(__('PWA')); ?> <div class="float-end"></div></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('landing.cookie')); ?>" class="nav-link text-capitalize <?php echo e((Request::route()->getName() == 'landing.cookie') ? ' active' : ''); ?>"><?php echo e(__('Cookie')); ?> <div class="float-end"></div></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('landing.qrCode')); ?>" class="nav-link text-capitalize <?php echo e((Request::route()->getName() == 'landing.qrCode') ? ' active' : ''); ?>"><?php echo e(__('QR Code')); ?> <div class="float-end"></div></a>
            </li>
    </ul>


<div class="modal fade" id="exampleModalCenter" tabindex="2" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl ss_modale" role="document">
        <div class="modal-content image_sider_div">
        </div>
    </div>
</div>

<div class="modal fade" id="qrcodeModal" data-backdrop="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('QR Code')); ?></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="qrdata">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('landingpage::layouts.infoimagescss', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('landingpage::layouts.infoimagesjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        $('#download-qr').on('click', function() {
            $.ajax({
                url: '<?php echo e(route('download.qr')); ?>',
                type: 'GET',
                beforeSend: function () {
                        $(".loader-wrapper").removeClass('d-none');
                    },
                success: function(data) {
                    if (data.success == true) {
                        $('#qrdata').html(data.data);
                    }
                    setTimeout(() => {
                        // canvasdata();
                        var element = document.querySelector("#qrdata");
                        $("#qrcodeModal").modal('show');
                        $("body").css("overflow",'');
                        $("body").css("padding-right",'');
                        $('body').removeClass('modal-open');
                        $('#qrcodeModal').removeClass('modal-backdrop');
                        $(".modal-backdrop").removeClass("show");
                        $(".loader-wrapper").addClass('d-none');
                        }, 1000);
                }
            });
        });
  </script>

<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\sections.blade.php ENDPATH**/ ?>
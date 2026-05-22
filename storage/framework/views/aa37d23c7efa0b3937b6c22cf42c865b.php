<?php
        $settings = \Workdo\LandingPage\Entities\LandingPageSetting::settings();
    ?>
    <?php $__env->startPush('css'); ?>
        <style>
            .shareqrcode img {
                width: 65%;
                height: 65%;
            }

            .shareqrcode canvas {
                width: 65%;
                height: 65%;
            }
            .sharingButtonsContainer {
                position: absolute;
                top: 95%;
                left: 20px;
                z-index: 1;
            }
            .socialJS {
                display: flex;
                gap: 0 10px;
            }
            .sharingButtonsContainer .Demo1 {
                margin-bottom: 0px !important;
            }
            .sharingButtonsContainer a {
                background-color: #ddd;
                display: flex;
                justify-content: center;
                min-width: 13px;
                padding: 7px;
                border-radius: 4px;
                width: 30px;
            }
            @media screen and (max-width: 575px) {
                .sharingButtonsContainer {
                    left: 50%;
                    transform: translateX(-50%);
                }
            }
        </style>
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/js/jquery.qrcode.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/js/jquery.qrcode.min.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/js/socialSharing.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/js/socialSharing.min.js')); ?>"></script>

        <script type="text/javascript">
            $('.cp_link').on('click', function() {
                var value = $(this).attr('data-link');
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(value).select();
                document.execCommand("copy");
                $temp.remove();
                toastrs('<?php echo e(__('Success')); ?>', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success');
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                var customURL = <?php echo json_encode(url('/')); ?>;
                $('.Demo1').socialSharingPlugin({
                    url: customURL,
                    title: $('meta[property="og:title"]').attr('content'),
                    description: $('meta[property="og:description"]').attr('content'),
                    img: $('meta[property="og:image"]').attr('content'),
                    enable: ['whatsapp', 'facebook', 'twitter', 'pinterest', 'linkedin']
                });

                $('.socialShareButton').click(function(e) {
                    e.preventDefault();
                    $('.sharingButtonsContainer').toggle();
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                var url_link = `<?php echo e(url('/')); ?>`;

                $(`.qr-link`).text(url_link);

                var foreground_color =
                    `<?php echo e(isset($settings['foreground_color']) ? $settings['foreground_color'] : '#000000'); ?>`;
                var background_color =
                    `<?php echo e(isset($settings['background_color']) ? $settings['background_color'] : '#ffffff'); ?>`;
                var radius = `<?php echo e(isset($settings['radius']) ? $settings['radius'] : 26); ?>`;
                var qr_type = `<?php echo e(isset($settings['qr_type']) ? $settings['qr_type'] : 0); ?>`;
                var qr_font = `<?php echo e(isset($settings['qr_text']) ? $settings['qr_text'] : 'vCard'); ?>`;
                var qr_font_color =
                    `<?php echo e(isset($settings['qr_text_color']) ? $settings['qr_text_color'] : '#f50a0a'); ?>`;
                var size = `<?php echo e(isset($settings['size']) ? $settings['size'] : 9); ?>`;

                $('.shareqrcode').empty().qrcode({
                    render: 'image',
                    size: 100,
                    ecLevel: 'H',
                    minVersion: 3,
                    quiet: 1,
                    text: url_link,
                    fill: foreground_color,
                    background: background_color,
                    radius: .01 * parseInt(radius, 10),
                    mode: parseInt(qr_type, 10),
                    label: qr_font,
                    fontcolor: qr_font_color,
                    image: $("#image-buffers")[0],
                    mSize: .01 * parseInt(size, 10)
                });
            });
        </script>
    <?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\layouts\dash_qr_scripts.blade.php ENDPATH**/ ?>
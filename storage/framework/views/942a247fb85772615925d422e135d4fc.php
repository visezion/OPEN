<?php
    $admin_settings = getAdminAllSetting();
    $company_settings = getCompanyAllSetting();
    $favicon = isset($company_settings['favicon']) ? $company_settings['favicon'] : (isset($admin_settings['favicon']) ? $admin_settings['favicon'] : 'uploads/logo/favicon.png');
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(!empty($company_settings['site_rtl']) && $company_settings['site_rtl'] == 'on' ? 'rtl' : ''); ?>">

<head>
    <title><?php echo $__env->yieldContent('page-title'); ?> |
        <?php echo e(!empty($company_settings['title_text']) ? $company_settings['title_text'] : (!empty($admin_settings['title_text']) ? $admin_settings['title_text'] : 'WorkDo')); ?>

    </title>
    <meta name="title"
        content="<?php echo e(!empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash'); ?>">
    <meta name="keywords"
        content="<?php echo e(!empty($admin_settings['meta_keywords']) ? $admin_settings['meta_keywords'] : 'WorkDo Dash,SaaS solution,Multi-workspace'); ?>">
    <meta name="description"
        content="<?php echo e(!empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title"
        content="<?php echo e(!empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash'); ?>">
    <meta property="og:description"
        content="<?php echo e(!empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'); ?> ">
    <meta property="og:image"
        content="<?php echo e(get_file(!empty($admin_settings['meta_image']) ? (check_file($admin_settings['meta_image']) ? $admin_settings['meta_image'] : 'uploads/meta/meta_image.png') : 'uploads/meta/meta_image.png')); ?><?php echo e('?' . time()); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title"
        content="<?php echo e(!empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash'); ?>">
    <meta property="twitter:description"
        content="<?php echo e(!empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'); ?> ">
    <meta property="twitter:image"
        content="<?php echo e(get_file(!empty($admin_settings['meta_image']) ? (check_file($admin_settings['meta_image']) ? $admin_settings['meta_image'] : 'uploads/meta/meta_image.png') : 'uploads/meta/meta_image.png')); ?><?php echo e('?' . time()); ?>">

    <meta name="author" content="Workdo.io">

    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Favicon icon -->
    <link rel="icon"
        href="<?php echo e(check_file($favicon) ? get_file($favicon) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?' . time()); ?>"
        type="image/x-icon" />
    <?php echo $__env->yieldPushContent('head'); ?>
    <!-- for calender-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/main.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/datepicker-bs5.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/style.css')); ?>">
    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap-switch-button.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['site_rtl']) == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['cust_darklayout']) && $company_settings['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>"id="main-style-link">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo $__env->yieldPushContent('css'); ?>
</head>

<body class=<?php echo e(!empty($company_settings['color']) ? $company_settings['color'] : 'theme-1'); ?>>
    <!-- [ Pre-loader ] start -->
    <!-- [ Mobile header ] End -->



    <!-- [ Main Content ] start -->
    <div class="container">
        <div class="dash-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12 mt-5 mb-4">
                            <div class="d-block d-sm-flex align-items-center justify-content-between">
                                <div>

                                </div>
                                <div>
                                    <?php echo $__env->yieldContent('action-button'); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row"> -->
            <?php echo $__env->yieldContent('content'); ?>

            <!-- </div> -->

        </div>
    </div>

    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.form.js')); ?>"></script>

    <script src="<?php echo e(asset('js/letter.avatar.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dash.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/simple-datatables.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/flatpickr.min.js')); ?>"></script>

    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>

    <script src="<?php echo e(asset('js/chatify/autosize.js')); ?>"></script>
    <script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($admin_settings['enable_cookie']) && $admin_settings['enable_cookie'] == 'on'): ?>
        <?php echo $__env->make('layouts.cookie_consent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\layouts\contractheader.blade.php ENDPATH**/ ?>
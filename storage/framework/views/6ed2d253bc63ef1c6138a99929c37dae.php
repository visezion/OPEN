<?php
    $admin_settings = getAdminAllSetting();
    $company_settings = getCompanyAllSetting($ticket->created_by);
    $favicon = isset($company_settings['favicon']) ? $company_settings['favicon'] : (isset($admin_settings['favicon']) ? $admin_settings['favicon'] : 'uploads/logo/favicon.png');
    $rtl = isset($company_settings['site_rtl']) ? $company_settings['site_rtl'] : (isset($admin_settings['site_rtl']) ? $admin_settings['site_rtl'] : 'off');

?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(env('SITE_RTL') == 'on' ? 'rtl' : ''); ?>">

<head>

    <title><?php echo $__env->yieldContent('page-title'); ?> |
        <?php echo e(!empty($company_settings['title_text']) ? $company_settings['title_text'] : (!empty($admin_settings['title_text']) ? $admin_settings['title_text'] : 'WorkDo')); ?>

    </title>
    <meta name="title" content="<?php echo e(!empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash'); ?>">
    <meta name="keywords" content="<?php echo e(!empty($admin_settings['meta_keywords']) ? $admin_settings['meta_keywords'] : 'WorkDo Dash,SaaS solution,Multi-workspace'); ?>">
    <meta name="description" content="<?php echo e(!empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e(!empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash'); ?>">
    <meta property="og:description" content="<?php echo e(!empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'); ?> ">
    <meta property="og:image" content="<?php echo e(get_file( (!empty($admin_settings['meta_image'])) ? (check_file($admin_settings['meta_image'])) ?  $admin_settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  )); ?><?php echo e('?'.time()); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e(!empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash'); ?>">
    <meta property="twitter:description" content="<?php echo e(!empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'); ?> ">
    <meta property="twitter:image" content="<?php echo e(get_file( (!empty($admin_settings['meta_image'])) ? (check_file($admin_settings['meta_image'])) ?  $admin_settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  )); ?><?php echo e('?'.time()); ?>">

    <meta name="author" content="Workdo.io">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?php echo e(check_file($favicon) ? get_file($favicon) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?'.time()); ?>" type="image/x-icon" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <?php echo $__env->yieldPushContent('css'); ?>

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <!-- vendor css -->
    <?php if($rtl == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/custom-auth-rtl.css')); ?>" id="main-style-link">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/custom-auth.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <?php if((isset($company_settings['cust_darklayout']) ? $company_settings['cust_darklayout'] : 'off') == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>" id="main-style-link">
        <link rel="stylesheet" href="<?php echo e(asset('css/custom-auth-dark.css')); ?>" id="main-style-link">
    <?php endif; ?>

    <?php if( $rtl != 'on' && (isset($company_settings['cust_darklayout']) ? $company_settings['cust_darklayout'] : 'off') != 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">
    <!-- custom css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/custome.css')); ?>">

</head>

<body class="<?php echo e(!empty($company_settings['color']) ? $company_settings['color'] : 'theme-1'); ?>">
    <?php echo $__env->yieldContent('content'); ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"> </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/theme.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>

    <?php if($message = Session::get('success')): ?>
        <script>
            toastrs('Success', '<?php echo $message; ?>', 'success');
        </script>
    <?php endif; ?>
    <?php if($message = Session::get('error')): ?>
        <script>
            toastrs('Error', '<?php echo $message; ?>', 'error');
        </script>
    <?php endif; ?>
    <?php echo $__env->yieldPushContent('script'); ?>
    <?php if($admin_settings['enable_cookie'] == 'on'): ?>
    <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\helpdesk_ticket\master.blade.php ENDPATH**/ ?>
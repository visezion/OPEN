<?php
    $admin_settings = getAdminAllSetting();
    $superadmin_user = \App\Models\User::query()->select('id', 'active_workspace')->find(1);
    $superadmin_workspace = $superadmin_user?->active_workspace;

    $superadmin_color = \App\Models\Setting::query()
        ->where('created_by', 1)
        ->where('key', 'color')
        ->when(!is_null($superadmin_workspace), function ($query) use ($superadmin_workspace) {
            $query->where('workspace', $superadmin_workspace);
        })
        ->value('value');

    if (empty($superadmin_color)) {
        $superadmin_color = \App\Models\Setting::query()
            ->where('created_by', 1)
            ->where('key', 'color')
            ->orderByDesc('id')
            ->value('value');
    }

    $superadmin_color_flag = \App\Models\Setting::query()
        ->where('created_by', 1)
        ->where('key', 'color_flag')
        ->when(!is_null($superadmin_workspace), function ($query) use ($superadmin_workspace) {
            $query->where('workspace', $superadmin_workspace);
        })
        ->value('value');

    if (is_null($superadmin_color_flag)) {
        $superadmin_color_flag = \App\Models\Setting::query()
            ->where('created_by', 1)
            ->where('key', 'color_flag')
            ->orderByDesc('id')
            ->value('value');
    }

    $temp_lang = \App::getLocale('lang');
    if($temp_lang == 'ar' || $temp_lang == 'he'){
        $rtl = 'on';
    }
    else {
        $rtl = isset($admin_settings['site_rtl']) ? $admin_settings['site_rtl'] : 'off';
    }
    $color = !empty($superadmin_color) ? $superadmin_color : (!empty($admin_settings['color']) ? $admin_settings['color'] : 'theme-1');

    $is_superadmin_custom_color = in_array(strtolower((string) $superadmin_color_flag), ['true', '1', 'on'], true);

    if($is_superadmin_custom_color)
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

    // Match Chatify theme tokens to actual branding hex values.
    $theme_palette = [
        'theme-1' => '#0CAF60',
        'theme-2' => '#75C251',
        'theme-3' => '#584ED2',
        'theme-4' => '#145388',
        'theme-5' => '#B9406B',
        'theme-6' => '#008ECC',
        'theme-7' => '#922C88',
        'theme-8' => '#C0A145',
        'theme-9' => '#48494B',
        'theme-10' => '#0C7785',
    ];

    $normalized_color = strtolower(trim((string) $color));

    // Use value from settings table column: `color` (theme token or hex)
    $superadmin_primary = 'var(--bs-primary)';
    if (isset($theme_palette[$normalized_color])) {
        $superadmin_primary = $theme_palette[$normalized_color];
    } else {
        $db_color = trim((string) $color);
        if ($db_color !== '') {
            if (strpos($db_color, '#') !== 0) {
                $db_color = '#' . $db_color;
            }
            if (preg_match('/^#[0-9a-fA-F]{3,8}$/', $db_color)) {
                $superadmin_primary = $db_color;
            }
        }
    }

    $login_bg_theme = isset($theme_palette[$normalized_color]) ? $normalized_color : 'theme-1';
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($rtl == 'on'?'rtl':''); ?>">

<head>

    <title><?php echo $__env->yieldContent('page-title'); ?> | <?php echo e(!empty($admin_settings['title_text']) ? $admin_settings['title_text'] : config('app.name', 'WorkDo')); ?></title>

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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?php echo e((!empty($admin_settings['favicon']) && check_file($admin_settings['favicon'])) ? get_file($admin_settings['favicon']) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?'.time()); ?>" type="image/x-icon" />
     <!-- CSS Libraries -->
     <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">

      <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">
    <!-- custom css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/custome.css')); ?>">
    <style>
        :root {
            --color-customColor: <?= $color ?>;
            --superadmin-primary: <?php echo e($superadmin_primary); ?>;
        }
    </style>

    <link rel="stylesheet" href="<?php echo e(asset('css/custom-color.css')); ?>">

    <?php if( $rtl == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/custom-auth-rtl.css')); ?>" id="main-style-link">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/custom-auth.css')); ?>" id="main-style-link">
    <?php endif; ?>

    <?php if((isset($admin_settings['cust_darklayout']) ? $admin_settings['cust_darklayout'] : 'off') == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>" id="main-style-link">
        <link rel="stylesheet" href="<?php echo e(asset('css/custom-auth-dark.css')); ?>" id="main-style-link">
    <?php endif; ?>

    <?php if( $rtl != 'on' && (isset($admin_settings['cust_darklayout']) ? $admin_settings['cust_darklayout'] : 'off') != 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/ui-clean.css')); ?>">

    <style>
        .navbar-brand .auth-navbar-brand
        {
            max-height: 38px !important;
        }
    </style>
</head>
<body class="<?php echo e($themeColor); ?><?php echo e(request()->routeIs('login', 'register', 'password.request', 'password.reset') ? ' faith-login-page dms-faith-login' : ''); ?> ui-border-clean">
    <div class="custom-login">
        <div class="login-bg-img">
            
            <img src="<?php echo e(!$is_superadmin_custom_color ? asset('images/' . $login_bg_theme . '.svg') : asset('images/theme-1.svg')); ?>" class="login-bg-1">
            <img src="<?php echo e(asset('images/common.svg')); ?>" class="login-bg-2">
        </div>
        <div class="bg-login bg-primary"></div>
        <div class="custom-login-inner">
            <header class="dash-header">
                <nav class="navbar navbar-expand-md default">
                    <div class="container">
                        <div class="navbar-brand">
                            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                                <img src="<?php echo e(get_file(sidebar_logo())); ?><?php echo e('?'.time()); ?>" alt="<?php echo e(config('app.name', 'WorkDo')); ?>" class="navbar-brand-img auth-navbar-brand">
                            </a>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarlogin">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarlogin">
                            <ul class="navbar-nav align-items-center ms-auto mb-lg-0">

                                <?php echo $__env->yieldPushContent('custom_page_links'); ?>
                                <?php echo $__env->yieldContent('language-bar'); ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <main class="custom-wrapper">
                <div class="custom-row">
                    <div class="card">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </main>
            <footer>
                <div class="auth-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <span>
                                    <?php if(!empty($admin_settings['footer_text'])): ?> <?php echo e($admin_settings['footer_text']); ?> <?php else: ?><?php echo e(__('Copyright')); ?> &copy; <?php echo e(config('app.name', 'WorkDo')); ?><?php endif; ?><?php echo e(date('Y')); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <?php if((isset($admin_settings['enable_cookie']) ? $admin_settings['enable_cookie'] : 'off') == 'on'): ?>
        <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php echo $__env->yieldPushContent('custom-scripts'); ?>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<?php echo $__env->yieldPushContent('script'); ?>
<?php if((isset($admin_settings['cust_darklayout']) ? $admin_settings['cust_darklayout'] : 'off') == 'on'): ?>
<script>
       document.addEventListener('DOMContentLoaded', (event) => {
       const recaptcha = document.querySelector('.g-recaptcha');
       recaptcha.setAttribute("data-theme", "dark");
       });
</script>
<?php endif; ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views/layouts/auth.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="en">
<?php
    $admin_settings = getAdminAllSetting();
    $brand_name = !empty($admin_settings['title_text']) ? $admin_settings['title_text'] : 'Platform';
    $brand_name = preg_replace('/\b(workdo|dash)\b/i', '', (string) $brand_name);
    $brand_name = trim(preg_replace('/\s+/', ' ', (string) $brand_name));
    if ($brand_name === '') {
        $brand_name = 'Platform';
    }

    $default_meta_title = $brand_name;
    $default_meta_keywords = 'ministry platform,church workspace,faith operations';
    $default_meta_description = 'Faith-aligned platform for church administration, ministry teams, and accountable service workflows.';

    $meta_title = trim((string) ($admin_settings['meta_title'] ?? ''));
    if ($meta_title === '' || preg_match('/workdo|dash/i', $meta_title)) {
        $meta_title = $default_meta_title;
    }

    $meta_keywords = trim((string) ($admin_settings['meta_keywords'] ?? ''));
    if ($meta_keywords === '' || preg_match('/workdo|dash/i', $meta_keywords)) {
        $meta_keywords = $default_meta_keywords;
    }

    $meta_description = trim((string) ($admin_settings['meta_description'] ?? ''));
    if ($meta_description === '' || preg_match('/workdo|dash/i', $meta_description)) {
        $meta_description = $default_meta_description;
    }
?>
<head>

    <title><?php echo $__env->yieldContent('page-title'); ?> | <?php echo e($brand_name); ?></title>

    <meta name="title" content="<?php echo e($meta_title); ?>">
    <meta name="keywords" content="<?php echo e($meta_keywords); ?>">
    <meta name="description" content="<?php echo e($meta_description); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($meta_title); ?>">
    <meta property="og:description" content="<?php echo e($meta_description); ?> ">
    <meta property="og:image" content="<?php echo e(get_file( (!empty($admin_settings['meta_image'])) ? (check_file($admin_settings['meta_image'])) ?  $admin_settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  )); ?><?php echo e('?'.time()); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($meta_title); ?>">
    <meta property="twitter:description" content="<?php echo e($meta_description); ?> ">
    <meta property="twitter:image" content="<?php echo e(get_file( (!empty($admin_settings['meta_image'])) ? (check_file($admin_settings['meta_image'])) ?  $admin_settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  )); ?><?php echo e('?'.time()); ?>">

    <meta name="author" content="<?php echo e($brand_name); ?>">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <link rel="icon" href="<?php echo e((!empty($admin_settings['favicon']) && check_file($admin_settings['favicon'])) ? get_file($admin_settings['favicon']) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?'.time()); ?>" type="image/x-icon" />


    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">


    <?php if($admin_settings['site_rtl'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('market_assets/css/main-style-rtl.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('market_assets/css/responsive-rtl.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('market_assets/css/main-style.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('market_assets/css/responsive.css')); ?>">
    <?php endif; ?>

    <?php if($admin_settings['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('market_assets/css/main-style-dark.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('market_assets/css/magnific-popup.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/ui-clean.css')); ?>">
    <style>
        .market-brand-text {
            color: #19273d;
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .site-footer .market-brand-text {
            color: #ffffff;
            font-size: 1rem;
            letter-spacing: 0.06em;
        }
        .site-footer.footer-refined {
            margin-top: 52px;
            padding: 56px 0 26px;
            background: #ffffff;
            color: #1b2b48;
            border-top: 1px solid rgba(25, 39, 61, 0.14);
        }
        .site-footer.footer-refined .market-brand-text {
            color: #16284a;
            font-size: 1.05rem;
            letter-spacing: 0.08em;
        }
        .footer-refined .footer-main {
            display: flex;
            gap: 48px;
            align-items: flex-start;
            justify-content: space-between;
        }
        .footer-refined .footer-brand-block {
            max-width: 420px;
        }
        .footer-refined .footer-tagline {
            margin: 16px 0 0;
            color: #5a6b88;
            line-height: 1.7;
            font-weight: 500;
        }
        .footer-refined .footer-quick-actions {
            margin-top: 24px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .footer-refined .footer-btn {
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            border-radius: 10px;
            border: 1px solid transparent;
            font-weight: 700;
            font-size: 14px;
            line-height: 1;
            transition: all .2s ease-in-out;
        }
        .footer-refined .footer-btn-primary {
            background: var(--theme-color);
            border-color: var(--theme-color);
            color: #ffffff;
        }
        .footer-refined .footer-btn-primary:hover {
            filter: brightness(0.94);
        }
        .footer-refined .footer-btn-secondary {
            background: #ffffff;
            border-color: rgba(22, 40, 74, 0.2);
            color: #1b2b48;
        }
        .footer-refined .footer-btn-secondary:hover {
            border-color: var(--theme-color);
            color: var(--theme-color);
        }
        .footer-refined .footer-nav-grid {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(3, minmax(145px, 1fr));
            gap: 24px;
        }
        .footer-refined .footer-nav-group h4 {
            margin: 0 0 14px;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #20345d;
        }
        .footer-refined .footer-nav-group ul li:not(:last-child) {
            margin-bottom: 10px;
        }
        .footer-refined .footer-nav-group ul li a {
            color: #536584;
            font-weight: 600;
        }
        .footer-refined .footer-nav-group ul li a:hover {
            color: var(--theme-color);
        }
        .footer-refined .footer-bottom {
            margin-top: 34px;
            padding-top: 18px;
            border-top: 1px solid rgba(25, 39, 61, 0.14);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
        }
        .footer-refined .footer-bottom p {
            margin: 0;
            color: #60718d;
            font-weight: 600;
        }
        .footer-refined .footer-meta-links {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }
        .footer-refined .footer-meta-links a {
            color: #465a7f;
            font-weight: 700;
            font-size: 14px;
        }
        .footer-refined .footer-meta-links a:hover {
            color: var(--theme-color);
        }
        @media (max-width: 991px) {
            .site-footer.footer-refined {
                margin-top: 34px;
                padding: 44px 0 24px;
            }
            .footer-refined .footer-main {
                flex-direction: column;
                gap: 30px;
            }
            .footer-refined .footer-brand-block {
                max-width: 100%;
            }
            .footer-refined .footer-nav-grid {
                width: 100%;
                grid-template-columns: repeat(2, minmax(150px, 1fr));
                gap: 20px;
            }
        }
        @media (max-width: 575px) {
            .site-footer.footer-refined {
                padding: 36px 0 20px;
            }
            .footer-refined .footer-nav-grid {
                grid-template-columns: 1fr;
            }
            .footer-refined .footer-quick-actions {
                width: 100%;
            }
            .footer-refined .footer-btn {
                flex: 1;
                min-width: 150px;
            }
            .footer-refined .footer-bottom {
                margin-top: 28px;
                padding-top: 16px;
            }
        }
    </style>
</head>

<body class="<?php echo e(!empty($admin_settings['color'])?$admin_settings['color']:'theme-1'); ?> ui-border-clean" >
    <!-- header start here -->
    <header class="site-header header-style-one">
        <div class="main-navigationbar">
            <div class="container">
                <div class="navigationbar-row d-flex align-items-center justify-content-between">
                    <div class="logo-col">
                        <a href="<?php echo e(route('start')); ?>">
                            <span class="market-brand-text"><?php echo e($brand_name); ?></span>
                        </a>
                    </div>
                    <div class="menu-items-col">
                        <ul class="main-nav">
                            <li class="menu-lnk">
                                <a href="<?php echo e(url('/')); ?>"><?php echo e(__('Home')); ?></a>
                            </li>
                            <li class="menu-lnk">
                                <a href="<?php echo e(route('apps.software')); ?>"><?php echo e(__('Ministry Add-ons')); ?></a>
                            </li>
                            <li class="menu-lnk">
                                <a href="<?php echo e(route('apps.pricing')); ?>"><?php echo e(__('Pricing')); ?></a>
                            </li>
                            <li class="menu-lnk lnk-btn">
                                <a href="<?php echo e((Auth::check()) ? route('home') :route('login')); ?>"><?php echo e((Auth::check()) ? __('Home') :__('Login')); ?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <g clip-path="url(#clip0_14_726)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.88967 10.9856C6.96087 11.2611 7.75238 12.233 7.75238 13.3897C7.75238 14.7607 6.64043 15.8721 5.26877 15.8721C3.89711 15.8721 2.78516 14.7607 2.78516 13.3897C2.78516 12.233 3.57667 11.2611 4.64787 10.9856V10.5959C4.64787 8.7099 6.1768 7.18097 8.06283 7.18097C9.26304 7.18097 10.236 6.20801 10.236 5.00781V3.09158L8.81233 4.51524C8.56985 4.75772 8.17672 4.75772 7.93424 4.51524C7.69176 4.27276 7.69176 3.87963 7.93424 3.63715L10.4179 1.15354C10.6603 0.91106 11.0535 0.91106 11.2959 1.15354L13.7796 3.63715C14.022 3.87962 14.022 4.27276 13.7796 4.51524C13.5371 4.75771 13.1439 4.75772 12.9015 4.51524L11.4778 3.09158V5.00781C11.4778 6.89384 9.94887 8.42278 8.06283 8.42278C6.86263 8.42278 5.88967 9.39573 5.88967 10.5959V10.9856ZM6.51058 13.3897C6.51058 14.0743 5.95517 14.6303 5.26877 14.6303C4.58237 14.6303 4.02696 14.0743 4.02696 13.3897C4.02696 12.7052 4.58237 12.1492 5.26877 12.1492C5.95517 12.1492 6.51058 12.7052 6.51058 13.3897Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_14_726">
                                                <rect width="14.9017" height="14.9017" fill="white"
                                                    transform="translate(0.921875 0.97168)" />
                                            </clipPath>
                                        </defs>
                                    </svg></a>
                            </li>
                        </ul>
                        <div class="mobile-menu mobile-only">
                            <button class="mobile-menu-button">
                                <div class="one"></div>
                                <div class="two"></div>
                                <div class="three"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- header end here -->

    <!-- wrapper start -->
         <?php echo $__env->yieldContent('content'); ?>
    <!-- wrapper end -->

    <!-- Footer start here -->
    <footer class="site-footer footer-refined">
        <div class="container">
            <div class="footer-main">
                <div class="footer-brand-block">
                    <a href="<?php echo e(route('start')); ?>">
                        <span class="market-brand-text"><?php echo e($brand_name); ?></span>
                    </a>
                    <p class="footer-tagline"><?php echo e(__('Free and open source workspace for organized ministry teams, operations, and daily service coordination.')); ?></p>
                    <div class="footer-quick-actions">
                        <a href="<?php echo e(route('apps.software')); ?>" class="footer-btn footer-btn-secondary"><?php echo e(__('Explore Ministry Add-ons')); ?></a>
                        <a href="<?php echo e(route('apps.pricing')); ?>" class="footer-btn footer-btn-primary"><?php echo e(__('View Pricing')); ?></a>
                    </div>
                </div>
                <div class="footer-nav-grid">
                    <div class="footer-nav-group">
                        <h4><?php echo e(__('Platform')); ?></h4>
                        <ul>
                            <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Home')); ?></a></li>
                            <li><a href="<?php echo e(route('apps.software')); ?>"><?php echo e(__('Ministry Add-ons')); ?></a></li>
                            <li><a href="<?php echo e(route('apps.pricing')); ?>"><?php echo e(__('Pricing')); ?></a></li>
                        </ul>
                    </div>
                    <div class="footer-nav-group">
                        <h4><?php echo e(__('Account')); ?></h4>
                        <ul>
                            <li><a href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a></li>
                            <?php if(Route::has('register')): ?>
                                <li><a href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo e(Auth::check() ? route('home') : route('login')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                        </ul>
                    </div>
                    <div class="footer-nav-group">
                        <h4><?php echo e(__('Support')); ?></h4>
                        <ul>
                            <li><a href="<?php echo e(route('apps.software')); ?>"><?php echo e(__('Module Library')); ?></a></li>
                            <li><a href="<?php echo e(route('apps.pricing')); ?>"><?php echo e(__('Plans')); ?></a></li>
                            <li><a href="<?php echo e(route('start')); ?>"><?php echo e(__('Back to Top')); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p><?php echo e(__('Copyright')); ?> <?php echo e(date('Y')); ?> <?php echo e($brand_name); ?>. <?php echo e(__('Built for reliable daily operations.')); ?></p>
                <div class="footer-meta-links">
                    <a href="<?php echo e(route('apps.software')); ?>"><?php echo e(__('Ministry Add-on Library')); ?></a>
                    <a href="<?php echo e(route('apps.pricing')); ?>"><?php echo e(__('Pricing & Plans')); ?></a>
                    <a href="<?php echo e(route('start')); ?>"><?php echo e(__('Home')); ?></a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer end here -->
    <!-- Mobile start here -->
    <div class="mobile-menu-wrapper">
        <div class="menu-close-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18">
                <path fill="#24272a"
                    d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z">
                </path>
            </svg>
        </div>
        <div class="mobile-menu-bar">
            <ul>
                <li class="mobile-item">
                    <a href="<?php echo e(url('/')); ?>"><?php echo e(__('Home')); ?></a>
                </li>
                <li class="mobile-item">
                    <a href="<?php echo e(route('apps.software')); ?>"><?php echo e(__('Ministry Add-ons')); ?></a>
                </li>
                <li class="mobile-item">
                    <a href="<?php echo e(route('apps.pricing')); ?>"><?php echo e(__('Pricing')); ?></a>
                </li>
                <li class="mobile-item">
                    <a href="<?php echo e((Auth::check()) ? route('home') :route('login')); ?>"><?php echo e((Auth::check()) ? __('Home') :__('Login')); ?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 16 16" fill="none">
                        <g clip-path="url(#clip0_14_726)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.88967 10.9856C6.96087 11.2611 7.75238 12.233 7.75238 13.3897C7.75238 14.7607 6.64043 15.8721 5.26877 15.8721C3.89711 15.8721 2.78516 14.7607 2.78516 13.3897C2.78516 12.233 3.57667 11.2611 4.64787 10.9856V10.5959C4.64787 8.7099 6.1768 7.18097 8.06283 7.18097C9.26304 7.18097 10.236 6.20801 10.236 5.00781V3.09158L8.81233 4.51524C8.56985 4.75772 8.17672 4.75772 7.93424 4.51524C7.69176 4.27276 7.69176 3.87963 7.93424 3.63715L10.4179 1.15354C10.6603 0.91106 11.0535 0.91106 11.2959 1.15354L13.7796 3.63715C14.022 3.87962 14.022 4.27276 13.7796 4.51524C13.5371 4.75771 13.1439 4.75772 12.9015 4.51524L11.4778 3.09158V5.00781C11.4778 6.89384 9.94887 8.42278 8.06283 8.42278C6.86263 8.42278 5.88967 9.39573 5.88967 10.5959V10.9856ZM6.51058 13.3897C6.51058 14.0743 5.95517 14.6303 5.26877 14.6303C4.58237 14.6303 4.02696 14.0743 4.02696 13.3897C4.02696 12.7052 4.58237 12.1492 5.26877 12.1492C5.95517 12.1492 6.51058 12.7052 6.51058 13.3897Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_14_726">
                                <rect width="14.9017" height="14.9017" fill="white"
                                    transform="translate(0.921875 0.97168)" />
                            </clipPath>
                        </defs>
                    </svg></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Mobile start here -->
    <div class="overlay"></div>

    <!--scripts start here-->
    <script src="<?php echo e(asset('market_assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('market_assets/js/slick.min.js')); ?>" defer="defer"></script>
    <?php if($admin_settings['site_rtl'] == 'on'): ?>
        <script src="<?php echo e(asset('market_assets/js/custom-rtl.js')); ?>" defer="defer"></script>
    <?php else: ?>
        <script src="<?php echo e(asset('market_assets/js/custom.js')); ?>" defer="defer"></script>
    <?php endif; ?>
    <?php if($admin_settings['enable_cookie'] == 'on'): ?>
        <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <script src="<?php echo e(asset('market_assets/js/magnific-popup.min.js')); ?>" defer="defer"></script>
    <script>
        $(document).ready(function(){
            $('.img-zoom').magnificPopup({
                disableOn: 300,
                type: 'image',
                mainClass: 'mfp-fade',
                removalDelay: 160
            });
    });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <!--scripts end here-->
</body>

</html>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views/marketplace/marketplace.blade.php ENDPATH**/ ?>
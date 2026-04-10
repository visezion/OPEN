<?php
    $admin_settings = getAdminAllSetting();

    $company_settings = getCompanyAllSetting(creatorId());

    $color = !empty($company_settings['color']) ? $company_settings['color'] : 'theme-1';
      if (isset($company_settings['color_flag']) && $company_settings['color_flag'] == 'true') {
          $themeColor = 'custom-color';
      } else {
          $themeColor = $color;
      }

      $is_dashboard_route = request()->routeIs('dashboard');
      $is_superadmin_user = Auth::check() && Auth::user()->type === 'super admin';
      $is_superadmin_dashboard = $is_superadmin_user && $is_dashboard_route;
      $current_route_action = optional(request()->route())->getActionName();
      $is_churchly_route = is_string($current_route_action) && str_contains($current_route_action, 'Workdo\\Churchly\\');
      $is_churchmeet_route = is_string($current_route_action) && str_contains($current_route_action, 'Workdo\\ChurchMeet\\');
      $body_classes = trim(
          (isset($themeColor) ? $themeColor : 'theme-1')
          . ($is_superadmin_user ? ' superadmin-page' : '')
          . ($is_superadmin_dashboard ? ' superadmin-dashboard-page' : '')
          . ($is_churchly_route ? ' churchly-module-page' : '')
          . ($is_churchmeet_route ? ' churchmeet-module-page' : '')
      );
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(isset($company_settings['site_rtl']) && $company_settings['site_rtl'] == 'on' ? 'rtl' : ''); ?>">
<?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body class="<?php echo e($body_classes); ?> ui-border-clean">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill">

            </div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ auth-signup ] end -->
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <section class="dash-container">
        <div class="dash-content">
            <!-- [ breadcrumb ] start -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$is_dashboard_route): ?>
                <div class="page-header">
                    <div class="page-block">
                        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
                            <div>
                                <div class="page-header-title">
                                    <h4 class="mb-2"><?php echo $__env->yieldContent('page-title'); ?></h4>
                                </div>
                                <ul class="breadcrumb">
                                    <?php
                                        if (isset(app()->view->getSections()['page-breadcrumb'])) {
                                            $breadcrumb = explode(',', app()->view->getSections()['page-breadcrumb']);
                                        } else {
                                            $breadcrumb = [];
                                        }
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($breadcrumb)): ?>
                                        <li class="breadcrumb-item"><a
                                                href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="breadcrumb-item <?php echo e($loop->last ? 'active' : ''); ?>">
                                                <?php echo e($item); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </ul>
                                
                            </div>
                            <div>
                                <?php echo $__env->yieldContent('page-action'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </section>
<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views/layouts/main.blade.php ENDPATH**/ ?>
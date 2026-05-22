<?php
    $is_superadmin_sidebar = Auth::check() && Auth::user()->type === 'super admin';
?>
<nav class="dash-sidebar light-sidebar <?php echo e(empty($company_settings['site_transparent']) || $company_settings['site_transparent'] == 'on' ? 'transprent-bg' : ''); ?> <?php echo e($is_superadmin_sidebar ? 'superadmin-sidebar' : ''); ?>">
    <div class="navbar-wrapper">
        <div class="m-header main-logo">
            <a href="<?php echo e(route('home')); ?>" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="<?php echo e(get_file(sidebar_logo())); ?><?php echo e('?' . time()); ?>" alt="" class="logo logo-lg" />
                
            </a>
        </div>
        
        <div class="px-3 sidebar-search">
            <div class="search-container">
                <i class="ti ti-search search-icon"></i>
                <input type="text"
                    class="form-control form-control-sm sidebar-search-input search-input"
                    placeholder="<?php echo e(__('Search...')); ?>" aria-label="Search" />
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['category_wise_sidemenu']) && $company_settings['category_wise_sidemenu'] == 'on'): ?>
          <div class="tab-container">
            <div class="tab-sidemenu">
              <ul class="dash-tab-link nav flex-column" role="tablist" id="dash-layout-submenus">
              </ul>
            </div>
            <div class="tab-link">
              <div class="navbar-content">



                <div class="tab-content" id="dash-layout-tab">
                </div>
                <ul class="dash-navbar">
                    <?php echo getMenu(); ?>

                    <?php echo $__env->yieldPushContent('custom_side_menu'); ?>
                </ul>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="navbar-content">
              <ul class="dash-navbar">
                  <?php echo getMenu(); ?>

                  <?php echo $__env->yieldPushContent('custom_side_menu'); ?>
              </ul>
          </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\partials\sidebar.blade.php ENDPATH**/ ?>
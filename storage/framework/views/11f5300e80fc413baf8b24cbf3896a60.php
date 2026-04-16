 <!--Brand Settings-->
 <div id="site-settings" class="">
     <?php echo e(Form::open(['route' => ['super.admin.settings.save'], 'enctype' => 'multipart/form-data', 'id' => 'setting-form'])); ?>

     <?php echo method_field('post'); ?>
     <div class="card">
         <div class="card-header p-3">
             <h5><?php echo e(__('Brand Settings')); ?></h5>
         </div>
         <div class="card-body px-3">
             <div class="row row-gap">
                 <div class="col-md-4 col-12">
                     <div class="card">
                         <div class="card-header p-3">
                             <h5 class="small-title"><?php echo e(__('Logo Dark')); ?></h5>
                         </div>
                         <div class="card-body setting-card setting-logo-box p-3">
                             <div class="logo-content img-fluid logo-set-bg  text-center">
                                 <?php
                                     $logo_dark = isset($settings['logo_dark'])
                                         ? (check_file($settings['logo_dark'])
                                             ? $settings['logo_dark']
                                             : 'uploads/logo/logo_dark.png')
                                         : 'uploads/logo/logo_dark.png';
                                 ?>
                                 <img alt="image" src="<?php echo e(get_file($logo_dark)); ?><?php echo e('?' . time()); ?>"
                                     class="img_setting" id="pre_default_logo">
                             </div>
                             <div class="choose-files text-center  mt-3">
                                 <label for="logo_dark">
                                     <div class=" bg-primary "> <i
                                             class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?></div>
                                     <input type="file" class="form-control file" name="logo_dark" id="logo_dark"
                                         data-filename="logo_dark"
                                         onchange="document.getElementById('pre_default_logo').src = window.URL.createObjectURL(this.files[0])">
                                 </label>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-4 col-12">
                     <div class="card">
                         <div class="card-header p-3">
                             <h5 class="small-title"><?php echo e(__('Logo Light')); ?></h5>
                         </div>
                         <div class="card-body setting-card setting-logo-box p-3">
                             <div class="logo-content img-fluid logo-set-bg dark-logo text-center">
                                 <?php
                                     $logo_light = isset($settings['logo_light'])
                                         ? (check_file($settings['logo_light'])
                                             ? $settings['logo_light']
                                             : 'uploads/logo/logo_light.png')
                                         : 'uploads/logo/logo_light.png';
                                 ?>
                                 <img alt="image" src="<?php echo e(get_file($logo_light)); ?><?php echo e('?' . time()); ?>"
                                     class="img_setting" id="landing_page_logo">
                             </div>
                             <div class="choose-files text-center mt-3">
                                 <label for="logo_light">
                                     <div class=" bg-primary "> <i
                                             class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?></div>
                                     <input type="file" class="form-control file" name="logo_light" id="logo_light"
                                         data-filename="logo_light"
                                         onchange="document.getElementById('landing_page_logo').src = window.URL.createObjectURL(this.files[0])">

                                 </label>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-4 col-12">
                     <div class="card">
                         <div class="card-header p-3">
                             <h5 class="small-title"><?php echo e(__('Favicon')); ?></h5>
                         </div>
                         <div class="card-body setting-card setting-logo-box p-3">
                             <div class="logo-content img-fluid logo-set-bg text-center">
                                 <?php
                                     $favicon = isset($settings['favicon'])
                                         ? (check_file($settings['favicon'])
                                             ? $settings['favicon']
                                             : 'uploads/logo/favicon.png')
                                         : 'uploads/logo/favicon.png';
                                 ?>
                                 <img src="<?php echo e(get_file($favicon)); ?><?php echo e('?' . time()); ?>" class="setting-img"
                                     width="40px" id="img_favicon" />
                             </div>
                             <div class="choose-files text-center mt-3">
                                 <label for="favicon">
                                     <div class=" bg-primary "> <i
                                             class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?></div>
                                     <input type="file" class="form-control file" name="favicon" id="favicon"
                                         data-filename="favicon"
                                         onchange="document.getElementById('img_favicon').src = window.URL.createObjectURL(this.files[0])">
                                 </label>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="row mt-4 row-gap setting-box">
                 <div class="col-sm-6 col-12">
                     <div class="form-group d-flex align-items-center gap-2 mb-0">
                         <label for="title_text" class="form-label mb-0"><?php echo e(__('Title Text')); ?></label>
                         <?php echo e(Form::text('title_text', !empty($settings['title_text']) ? $settings['title_text'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Title Text')])); ?>

                     </div>
                 </div>
                 <div class="col-sm-6 col-12">
                     <div class="form-group d-flex align-items-center gap-2 mb-0">
                         <label for="footer_text" class="form-label mb-0"><?php echo e(__('Footer Text')); ?></label>
                         <?php echo e(Form::text('footer_text', !empty($settings['footer_text']) ? $settings['footer_text'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Footer Text')])); ?>

                     </div>
                 </div>
             </div>
         </div>

         <div class="card-body border-1 border-top  px-3">
             <div class="setting-card setting-logo-box">
                 <h4 class="small-title h5 mb-3"><?php echo e(__('Theme Customizer')); ?></h4>
                 <div class="row row-gap">
                     <div class="col-xxl-3 col-md-4 col-sm-6 col-12">
                         <div class="card h-100 mb-0">
                             <div class="card-header p-2">
                                 <h6 class="d-flex align-items-center">
                                     <i class="ti ti-credit-card me-2 h5"></i><?php echo e(__('Primary color settings')); ?>

                                 </h6>
                             </div>
                             <div class="card-body p-2">
                                 <div class="color-wrp mt-0">
                                     <div class="theme-color themes-color">
                                         <a href="#!"
                                             class="themes-color-change rounded-circle <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-1' ? 'active_color' : ''); ?>"
                                             data-value="theme-1"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-1"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-1' ? 'checked' : ''); ?>>
                                         <a href="#!"
                                             class="themes-color-change rounded-circle <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-2' ? 'active_color' : ''); ?>"
                                             data-value="theme-2"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-2"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-2' ? 'checked' : ''); ?>>
                                         <a href="#!"
                                             class="themes-color-change rounded-circle <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-3' ? 'active_color' : ''); ?>"
                                             data-value="theme-3"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-3"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-3' ? 'checked' : ''); ?>>

                                         <a href="#!"
                                             class="themes-color-change rounded-circle <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-4' ? 'active_color' : ''); ?>"
                                             data-value="theme-4"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-4"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-4' ? 'checked' : ''); ?>>

                                         <a href="#!"
                                             class="themes-color-change rounded-circle <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-5' ? 'active_color' : ''); ?>"
                                             data-value="theme-5"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-5"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-5' ? 'checked' : ''); ?>>

                                         <a href="#!"
                                             class="themes-color-change rounded-circle <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-6' ? 'active_color' : ''); ?>"
                                             data-value="theme-6"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-6"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-6' ? 'checked' : ''); ?>>

                                         <a href="#!"
                                             class="themes-color-change rounded-circle <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-7' ? 'active_color' : ''); ?>"
                                             data-value="theme-7"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-7"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-7' ? 'checked' : ''); ?>>

                                         <a href="#!"
                                             class="themes-color-change rounded-circle <?php echo e(isset($settings['color']) && $settings['color'] == 'theme-8' ? 'active_color' : ''); ?>"
                                             data-value="theme-8"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-8"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-8' ? 'checked' : ''); ?>>

                                         <a href="#!"
                                             class="themes-color-change rounded-circle<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-9' ? 'active_color' : ''); ?>"
                                             data-value="theme-9"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-9"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-9' ? 'checked' : ''); ?>>

                                         <a href="#!"
                                             class="themes-color-change rounded-circle<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-10' ? 'active_color' : ''); ?>"
                                             data-value="theme-10"></a>
                                         <input type="radio" class="theme_color d-none" name="color"
                                             value="theme-10"<?php echo e(isset($settings['color']) && $settings['color'] == 'theme-10' ? 'checked' : ''); ?>>
                                         <div class="color-picker-wrp ">
                                             <input type="color"
                                                 value="<?php echo e(isset($settings['color']) ? $settings['color'] : ''); ?>"
                                                 class="colorPicker rounded-circle <?php echo e(isset($settings['color_flag']) && $settings['color_flag'] == 'true' ? 'active_color' : ''); ?>"
                                                 name="custom_color" id="color-picker">
                                             <input type='hidden' name="color_flag"
                                                 value=<?php echo e(isset($settings['color_flag']) && $settings['color_flag'] == 'true' ? 'true' : 'false'); ?>>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-xxl-3 col-md-4 col-sm-6 col-12">
                         <div class="card h-100 mb-0">
                             <div class="card-header p-2">
                                 <h6 class="d-flex align-items-center">
                                     <i class="ti ti-layout-sidebar me-2 h5"></i> <?php echo e(__('Sidebar settings')); ?>

                                 </h6>
                             </div>
                             <div class="card-body p-2">
                                 <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                                     <label class="form-check-label f-w-600"
                                         for="site_transparent"><?php echo e(__('Transparent layout')); ?></label>
                                     <input type="checkbox" class="form-check-input ms-0" id="site_transparent"
                                         name="site_transparent"
                                         <?php echo e(isset($settings['site_transparent']) && $settings['site_transparent'] == 'on' ? 'checked' : ''); ?> />

                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-xxl-3 col-md-4 col-sm-6 col-12">
                         <div class="card h-100 mb-0">
                             <div class="card-header p-2">
                                 <h6 class="d-flex align-items-center">
                                     <i class="ti ti-sun me-2 h5"></i><?php echo e(__('Layout settings')); ?>

                                 </h6>
                             </div>
                             <div class="card-body p-2">
                                 <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                                     <label class="form-check-label f-w-600"
                                         for="cust-darklayout"><?php echo e(__('Dark Layout')); ?></label>

                                     <input type="checkbox" class="form-check-input ms-0" id="cust-darklayout"
                                         name="cust_darklayout"
                                         <?php echo e(isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on' ? 'checked' : ''); ?> />

                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-xxl-3 col-md-4 col-sm-6 col-12">
                         <div class="card h-100 mb-0">
                             <div class="card-header p-2">
                                 <h6 class="d-flex align-items-center">
                                     <i class="ti ti-align-right me-2 h5"></i><?php echo e(__('Enable RTL')); ?>

                                 </h6>
                             </div>
                             <div class="card-body p-2">
                                 <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                                     <label class="form-check-label f-w-600"
                                         for="site_rtl"><?php echo e(__('RTL Layout')); ?></label>
                                     <input type="checkbox" class="form-check-input ms-0" id="site_rtl"
                                         name="site_rtl"
                                         <?php echo e(isset($settings['site_rtl']) && $settings['site_rtl'] == 'on' ? 'checked' : ''); ?> />

                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-xxl-3 col-md-4 col-sm-6 col-12">
                         <div class="card h-100 mb-0">
                             <div class="card-header p-2">
                                 <h6 class="d-flex align-items-center">
                                     <i class="ti ti-align-right me-2 h5"></i><?php echo e(__('Category Wise Sidemenu')); ?>

                                 </h6>
                             </div>
                             <div class="card-body p-2">
                                 <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                                     <label class="form-check-label f-w-600"
                                         for="category_wise_sidemenu"><?php echo e(__('Category Wise Sidemenu')); ?></label>
                                     <input type="checkbox" class="form-check-input ms-0" id="category_wise_sidemenu"
                                         name="category_wise_sidemenu"
                                         <?php echo e(isset($settings['category_wise_sidemenu']) && $settings['category_wise_sidemenu'] == 'on' ? 'checked' : ''); ?> />

                                 </div>
                             </div>
                         </div>

                     </div>

                     <div class="col-xxl-3 col-md-4 col-sm-6 col-12">
                         <div class="card h-100 mb-0">
                             <div class="card-header p-2">
                                 <h6 class="d-flex align-items-center">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                                        <g clip-path="url(#clip0_803_74)">
                                        <path d="M14.2814 0H1.71863C0.770996 0 0 0.770996 0 1.71863V14.2814C0 15.229 0.770996 16 1.71863 16H14.2814C15.229 16 16 15.229 16 14.2814V1.71863C16 0.770996 15.229 0 14.2814 0ZM1.71863 0.9375H14.2814C14.712 0.9375 15.0625 1.28796 15.0625 1.71863V3.78125H0.9375V1.71863C0.9375 1.28796 1.28796 0.9375 1.71863 0.9375ZM14.2814 15.0625H1.71863C1.28796 15.0625 0.9375 14.712 0.9375 14.2814V4.71875H15.0625V14.2814C15.0625 14.712 14.712 15.0625 14.2814 15.0625Z" fill="#060606"/>
                                        <path d="M14.0938 2.375C14.0938 2.63391 13.8839 2.84375 13.625 2.84375C13.3661 2.84375 13.1562 2.63391 13.1562 2.375C13.1562 2.11609 13.3661 1.90625 13.625 1.90625C13.8839 1.90625 14.0938 2.11609 14.0938 2.375Z" fill="#060606"/>
                                        <path d="M12.2188 2.375C12.2188 2.63391 12.0089 2.84375 11.75 2.84375C11.4911 2.84375 11.2812 2.63391 11.2812 2.375C11.2812 2.11609 11.4911 1.90625 11.75 1.90625C12.0089 1.90625 12.2188 2.11609 12.2188 2.375Z" fill="#060606"/>
                                        <path d="M10.3438 2.375C10.3438 2.63391 10.1339 2.84375 9.875 2.84375C9.61609 2.84375 9.40625 2.63391 9.40625 2.375C9.40625 2.11609 9.61609 1.90625 9.875 1.90625C10.1339 1.90625 10.3438 2.11609 10.3438 2.375Z" fill="#060606"/>
                                        <path d="M5.1875 7.53125H10.8125C11.0714 7.53125 11.2812 7.32141 11.2812 7.0625C11.2812 6.80359 11.0714 6.59375 10.8125 6.59375H5.1875C4.92859 6.59375 4.71875 6.80359 4.71875 7.0625C4.71875 7.32141 4.92859 7.53125 5.1875 7.53125Z" fill="#060606"/>
                                        <path d="M12.6875 8.46875H3.3125C3.05359 8.46875 2.84375 8.67859 2.84375 8.9375C2.84375 9.19641 3.05359 9.40625 3.3125 9.40625H12.6875C12.9464 9.40625 13.1562 9.19641 13.1562 8.9375C13.1562 8.67859 12.9464 8.46875 12.6875 8.46875Z" fill="#060606"/>
                                        <path d="M9.40625 10.3438H6.59375C5.81836 10.3438 5.1875 10.9746 5.1875 11.75C5.1875 12.5254 5.81836 13.1562 6.59375 13.1562H9.40625C10.1816 13.1562 10.8125 12.5254 10.8125 11.75C10.8125 10.9746 10.1816 10.3438 9.40625 10.3438ZM9.40625 12.2188H6.59375C6.33533 12.2188 6.125 12.0084 6.125 11.75C6.125 11.4916 6.33533 11.2812 6.59375 11.2812H9.40625C9.66467 11.2812 9.875 11.4916 9.875 11.75C9.875 12.0084 9.66467 12.2188 9.40625 12.2188Z" fill="#060606"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_803_74">
                                        <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                        </defs>
                                        </svg><?php echo e(__('Enable Landing')); ?>

                                 </h6>
                             </div>
                             <div class="card-body p-2">
                                 <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                                     <label class="form-check-label f-w-600"
                                         for="landing_page"><?php echo e(__('Enable Landing Page')); ?></label>
                                         <input type="checkbox" class="form-check-input ms-0 mb-4"  id="landing_page" name="landing_page"
                                         <?php echo e(isset($settings['landing_page']) && $settings['landing_page'] == 'on' ? 'checked' : ''); ?> />

                                 </div>
                             </div>
                         </div>

                     </div>

                     <div class="col-xxl-3 col-md-4 col-sm-6 col-12">
                        <div class="card h-100 mb-0">
                            <div class="card-header p-2">
                                <h6 class="d-flex align-items-center">
                                    <svg width="16" height="16" viewBox="0 0 16 16" class="me-2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_803_84)">
                                        <path d="M16 12.875C16 13.2202 15.7202 13.5 15.375 13.5H13.5V15.375C13.5 15.7202 13.2202 16 12.875 16C12.5298 16 12.25 15.7202 12.25 15.375V13.5H10.375C10.0298 13.5 9.75 13.2202 9.75 12.875C9.75 12.5298 10.0298 12.25 10.375 12.25H12.25V10.375C12.25 10.0298 12.5298 9.75 12.875 9.75C13.2202 9.75 13.5 10.0298 13.5 10.375V12.25H15.375C15.7202 12.25 16 12.5298 16 12.875ZM11 15.375C11 15.7202 10.7202 16 10.375 16H1.875C0.841064 16 0 15.1589 0 14.125V12.9688C0 11.8901 0.462646 10.8652 1.26917 10.1566C1.92212 9.58276 3.17261 8.7323 5.18286 8.29028C4.08423 7.44397 3.375 6.11584 3.375 4.625C3.375 2.07483 5.44983 0 8 0C10.5502 0 12.625 2.07483 12.625 4.625C12.625 7.17517 10.5502 9.25 8 9.25C4.56555 9.25 2.72571 10.5406 2.09424 11.0956C1.55774 11.567 1.25 12.2496 1.25 12.9688V14.125C1.25 14.4696 1.5304 14.75 1.875 14.75H10.375C10.7202 14.75 11 15.0298 11 15.375ZM8 8C9.86096 8 11.375 6.48596 11.375 4.625C11.375 2.76404 9.86096 1.25 8 1.25C6.13904 1.25 4.625 2.76404 4.625 4.625C4.625 6.48596 6.13904 8 8 8Z" fill="#060606"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_803_84">
                                        <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                        </defs>
                                        </svg><?php echo e(__('Enable Signup')); ?>

                                </h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                                    <label class="form-check-label f-w-600"
                                        for="signup"><?php echo e(__('Enable Signup')); ?></label>
                                        <input type="checkbox" class="form-check-input ms-0 mb-4" id="signup" name="signup"
                                        <?php echo e(isset($settings['signup']) && $settings['signup'] == 'on' ? 'checked' : ''); ?> />

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xxl-3 col-md-4 col-sm-6 col-12">
                        <div class="card h-100 mb-0">
                            <div class="card-header p-2">
                                <h6 class="d-flex align-items-center">
                                    <svg width="16" height="16" viewBox="0 0 16 16" class="me-2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.5938 2.375H1.40625C0.632438 2.375 0 3.00466 0 3.78125V12.2188C0 12.9956 0.632844 13.625 1.40625 13.625H14.5938C15.3676 13.625 16 12.9953 16 12.2188V3.78125C16 3.00447 15.3673 2.375 14.5938 2.375ZM14.3778 3.3125C13.9232 3.76866 8.58266 9.12656 8.36325 9.34669C8.18 9.5305 7.82009 9.53062 7.63675 9.34669L1.62219 3.3125H14.3778ZM0.9375 12.0464V3.95359L4.97078 8L0.9375 12.0464ZM1.62219 12.6875L5.63263 8.664L6.97278 10.0085C7.52197 10.5595 8.47825 10.5593 9.02725 10.0085L10.3674 8.66403L14.3778 12.6875H1.62219ZM15.0625 12.0464L11.0292 8L15.0625 3.95359V12.0464Z" fill="#060606"/>
                                        </svg><?php echo e(__('Email Verification')); ?>

                                </h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="form-check form-switch d-flex gap-2 flex-column p-0">
                                    <label class="form-check-label f-w-600"
                                        for="email_verification"><?php echo e(__('Email Verification')); ?></label>
                                        <input type="checkbox" class="form-check-input ms-0 mb-4" id="email_verification"
                                        name="email_verification"
                                        <?php echo e(isset($settings['email_verification']) && $settings['email_verification'] == 'on' ? 'checked' : ''); ?> />

                                </div>
                            </div>
                        </div>

                    </div>

                 </div>
             </div>
         </div>
         <div class="card-footer text-end p-3">
             <input class="btn btn-print-invoice  btn-primary " type="submit" value="<?php echo e(__('Save Changes')); ?>">
         </div>
         <?php echo e(Form::close()); ?>

     </div>
 </div>

 <!--system settings-->
 <div class="card" id="system-settings">
     <div class="card-header p-3">
         <h5 class="small-title"><?php echo e(__('System Settings')); ?></h5>
     </div>
     <?php echo e(Form::open(['route' => ['super.admin.system.setting.store'], 'id' => 'setting-system-form'])); ?>

     <?php echo method_field('post'); ?>
     <div class="card-body p-3 pb-0">
         <div class="row">
             <div class="col-xxl-3 col-sm-6 col-12">
                 <div class="form-group col switch-width">
                     <?php echo e(Form::label('defult_language', __('Default Language'), ['class' => ' form-label'])); ?>

                     <select class="form-control" data-trigger name="defult_language" id="defult_language"
                         placeholder="This is a search placeholder">
                         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($key); ?>"
                                 <?php echo e(isset($settings['defult_language']) && $settings['defult_language'] == $key ? 'selected' : ''); ?>>
                                 <?php echo e(Str::ucfirst($language)); ?> </option>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                     </select>
                 </div>
             </div>
             <div class="col-xxl-3 col-sm-6 col-12">
                 <div class="form-group">
                     <label for="site_date_format" class="form-label"><?php echo e(__('Date Format')); ?></label>
                     <select type="text" name="site_date_format" class="form-control selectric"
                         id="site_date_format">
                         <option value="d-m-Y" <?php if(isset($settings['site_date_format']) && $settings['site_date_format'] == 'd-m-Y'): ?> selected="selected" <?php endif; ?>>
                             DD-MM-YYYY</option>
                         <option value="m-d-Y" <?php if(isset($settings['site_date_format']) && $settings['site_date_format'] == 'm-d-Y'): ?> selected="selected" <?php endif; ?>>
                             MM-DD-YYYY</option>
                         <option value="Y-m-d" <?php if(isset($settings['site_date_format']) && $settings['site_date_format'] == 'Y-m-d'): ?> selected="selected" <?php endif; ?>>
                             YYYY-MM-DD</option>
                     </select>
                 </div>
             </div>
             <div class="col-xxl-3 col-sm-6 col-12">
                 <div class="form-group">
                     <label for="site_time_format" class="form-label"><?php echo e(__('Time Format')); ?></label>
                     <select type="text" name="site_time_format" class="form-control selectric"
                         id="site_time_format">
                         <option value="g:i A" <?php if(isset($settings['site_time_format']) && $settings['site_time_format'] == 'g:i A'): ?> selected="selected" <?php endif; ?>>
                             10:30 PM</option>
                         <option value="H:i" <?php if(isset($settings['site_time_format']) && $settings['site_time_format'] == 'H:i'): ?> selected="selected" <?php endif; ?>>
                             22:30</option>
                     </select>
                 </div>
             </div>
             <div class="col-xxl-3 col-sm-6 col-12">
                <div class="form-group">
                <label for="calendar_start_day"><?php echo e(__('Calendar Start Day of the Week')); ?></label>
                    <select class="form-control mt-2" data-trigger name="calendar_start_day" id="calendar_start_day">
                        <?php
                            $days = [
                                0 => 'Sunday',
                                1 => 'Monday',
                                2 => 'Tuesday',
                                3 => 'Wednesday',
                                4 => 'Thursday',
                                5 => 'Friday',
                                6 => 'Saturday'
                            ];
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>"
                                <?php echo e(isset($settings['calendar_start_day']) && $settings['calendar_start_day'] == $key ? 'selected' : ''); ?>>
                                <?php echo e(Str::ucfirst($day)); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>
            </div>
             <div class="col-xxl-8 col-12">
                <div class="form-group col switch-width">
                    <?php echo e(Form::label('defult_timezone', __('Default Timezone'), ['class' => ' form-label'])); ?>

                    <?php echo e(Form::select('defult_timezone', $timezones, isset($settings['defult_timezone']) ? $settings['defult_timezone'] : null, ['id' => 'timezone', 'class' => 'form-control choices', 'searchEnabled' => 'true'])); ?>

                </div>
            </div>
         </div>
     </div>
     <div class="card-footer text-end p-3">
         <input class="btn btn-print-invoice  btn-primary " type="submit" value="<?php echo e(__('Save Changes')); ?>">
     </div>
     <?php echo e(Form::close()); ?>

 </div>

 <!--App environment settings-->
 <div class="card" id="app-environment-sidenav">
     <div class="card-header p-3">
         <h5 class="small-title"><?php echo e(__('App Environment')); ?></h5>
         <small class="text-secondary">
             <?php echo e(__('Switch application mode and debug visibility without manually editing the .env file.')); ?>

         </small>
     </div>
     <?php echo e(Form::open(['route' => ['super.admin.app.environment.save'], 'method' => 'post', 'id' => 'setting-app-environment-form'])); ?>

     <div class="card-body p-3 pb-0">
         <div class="row">
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="form-label" for="app_environment"><?php echo e(__('Application Mode')); ?></label>
                     <select class="form-control" name="app_environment" id="app_environment">
                         <option value="local" <?php echo e(strtolower((string) ($appEnvCurrent ?? 'production')) === 'local' ? 'selected' : ''); ?>>
                             <?php echo e(__('Local (Development)')); ?>

                         </option>
                         <option value="production" <?php echo e(strtolower((string) ($appEnvCurrent ?? 'production')) === 'production' ? 'selected' : ''); ?>>
                             <?php echo e(__('Production')); ?>

                         </option>
                     </select>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label class="form-label d-block"><?php echo e(__('Debug Mode')); ?></label>
                     <div class="form-check form-switch custom-switch-v1">
                         <input type="checkbox" name="app_debug" class="form-check-input input-primary" id="app_debug"
                             <?php echo e(!empty($appDebugCurrent) ? 'checked' : ''); ?>>
                         <label class="form-check-label" for="app_debug"><?php echo e(__('Enable APP_DEBUG')); ?></label>
                     </div>
                 </div>
             </div>
             <div class="col-12">
                 <div class="alert alert-warning mb-0">
                     <strong><?php echo e(__('Current')); ?>:</strong>
                     <?php echo e(__('Mode')); ?> <?php echo e(strtoupper((string) ($appEnvCurrent ?? 'PRODUCTION'))); ?> |
                     <?php echo e(__('Debug')); ?> <?php echo e(!empty($appDebugCurrent) ? 'ON' : 'OFF'); ?>.
                     <?php echo e(__('Use debug only for troubleshooting and disable it in production after use.')); ?>

                 </div>
             </div>
         </div>
     </div>
     <div class="card-footer text-end p-3">
         <input class="btn btn-print-invoice btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
     </div>
     <?php echo e(Form::close()); ?>

 </div>

 <!--currency settings-->
 <div class="card" id="currency-settings">
     <div class="card-header p-3">
         <h5 class="small-title"><?php echo e(__('Currency Settings')); ?></h5>
     </div>
     <?php echo e(Form::open(['route' => ['super.admin.currency.settings'], 'method' => 'post', 'id' => 'setting-currency-form'])); ?>

     <div class="card-body p-3 pb-0">
         <div class="row">
             <div class="col-xxl-4 col-sm-6">
                 <div class="form-group col switch-width">
                     <?php echo e(Form::label('currency_format', __('Decimal Format'), ['class' => ' form-label'])); ?>

                     <select class="form-control currency_note" data-trigger name="currency_format"
                         id="currency_format" placeholder="This is a search placeholder">
                         <option value="0"
                             <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '0' ? 'selected' : ''); ?>>
                             1</option>
                         <option value="1"
                             <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '1' ? 'selected' : ''); ?>>
                             1.0</option>
                         <option value="2"
                             <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '2' ? 'selected' : ''); ?>>
                             1.00</option>
                         <option value="3"
                             <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '3' ? 'selected' : ''); ?>>
                             1.000</option>
                         <option value="4"
                             <?php echo e(isset($settings['currency_format']) && $settings['currency_format'] == '4' ? 'selected' : ''); ?>>
                             1.0000</option>
                     </select>
                 </div>
             </div>
             <div class="col-xxl-4 col-sm-6">
                 <div class="form-group col switch-width">
                     <?php echo e(Form::label('defult_currancy', __('Default Currancy'), ['class' => ' form-label'])); ?>

                     <select class="form-control currency_note" data-trigger name="defult_currancy"
                         id="defult_currancy" placeholder="This is a search placeholder">
                         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = currency(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($c->symbol); ?>-<?php echo e($c->code); ?>"
                                 data-symbol="<?php echo e($c->symbol); ?>"
                                 <?php echo e(isset($settings['defult_currancy']) && $settings['defult_currancy'] == $c->code ? 'selected' : ''); ?>>
                                 <?php echo e($c->symbol); ?> - <?php echo e($c->code); ?> </option>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                     </select>
                 </div>
             </div>
             <div class="form-group col-xxl-4 col-sm-6">
                 <label for="decimal_separator" class="form-label"><?php echo e(__('Decimal Separator')); ?></label>
                 <select type="text" name="decimal_separator" class="form-control selectric currency_note"
                     id="decimal_separator">
                     <option value="dot" <?php if(@$settings['decimal_separator'] == 'dot'): ?> selected="selected" <?php endif; ?>>
                         <?php echo e(__('Dot')); ?></option>
                     <option value="comma" <?php if(@$settings['decimal_separator'] == 'comma'): ?> selected="selected" <?php endif; ?>>
                         <?php echo e(__('Comma')); ?></option>
                 </select>
             </div>
             <div class="form-group col-xxl-4 col-sm-6">
                 <label for="thousand_separator" class="form-label"><?php echo e(__('Thousands Separator')); ?></label>
                 <select type="text" name="thousand_separator" class="form-control selectric currency_note"
                     id="thousand_separator">
                     <option value="dot" <?php if(@$settings['thousand_separator'] == 'dot'): ?> selected="selected" <?php endif; ?>>
                         <?php echo e(__('Dot')); ?></option>
                     <option value="comma" <?php if(@$settings['thousand_separator'] == 'comma'): ?> selected="selected" <?php endif; ?>>
                         <?php echo e(__('Comma')); ?></option>
                 </select>
             </div>
             <div class="form-group col-xxl-4 col-sm-6">
                 <label for="float_number" class="form-label"><?php echo e(__('Float Number')); ?></label>
                 <select type="text" name="float_number" class="form-control selectric currency_note"
                     id="float_number">
                     <option value="comma" <?php if(@$settings['float_number'] == 'comma'): ?> selected="selected" <?php endif; ?>>
                         <?php echo e(__('Comma')); ?></option>
                     <option value="dot" <?php if(@$settings['float_number'] == 'dot'): ?> selected="selected" <?php endif; ?>>
                         <?php echo e(__('Dot')); ?></option>
                 </select>
             </div>
         </div>
         <div class="row">
             <div class="col-xxl-4 col-md-6">
                 <div class="card">
                     <div class="card-header p-2">
                         <?php echo e(Form::label('currency_space', __('Currency Symbol Space'), ['class' => 'form-label h6 mb-0'])); ?>

                     </div>
                     <div class="card-body p-2">
                         <div class="form-group mb-0">
                             <div class="form-check mb-2">
                                 <input class="form-check-input currency_note pointer" type="radio"
                                     name="currency_space" value="withspace"
                                     <?php if(!isset($settings['currency_space']) || $settings['currency_space'] == 'withspace'): ?> checked <?php endif; ?> id="flexCheckDefault">
                                 <label class="form-check-label" for="flexCheckDefault">
                                     <?php echo e(__('With space')); ?>

                                 </label>
                             </div>
                             <div class="form-check">
                                 <input class="form-check-input currency_note pointer" type="radio"
                                     name="currency_space" value="withoutspace"
                                     <?php if(!isset($settings['currency_space']) || $settings['currency_space'] == 'withoutspace'): ?> checked <?php endif; ?> id="flexCheckChecked">
                                 <label class="form-check-label" for="flexCheckChecked">
                                     <?php echo e(__('Without space')); ?>

                                 </label>
                             </div>
                         </div>
                     </div>
                 </div>
                 <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['currency_space'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                     <span class="invalid-currency_space" role="alert">
                         <strong class="text-danger"><?php echo e($message); ?></strong>
                     </span>
                 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
             </div>
             <div class="col-xxl-4 col-md-6">
                 <div class="card">
                     <div class="card-header p-2">
                         <label class="form-label h6 mb-0"
                             for="example3cols3Input"><?php echo e(__('Currency Symbol Position')); ?></label>
                     </div>
                     <div class="card-body p-2">
                         <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                             <div class="form-group mb-0">
                                 <div class="form-check mb-2">
                                     <input class="form-check-input currency_note pointer" type="radio"
                                         name="site_currency_symbol_position" value="pre"
                                         <?php if(!isset($settings['site_currency_symbol_position']) || $settings['site_currency_symbol_position'] == 'pre'): ?> checked <?php endif; ?>
                                         id="currencySymbolPosition">
                                     <label class="form-check-label" for="currencySymbolPosition">
                                         <?php echo e(__('Pre')); ?>

                                     </label>
                                 </div>
                                 <div class="form-check">
                                     <input class="form-check-input currency_note pointer" type="radio"
                                         name="site_currency_symbol_position" value="post"
                                         <?php if(isset($settings['site_currency_symbol_position']) && $settings['site_currency_symbol_position'] == 'post'): ?> checked <?php endif; ?> id="currencySymbolPost">
                                     <label class="form-check-label" for="currencySymbolPost">
                                         <?php echo e(__('Post')); ?>

                                     </label>
                                 </div>
                             </div>
                             <div class="form-group mb-0 border border-1 rounded-1 p-2">
                                 <label class="form-label mb-0" for="new_note_value"><?php echo e(__('Preview :')); ?></label>
                                 <span id="formatted_price_span"></span>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-4 col-md-6">
                <div class="card">
                    <div class="card-header p-2">
                        <label class="form-label h6 mb-0" for="example3cols3Input"><?php echo e(__('Currency Symbol & Name')); ?></label>
                    </div>
                    <div class="card-body p-2">
                        <div class="form-group mb-0">
                            <div class="form-check mb-2">
                                <input class="form-check-input currency_note pointer" type="radio"
                                    name="site_currency_symbol_name" value="symbol"
                                    <?php if(!isset($settings['site_currency_symbol_name']) || $settings['site_currency_symbol_name'] == 'symbol'): ?> checked <?php endif; ?> id="currencySymbol">
                                <label class="form-check-label" for="currencySymbol">
                                    <?php echo e(__('With Currency Symbol')); ?>

                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input currency_note pointer" type="radio"
                                    name="site_currency_symbol_name" value="symbolname"
                                    <?php if(isset($settings['site_currency_symbol_name']) && $settings['site_currency_symbol_name'] == 'symbolname'): ?> checked <?php endif; ?> id="currencySymbolName">
                                <label class="form-check-label" for="currencySymbolName">
                                    <?php echo e(__('With Currency Name')); ?>

                                </label>
                            </div>
                        </div>
                    </div>
                </div>

             </div>
         </div>
     </div>
     <div class="card-footer text-end p-3">
         <input class="btn btn-print-invoice  btn-primary " type="submit" value="<?php echo e(__('Save Changes')); ?>">
     </div>
     <?php echo e(Form::close()); ?>

 </div>



 
 <div class="card" id="cookie-sidenav">
     <?php echo e(Form::open(['route' => ['cookie.setting.store'], 'method' => 'post'])); ?>

     <div class="card-header p-3">
         <div class="row align-items-center">
             <div class="col-sm-10 col-9">
                 <h5 class=""><?php echo e(__('Cookie Settings')); ?></h5>
             </div>
             <div class="col-sm-2 col-3 text-end">
                 <div class="form-check form-switch custom-switch-v1 float-end">
                     <input type="checkbox" name="enable_cookie" class="form-check-input input-primary"
                         id="enable_cookie"
                         <?php echo e((isset($settings['enable_cookie']) ? $settings['enable_cookie'] : 'off') == 'on' ? ' checked ' : ''); ?>>
                     <label class="form-check-label" for="enable_cookie"></label>
                 </div>
             </div>
         </div>
     </div>
     <div class="card-body p-3 pb-0">
         <div class="row ">
             <div class="col-sm-6 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body p-2">
                        <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                            <input type="checkbox" name="cookie_logging"
                                class="form-check-input input-primary cookie_setting" id="cookie_logging"
                                <?php echo e((isset($settings['cookie_logging']) ? $settings['cookie_logging'] : 'off') == 'on' ? ' checked ' : ''); ?>>
                            <label class="form-check-label" for="cookie_logging"><?php echo e(__('Enable logging')); ?></label>
                            <small
                                class="text-danger d-block mt-1"><?php echo e(__('After enabling logging, user cookie data will be stored in CSV file.')); ?></small>
                        </div>
                    </div>
                </div>
             </div>
             <div class="col-sm-6 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body p-2">
                        <div class="form-check form-switch custom-switch-v1">
                            <input type="checkbox" name="necessary_cookies"
                                class="form-check-input input-primary cookie_setting" id="necessary_cookies" checked
                                onclick="return false">
                            <label class="form-check-label"
                                for="necessary_cookies"><?php echo e(__('Strictly necessary cookies')); ?></label>
                        </div>
                    </div>
                </div>
             </div>
             <div class="col-sm-6">
                <div class="form-group ">
                    <?php echo e(Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('strictly_cookie_title', !empty($settings['strictly_cookie_title']) ? $settings['strictly_cookie_title'] : null, ['class' => 'form-control cookie_setting'])); ?>

                </div>
             </div>
             <div class="col-sm-6">
                <div class="form-group">
                    <?php echo e(Form::label('cookie_title', __('Cookie Title'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('cookie_title', !empty($settings['cookie_title']) ? $settings['cookie_title'] : null, ['class' => 'form-control cookie_setting'])); ?>

                </div>
             </div>
             <div class="col-md-6">
                <div class="form-group ">
                    <?php echo e(Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label'])); ?>

                    <?php echo Form::textarea(
                        'cookie_description',
                        !empty($settings['cookie_description']) ? $settings['cookie_description'] : null,
                        ['class' => 'form-control cookie_setting', 'rows' => '3'],
                    ); ?>

                    <?php if (isset($component)) { $__componentOriginal196cabbf5fb9f59797b6c88c3b904481 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea-setting-validation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-setting-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $attributes = $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $component = $__componentOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
                </div>
             </div>
             <div class="col-md-6">
                <div class="form-group ">
                    <?php echo e(Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label'])); ?>

                    <?php echo Form::textarea(
                        'strictly_cookie_description',
                        !empty($settings['strictly_cookie_description']) ? $settings['strictly_cookie_description'] : null,
                        ['class' => 'form-control cookie_setting ', 'rows' => '3'],
                    ); ?>

                    <?php if (isset($component)) { $__componentOriginal196cabbf5fb9f59797b6c88c3b904481 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea-setting-validation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-setting-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $attributes = $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $component = $__componentOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
                </div>
             </div>
             <div class="col-12">
                 <h5 class="mb-3"><?php echo e(__('More Information')); ?></h5>
             </div>
             <div class="col-sm-6">
                 <div class="form-group">
                     <?php echo e(Form::label('more_information_description', __('Contact Us Description'), ['class' => 'form-label'])); ?>

                     <?php echo e(Form::text('more_information_description', !empty($settings['more_information_description']) ? $settings['more_information_description'] : null, ['class' => 'form-control cookie_setting'])); ?>

                 </div>
             </div>
             <div class="col-sm-6">
                 <div class="form-group ">
                     <?php echo e(Form::label('contactus_url', __('Contact Us URL'), ['class' => 'form-label'])); ?>

                     <?php echo e(Form::text('contactus_url', !empty($settings['contactus_url']) ? $settings['contactus_url'] : null, ['class' => 'form-control cookie_setting'])); ?>

                 </div>
             </div>
         </div>
     </div>
     <div class="card-footer p-3">
         <div class="row align-items-center row-gap">
             <div class="col-sm-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((isset($settings['cookie_logging']) ? $settings['cookie_logging'] : 'off') == 'on'): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(check_file('uploads/sample/cookie_data.csv')): ?>
                        <label for="file" class="form-label d-block"><?php echo e(__('Download cookie accepted data')); ?></label>
                        <a href="<?php echo e(asset('uploads/sample/cookie_data.csv')); ?>" class="btn btn-primary mr-3">
                            <i class="ti ti-download"></i>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
             </div>
             <div class="col-sm-6 text-end ">
                 <input class="btn btn-print-invoice btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
             </div>
         </div>
     </div>
     <?php echo e(Form::close()); ?>

 </div>

 <!--Pusher Setting-->
 <div id="pusher-sidenav" class="card">
     <div class="card-header p-3">
         <h5><?php echo e(__('Pusher Settings')); ?></h5>
     </div>
     <?php echo e(Form::open(['route' => ['pusher.setting'], 'method' => 'post', 'id' => 'pusher-form'])); ?>

     <div class="card-body p-3 pb-0">
         <div class="row">
             <div class="col-sm-6">
                 <div class="form-group">
                     <?php echo e(Form::label('pusher_app_id', __('Pusher App Id'), ['class' => 'form-label'])); ?>

                     <?php echo e(Form::text('pusher_app_id', !empty($settings['PUSHER_APP_ID']) ? $settings['PUSHER_APP_ID'] : null, ['class' => 'form-control font-style', 'required' => 'required', 'placeholder' => 'Enter Pusher App Id'])); ?>

                 </div>
             </div>
             <div class="col-sm-6">
                 <div class="form-group">
                     <?php echo e(Form::label('pusher_app_key', __('Pusher App Key'), ['class' => 'form-label'])); ?>

                     <?php echo e(Form::text('pusher_app_key', !empty($settings['PUSHER_APP_KEY']) ? $settings['PUSHER_APP_KEY'] : null, ['class' => 'form-control font-style', 'required' => 'required', 'placeholder' => 'Enter Pusher App Key'])); ?>

                 </div>
             </div>
             <div class="col-sm-6">
                <div class="form-group">
                    <?php echo e(Form::label('pusher_app_secret', __('Pusher App Secret'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('pusher_app_secret', !empty($settings['PUSHER_APP_SECRET']) ? $settings['PUSHER_APP_SECRET'] : null, ['class' => 'form-control font-style', 'required' => 'required', 'placeholder' => 'Enter Pusher App Secret'])); ?>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <?php echo e(Form::label('pusher_app_cluster', __('Pusher App Cluster'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('pusher_app_cluster', !empty($settings['PUSHER_APP_CLUSTER']) ? $settings['PUSHER_APP_CLUSTER'] : null, ['class' => 'form-control font-style', 'required' => 'required', 'placeholder' => 'Enter Pusher App Cluster'])); ?>

                </div>
            </div>
         </div>
     </div>
     <div class="card-footer text-end p-3">
         <input class="btn btn-print-invoice  btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
     </div>

     <?php echo e(Form::close()); ?>

 </div>
 

 <div id="seo-sidenav" class="card">
     <div class="card-header p-3">
        <h5><?php echo e(__('SEO Settings')); ?></h5>
     </div>
     <?php echo e(Form::open(['url' => route('seo.setting.save'), 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

     <?php echo csrf_field(); ?>
     <div class="card-body p-3 pb-0">
         <div class="row">
             <div class="col-md-7">
                 <div class="form-group">
                     <?php echo e(Form::label('meta_title', __('Meta Title'), ['class' => 'form-label'])); ?>

                     <?php echo e(Form::text('meta_title', !empty($settings['meta_title']) ? $settings['meta_title'] : null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Meta Title'])); ?>

                 </div>
                 <div class="form-group">
                     <?php echo e(Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'form-label'])); ?>

                     <?php echo e(Form::textarea('meta_keywords', !empty($settings['meta_keywords']) ? $settings['meta_keywords'] : null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Meta Keywords', 'rows' => 2])); ?>

                     <?php if (isset($component)) { $__componentOriginal196cabbf5fb9f59797b6c88c3b904481 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea-setting-validation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-setting-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $attributes = $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $component = $__componentOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
                 </div>
                 <div class="form-group">
                     <?php echo e(Form::label('meta_description', __('Meta Description'), ['class' => 'form-label'])); ?>

                     <?php echo e(Form::textarea('meta_description', !empty($settings['meta_description']) ? $settings['meta_description'] : null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Meta Description', 'rows' => 3])); ?>

                     <?php if (isset($component)) { $__componentOriginal196cabbf5fb9f59797b6c88c3b904481 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea-setting-validation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-setting-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $attributes = $__attributesOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__attributesOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481)): ?>
<?php $component = $__componentOriginal196cabbf5fb9f59797b6c88c3b904481; ?>
<?php unset($__componentOriginal196cabbf5fb9f59797b6c88c3b904481); ?>
<?php endif; ?>
                 </div>
             </div>
             <div class="col-md-5">
                <div class="card">
                    <div class="card-header p-3">
                        <?php echo e(Form::label('Meta Image', __('Meta Image'), ['class' => 'form-label h6 mb-0'])); ?>

                    </div>
                    <div class="card-body p-3">
                        <div class="setting-card">
                            <div class="logo-content">
                                <img id="image2"
                                    src="<?php echo e(get_file(!empty($settings['meta_image']) ? (check_file($settings['meta_image']) ? $settings['meta_image'] : 'uploads/meta/meta_image.png') : 'uploads/meta/meta_image.png')); ?><?php echo e('?' . time()); ?>"
                                    class="img_setting rounded w-100">
                            </div>
                            <div class="choose-files mt-4">
                                <label for="meta_image">
                                    <div class="bg-primary company_favicon_update"> <i
                                            class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                    </div>
                                    <input type="file" class="form-control file"
                                        accept="image/png, image/gif, image/jpeg,image/jpg" id="meta_image"
                                        name="meta_image"
                                        onchange="document.getElementById('image2').src = window.URL.createObjectURL(this.files[0])"
                                        data-filename="meta_image">
                                </label>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['meta_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="row">
                                    <span class="invalid-logo" role="alert">
                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                    </span>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>


             </div>
         </div>
     </div>
     <div class="card-footer text-end p-3">
         <input class="btn btn-print-invoice btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
     </div>
     <?php echo e(Form::close()); ?>

 </div>


<div class="card" id="cache-sidenav">
    <div class="card-header p-3">
        <h5><?php echo e(__('Cache Settings')); ?></h5>
        <small class="text-secondary font-weight-bold">
            <?php echo e(__("This is a page meant for more advanced users, simply ignore it if you don't understand what cache is.")); ?>

        </small>
    </div>

    <form method="get" action="<?php echo e(route('config.cache')); ?>">
        <?php echo csrf_field(); ?>
        <div class="card-body p-3 pb-0">
            <div class="row">
                <div class="col-12 form-group">
                    <?php echo e(Form::label('Current cache size', __('Current cache size'), ['class' => 'form-label'])); ?>

                    <div class="input-group gap-2">
                        <input type="text" class="form-control rounded-1" value="<?php echo e(CacheSize()); ?>" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text"><?php echo e(__('MB')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="card-footer p-3">
        <div class="d-flex justify-content-end">
            
            <form method="POST" action="<?php echo e(route('site.optimize')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-primary me-2" type="submit"><?php echo e(__('Site Optimize')); ?></button>
            </form>

            
            <form method="get" action="<?php echo e(route('config.cache')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-primary me-2" type="submit"><?php echo e(__('Cache Clear')); ?></button>
            </form>
        </div>
    </div>
</div>

 
 <div class="card" id="storage-sidenav">
     <?php echo e(Form::open(['route' => 'storage.setting.store', 'enctype' => 'multipart/form-data'])); ?>

     <div class="card-header p-3">
         <div class="row">
             <div class="col-lg-10 col-md-10 col-sm-10">
                 <h5 class=""><?php echo e(__('Storage Settings')); ?></h5>
             </div>
         </div>
     </div>
     <div class="card-body p-3 pb-0">
         <div class="d-flex flex-wrap gap-2">
             <div class="tab-btn">
                 <input type="radio" class="btn-check" name="storage_setting" id="local-outlined"
                     autocomplete="off"
                     <?php echo e(isset($settings['storage_setting']) && $settings['storage_setting'] == 'local' ? 'checked' : ''); ?>

                     value="local">
                 <label class="btn btn-outline-primary" for="local-outlined"><?php echo e(__('Local')); ?></label>
             </div>
             <div class="tab-btn">
                 <input type="radio" class="btn-check" name="storage_setting" id="s3-outlined" autocomplete="off"
                     <?php echo e(isset($settings['storage_setting']) && $settings['storage_setting'] == 's3' ? 'checked' : ''); ?>

                     value="s3">
                 <label class="btn btn-outline-primary" for="s3-outlined"> <?php echo e(__('AWS S3')); ?></label>
             </div>
             <div class="tab-btn">
                 <input type="radio" class="btn-check" name="storage_setting" id="wasabi-outlined"
                     autocomplete="off"
                     <?php echo e(isset($settings['storage_setting']) && $settings['storage_setting'] == 'wasabi' ? 'checked' : ''); ?>

                     value="wasabi">
                 <label class="btn btn-outline-primary" for="wasabi-outlined"><?php echo e(__('Wasabi')); ?></label>
             </div>
         </div>
         <div class="local-setting row <?php echo e(isset($settings['storage_setting']) && $settings['storage_setting'] == 'local' ? ' ' : 'd-none'); ?>">
             <h4 class="small-title mt-3"><?php echo e(__('Local Settings')); ?></h4>
             <div class="form-group col-12 switch-width">
                 <?php echo e(Form::label('local_storage_validation', __('Only Upload Files'), ['class' => ' form-label'])); ?>

                 <?php echo e(Form::select('local_storage_validation[]', array_flip($file_type), isset($settings['local_storage_validation']) ? explode(',', $settings['local_storage_validation']) : null, ['id' => 'local_storage_validation', 'class' => ' choices', 'multiple' => '', 'searchEnabled' => 'true'])); ?>

             </div>
             <div class="col-lg-4 col-sm-6">
                 <div class="form-group">
                     <label class="form-label"
                         for="local_storage_max_upload_size"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                     <input type="number" name="local_storage_max_upload_size" class="form-control"
                         value="<?php echo e(isset($settings['local_storage_max_upload_size']) ? $settings['local_storage_max_upload_size'] : 2024); ?>"
                         placeholder="<?php echo e(__('Max upload size')); ?>">
                 </div>
             </div>
         </div>
         <div
             class="s3-setting <?php echo e(isset($settings['storage_setting']) && $settings['storage_setting'] == 's3' ? ' ' : 'd-none'); ?>">
             <h4 class="small-title mt-3"><?php echo e(__('AWS S3 Settings')); ?></h4>

             <div class=" row ">
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_key"><?php echo e(__('S3 Key')); ?></label>
                         <input type="text" name="s3_key" class="form-control"
                             value="<?php echo e(isset($settings['s3_key']) ? $settings['s3_key'] : null); ?>"
                             placeholder="<?php echo e(__('S3 Key')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_secret"><?php echo e(__('S3 Secret')); ?></label>
                         <input type="text" name="s3_secret" class="form-control"
                             value="<?php echo e(isset($settings['s3_secret']) ? $settings['s3_secret'] : null); ?>"
                             placeholder="<?php echo e(__('S3 Secret')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_region"><?php echo e(__('S3 Region')); ?></label>
                         <input type="text" name="s3_region" class="form-control"
                             value="<?php echo e(isset($settings['s3_region']) ? $settings['s3_region'] : null); ?>"
                             placeholder="<?php echo e(__('S3 Region')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_bucket"><?php echo e(__('S3 Bucket')); ?></label>
                         <input type="text" name="s3_bucket" class="form-control"
                             value="<?php echo e(isset($settings['s3_bucket']) ? $settings['s3_bucket'] : null); ?>"
                             placeholder="<?php echo e(__('S3 Bucket')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_url"><?php echo e(__('S3 URL')); ?></label>
                         <input type="text" name="s3_url" class="form-control"
                             value="<?php echo e(isset($settings['s3_url']) ? $settings['s3_url'] : null); ?>"
                             placeholder="<?php echo e(__('S3 URL')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_endpoint"><?php echo e(__('S3 Endpoint')); ?></label>
                         <input type="text" name="s3_endpoint" class="form-control"
                             value="<?php echo e(isset($settings['s3_endpoint']) ? $settings['s3_endpoint'] : null); ?>"
                             placeholder="<?php echo e(__('S3 Endpoint')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label"
                             for="s3_max_upload_size"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                         <input type="number" name="s3_max_upload_size" class="form-control"
                             value="<?php echo e(isset($settings['s3_max_upload_size']) ? $settings['s3_max_upload_size'] : 2024); ?>"
                             placeholder="<?php echo e(__('Max upload size')); ?>">
                     </div>
                 </div>
                 <div class="form-group col-sm-6 switch-width">
                    <?php echo e(Form::label('s3_storage_validation', __('Only Upload Files'), ['class' => ' form-label'])); ?>

                    <?php echo e(Form::select('s3_storage_validation[]', array_flip($file_type), isset($settings['s3_storage_validation']) ? explode(',', $settings['s3_storage_validation']) : null, ['id' => 's3_storage_validation', 'class' => ' choices', 'multiple' => ''])); ?>

                </div>
             </div>
         </div>
         <div
             class="wasabi-setting  <?php echo e(isset($settings['storage_setting']) && $settings['storage_setting'] == 'wasabi' ? ' ' : 'd-none'); ?>">
             <h4 class="small-title mt-3"><?php echo e(__('Wasabi Settings')); ?></h4>
             <div class=" row ">
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_key"><?php echo e(__('Wasabi Key')); ?></label>
                         <input type="text" name="wasabi_key" class="form-control"
                             value="<?php echo e(isset($settings['wasabi_key']) ? $settings['wasabi_key'] : null); ?>"
                             placeholder="<?php echo e(__('Wasabi Key')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_secret"><?php echo e(__('Wasabi Secret')); ?></label>
                         <input type="text" name="wasabi_secret" class="form-control"
                             value="<?php echo e(isset($settings['wasabi_secret']) ? $settings['wasabi_secret'] : null); ?>"
                             placeholder="<?php echo e(__('Wasabi Secret')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="s3_region"><?php echo e(__('Wasabi Region')); ?></label>
                         <input type="text" name="wasabi_region" class="form-control"
                             value="<?php echo e(isset($settings['wasabi_region']) ? $settings['wasabi_region'] : null); ?>"
                             placeholder="<?php echo e(__('Wasabi Region')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="wasabi_bucket"><?php echo e(__('Wasabi Bucket')); ?></label>
                         <input type="text" name="wasabi_bucket" class="form-control"
                             value="<?php echo e(isset($settings['wasabi_bucket']) ? $settings['wasabi_bucket'] : null); ?>"
                             placeholder="<?php echo e(__('Wasabi Bucket')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="wasabi_url"><?php echo e(__('Wasabi URL')); ?></label>
                         <input type="text" name="wasabi_url" class="form-control"
                             value="<?php echo e(isset($settings['wasabi_url']) ? $settings['wasabi_url'] : null); ?>"
                             placeholder="<?php echo e(__('Wasabi URL')); ?>">
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="wasabi_root"><?php echo e(__('Wasabi Root')); ?></label>
                         <input type="text" name="wasabi_root" class="form-control"
                             value="<?php echo e(isset($settings['wasabi_root']) ? $settings['wasabi_root'] : null); ?>"
                             placeholder="<?php echo e(__('Wasabi Sub Folder')); ?>">
                         <small
                             class="text-danger"><?php echo e(__('If a folder has been created under the bucket then enter the folder name otherwise blank')); ?>

                         </small>
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="form-group">
                         <label class="form-label" for="wasabi_root"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                         <input type="number" name="wasabi_max_upload_size" class="form-control"
                             value="<?php echo e(isset($settings['wasabi_max_upload_size']) ? $settings['wasabi_max_upload_size'] : 2024); ?>"
                             placeholder="<?php echo e(__('Max upload size')); ?>">
                     </div>
                 </div>
                 <div class="form-group col-sm-6 switch-width">
                     <?php echo e(Form::label('wasabi_storage_validation', __('Only Upload Files'), ['class' => ' form-label'])); ?>

                     <?php echo e(Form::select('wasabi_storage_validation[]', array_flip($file_type), isset($settings['wasabi_storage_validation']) ? explode(',', $settings['wasabi_storage_validation']) : null, ['id' => 'wasabi_storage_validation', 'class' => ' choices', 'multiple' => ''])); ?>

                 </div>
             </div>
         </div>
     </div>
     <div class="card-footer text-end p-3">
         <input class="btn btn-print-invoice  btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
     </div>
     <?php echo e(Form::close()); ?>


 </div>

 
 <div class="card" id="chat-gpt-setting-sidenav">
     <?php echo e(Form::open(['route' => 'ai.key.setting.save'])); ?>

     <div class="card-header p-3">
        <h5><?php echo e(__('ChatGPT Key Settings')); ?></h5>
        <small class="text-muted"><?php echo e(__('Edit your key details')); ?></small>
     </div>
     <div class="card-body p-3 pb-0">
        <div class="form-group">
            <div class="field_wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($ai_key_settings) > 0): ?>
                    <?php $i = 1; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $ai_key_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex gap-2 mb-4">
                            <input type="text" class="form-control" name="api_key[]" placeholder= "<?php echo e(__('Enter ChatGPT Key')); ?>"
                                value="<?php echo e($key_data->key); ?>" />
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i == 1): ?>
                                <a href="javascript:void(0);" class="add_button btn btn-primary"
                                    title="Add field"><i class="ti ti-plus"></i></a>
                            <?php else: ?>
                                <a href="javascript:void(0);" class="remove_button btn btn-danger"><i
                                        class="ti ti-trash"></i></a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    <div class="d-flex gap-2 mb-4">
                        <input type="text" class="form-control " name="api_key[]" placeholder= "<?php echo e(__('Enter ChatGPT Key')); ?>" value="" />

                        <a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field"><i
                                class="ti ti-plus"></i></a>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo e(Form::label('chatgpt_model', __('Chatgpt Model'), ['class' => 'form-label'])); ?>

            <select name="chatgpt_model" id="chatgpt_model" class="form-control" required>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupLabel => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($options)): ?>
                        <optgroup label="<?php echo e($groupLabel); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(isset($settings['chatgpt_model']) && $settings['chatgpt_model'] == $key ? 'selected' : ''); ?>>
                                    <?php echo e($model); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </optgroup>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
        </div>
     </div>
     <div class="card-footer text-end p-3">
         <input class="btn btn-print-invoice  btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
     </div>
     <?php echo e(Form::close()); ?>

 </div>

 <script>
     $(document).ready(function() {
         choices();
     });
     $(document).on('change', '[name=storage_setting]', function() {
         if ($(this).val() == 's3') {
             $('.s3-setting').removeClass('d-none');
             $('.wasabi-setting').addClass('d-none');
             $('.local-setting').addClass('d-none');
         } else if ($(this).val() == 'wasabi') {
             $('.s3-setting').addClass('d-none');
             $('.wasabi-setting').removeClass('d-none');
             $('.local-setting').addClass('d-none');
         } else {
             $('.s3-setting').addClass('d-none');
             $('.wasabi-setting').addClass('d-none');
             $('.local-setting').removeClass('d-none');
         }
     });

     function check_theme(color_val) {
         $('input[value="' + color_val + '"]').prop('checked', true);
         $('a[data-value]').removeClass('active_color');
         $('a[data-value="' + color_val + '"]').addClass('active_color');
     }
     var themescolors = document.querySelectorAll(".themes-color > a");
     for (var h = 0; h < themescolors.length; h++) {
         var c = themescolors[h];

         c.addEventListener("click", function(event) {
             var targetElement = event.target;
             if (targetElement.tagName == "SPAN") {
                 targetElement = targetElement.parentNode;
             }
             var temp = targetElement.getAttribute("data-value");
             removeClassByPrefix(document.querySelector("body"), "theme-");
             document.querySelector("body").classList.add(temp);
         });
     }

     function removeClassByPrefix(node, prefix) {
         for (let i = 0; i < node.classList.length; i++) {
             let value = node.classList[i];
             if (value.startsWith(prefix)) {
                 node.classList.remove(value);
             }
         }
     }
     if ($('#useradd-sidenav').length > 0) {
         var scrollSpy = new bootstrap.ScrollSpy(document.body, {
             target: '#useradd-sidenav',
             offset: 300,
         });
     }
     $(document).on('change', '#defult_currancy', function() {
         var sy = $('#defult_currancy option:selected').attr('data-symbol');
         $('#defult_currancy_symbol').val(sy);

     });
 </script>

 
 <script>
     var custdarklayout = document.querySelector("#cust-darklayout");
     custdarklayout.addEventListener("click", function() {
         if (custdarklayout.checked) {
             document.querySelector(".m-header > .b-brand > .logo-lg").setAttribute("src",
                 "<?php echo e($logo_light); ?>");
             document.querySelector("#main-style-link").setAttribute("href",
                 "<?php echo e(asset('assets/css/style-dark.css')); ?>");
         } else {
             document.querySelector(".m-header > .b-brand > .logo-lg").setAttribute("src",
                 "<?php echo e($logo_dark); ?>");
             document.querySelector("#main-style-link").setAttribute("href",
                 "<?php echo e(asset('assets/css/style.css')); ?>");
         }
     });

     function removeClassByPrefix(node, prefix) {
         for (let i = 0; i < node.classList.length; i++) {
             let value = node.classList[i];
             if (value.startsWith(prefix)) {
                 node.classList.remove(value);
             }
         }
     }
 </script>

 
 <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($settings['enable_cookie']) && $settings['enable_cookie'] != 'on'): ?>
     <script>
         $(document).ready(function() {
             $('.cookie_setting').attr("disabled", "disabled");
         });
     </script>
 <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 <script>
     $(document).on('click', '#enable_cookie', function() {
         if ($('#enable_cookie').prop('checked')) {
             $(".cookie_setting").removeAttr("disabled");
         } else {
             $('.cookie_setting').attr("disabled", "disabled");
         }
     });
 </script>
 <script>
     function cust_theme_bg(params) {
         var custthemebg = document.querySelector("#site_transparent");
         var val = "checked";
         if (val) {
             document.querySelector(".dash-sidebar").classList.add("transprent-bg");
             document
                 .querySelector(".dash-header:not(.dash-mob-header)")
                 .classList.add("transprent-bg");
         } else {
             document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
             document
                 .querySelector(".dash-header:not(.dash-mob-header)")
                 .classList.remove("transprent-bg");
         }
     }
     if ($('#site_transparent').length > 0) {
         var custthemebg = document.querySelector("#site_transparent");
         custthemebg.addEventListener("click", function() {
             if (custthemebg.checked) {
                 document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                 document
                     .querySelector(".dash-header:not(.dash-mob-header)")
                     .classList.add("transprent-bg");
             } else {
                 document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                 document
                     .querySelector(".dash-header:not(.dash-mob-header)")
                     .classList.remove("transprent-bg");
             }
         });
     }
 </script>

 
 <script>
     $('.colorPicker').on('click', function(e) {
         $('body').removeClass('custom-color');
         if (/^theme-\d+$/) {
             $('body').removeClassRegex(/^theme-\d+$/);
         }
         $('body').addClass('custom-color');
         $('.themes-color-change').removeClass('active_color');
         $(this).addClass('active_color');
         const input = document.getElementById("color-picker");
         setColor();
         input.addEventListener("input", setColor);

         function setColor() {
             document.documentElement.style.setProperty('--color-customColor', input.value);
         }

         $(`input[name='color_flag`).val('true');
     });

     $('.themes-color-change').on('click', function() {

         $(`input[name='color_flag`).val('false');

         var color_val = $(this).data('value');
         $('body').removeClass('custom-color');
         if (/^theme-\d+$/) {
             $('body').removeClassRegex(/^theme-\d+$/);
         }
         $('body').addClass(color_val);
         $('.theme-color').prop('checked', false);
         $('.themes-color-change').removeClass('active_color');
         $('.colorPicker').removeClass('active_color');
         $(this).addClass('active_color');
         $(`input[value=${color_val}]`).prop('checked', true);
     });

     $.fn.removeClassRegex = function(regex) {
         return $(this).removeClass(function(index, classes) {
             return classes.split(/\s+/).filter(function(c) {
                 return regex.test(c);
             }).join(' ');
         });
     };
 </script>
 <script>
     $(document).ready(function() {
         sendData();

         $('.currency_note').on('change', function() {
             sendData();
         });

         function sendData() {
             var formData = $('#setting-currency-form').serialize();
             $.ajax({
                 type: 'POST',
                 url: '<?php echo e(route('admin.update.note.value')); ?>',
                 data: formData,
                 success: function(response) {
                     var formattedPrice = response.formatted_price;
                     $('#formatted_price_span').text(formattedPrice);
                 }
             });
         }
     });
 </script>

 <script>
     $(document).ready(function() {
         var maxField = 100; //Input fields increment limitation
         var addButton = $('.add_button'); //Add button selector
         var wrapper = $('.field_wrapper'); //Input field wrapper
         var fieldHTML =
             '<div class="d-flex gap-2 mb-4"><input type="text" class="form-control " placeholder="Enter ChatGPT Key" name="api_key[]" value=""/><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="ti ti-trash"></i></a></div>'; //New input field html
         var x = 1; //Initial field counter is 1

         //Once add button is clicked
         $(addButton).click(function() {
             //Check maximum number of input fields
             if (x < maxField) {
                 x++; //Increment field counter
                 $(wrapper).append(fieldHTML); //Add field html
             }
         });

         //Once remove button is clicked
         $(wrapper).on('click', '.remove_button', function(e) {
             e.preventDefault();
             $(this).parent('div').remove(); //Remove field html
             x--; //Decrement field counter
         });
     });
 </script>

<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\super-admin\settings\index.blade.php ENDPATH**/ ?>
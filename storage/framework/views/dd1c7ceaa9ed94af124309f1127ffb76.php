<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create Invoice')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Invoice')); ?>

<?php $__env->stopSection(); ?>
<?php
    $type = request()->query('type');
    $projectsid = request()->query('project_id');
?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(['url' => 'invoice', 'class' => 'w-100', 'enctype' => 'multipart/form-data', 'class' => 'needs-validation', 'novalidate'])); ?>

        <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
        <input type="hidden" name="redirect_route"  value="<?php echo e(isset($_GET['redirect_route']) ? $_GET['redirect_route'] : null); ?>">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account')): ?>
            <input type="hidden" name="invoice_type" id="invoice_type" value="product">
        <?php elseif(module_is_active('Taskly')): ?>
            <input type="hidden" name="invoice_type" id="invoice_type" value="project">
        <?php elseif(module_is_active('CMMS')): ?>
            <input type="hidden" name="invoice_type" id="invoice_type" value="parts">
        <?php elseif(module_is_active('RentalManagement')): ?>
            <input type="hidden" name="invoice_type" id="invoice_type" value="rent">
        <?php elseif(module_is_active('LMS')): ?>
            <input type="hidden" name="invoice_type" id="invoice_type" value="course">
        <?php elseif(module_is_active('MobileServiceManagement')): ?>
            <input type="hidden" name="invoice_type" id="invoice_type" value="mobileservice">
        <?php elseif(module_is_active('RestaurantMenu')): ?>
            <input type="hidden" name="invoice_type" id="invoice_type" value="restaurantmenu">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3 pb-0">
                    <div class="row row-gap">
                        <div class="col-xl-6 col-12">
                            <div class="row" id="customer-box">
                                <div class="form-group col-md-6" id="account-box">
                                    <label class="require form-label"><?php echo e(__('Account Type')); ?></label><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                                    <select
                                        class="form-control account_type <?php echo e(!empty($errors->first('account_type')) ? 'is-invalid' : ''); ?>"
                                        name="account_type" required="" id="account_type">
                                        <option value=""><?php echo e(__('Select Account Type')); ?></option>
                                        <?php echo $__env->yieldPushContent('account_type'); ?>
                                    </select>
                                    <div class="text-xs text-danger mt-1">
                                        <?php echo e(__('Please select carefully, you cannot edit the account type later.')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-6 customer">
                                    <?php echo e(Form::label('customer_id', __('Customer'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                                    
                                    <select name="customer_id" class="form-control" id="customer"
                                        data-url="<?php echo e(route('invoice.customer')); ?>" required>
                                        <option value=""><?php echo e(__('Please Select')); ?></option>

                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($customers->count())): ?>
                                        <div class=" text-xs">
                                            <?php echo e(__('Please create Customer/Client first.')); ?><a
                                                <?php if(module_is_active('Account')): ?> href="<?php echo e(route('customer.index')); ?>"  <?php else: ?> href="<?php echo e(route('users.index')); ?>" <?php endif; ?>><b><?php echo e(__('Create Customer/Client')); ?></b></a>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <div id="customer_detail" class="d-none">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="require form-label"><?php echo e(__('Billing Type')); ?></label><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                                        <select
                                            class="form-control <?php echo e(!empty($errors->first('Billing Type')) ? 'is-invalid' : ''); ?>"
                                            name="invoice_type_radio" required="" id="billing_type">
                                        </select>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('billing_type')); ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="invoice_template" class="form-label"><?php echo e(__('Template')); ?></label>
                                        <select class="form-control" name="invoice_template" id="invoice_template">
                                            <option value=""><?php echo e(__('Select Template')); ?></option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>">
                                                    <?php echo e($template); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('issue_date', __('Issue Date'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                                        <div class="form-icon-user">
                                            <?php echo e(Form::date('issue_date', date('Y-m-d'), ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Select Issue Date', 'onchange' => 'Calculate()'])); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('due_date', __('Due Date'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                                        <div class="form-icon-user">
                                            <?php echo e(Form::date('due_date', date('Y-m-d'), ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Select Due Date'])); ?>


                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group invoice_div">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account')): ?>
                                            <?php echo e(Form::label('category_id', __('Category'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                                            <?php echo e(Form::select('category_id', $category, null, ['class' => 'form-control ', 'required' => 'required'])); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($category->count())): ?>
                                                <div class=" text-xs">
                                                    <?php echo e(__('Please add constant category. ')); ?><a
                                                        href="<?php echo e(route('category.index')); ?>"><b><?php echo e(__('Add Category')); ?></b></a>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php elseif(module_is_active('Taskly')): ?>
                                            <?php echo e(Form::label('project', __('Project'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('project', $projects, null, ['class' => 'form-control ', 'required' => 'required'])); ?>

                                        <?php elseif(module_is_active('CMMS')): ?>
                                            <?php echo e(Form::label('work_order', __('Work Orders'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('work_order', $work_order, null, ['class' => 'form-control ', 'required' => 'required'])); ?>

                                        <?php elseif(module_is_active('LMS')): ?>
                                            <?php echo e(Form::label('course_order', __('Course Order'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('course_order', [], null, ['class' => 'form-control ', 'required' => 'required'])); ?>

                                        <?php elseif(module_is_active('RentalManagement')): ?>
                                            <?php echo e(Form::label('rent_type', __('Rent Type'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('rent_type', $rent_type, null, ['class' => 'form-control ', 'required' => 'required', 'onchange' => 'Calculate()'])); ?>

                                        <?php elseif(module_is_active('RestaurantMenu')): ?>
                                            <?php echo e(Form::label('restaurant_order', __('Restaurant Order'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('restaurant_order', [], null, ['class' => 'form-control ', 'required' => 'required'])); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('invoice_number', __('Invoice Number'), ['class' => 'form-label'])); ?>

                                        <div class="form-icon-user">
                                            <input type="text" class="form-control" value="<?php echo e($invoice_number); ?>"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Taskly') || module_is_active('LMS')): ?>
                                    <div
                                        class="col-md-6 tax_project_div <?php echo e(module_is_active('Account') ? 'd-none' : ''); ?>">
                                        <div class="form-group">
                                            <?php echo e(Form::label('tax_project', __('Tax'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('tax_project[]', $taxs, $isQuotation ? (!empty($quotation->items->first()->tax) ? explode(',', $quotation->items->first()->tax) : null) : null, ['class' => 'form-control get_tax multi-select choices', 'data-toggle' => 'select2', 'multiple' => 'multiple', 'id' => 'tax_project', 'data-placeholder' => 'Select Tax'])); ?>

                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account')): ?>
                                    <div class="form-group col-md-6 income_account_div d-none">
                                        <?php echo e(Form::label('sale_chartaccount_id', __('Income Account'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                                        <select name="sale_chartaccount_id" class="form-control account_id">
                                            <option value=""><?php echo e(__('Select Chart of Account')); ?></option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $incomeChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeName => $subtypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <optgroup label="<?php echo e($typeName); ?>">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtypeId => $subtypeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option disabled style="color: #000; font-weight: bold;"><?php echo e($subtypeData['account_name']); ?></option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subtypeData['chart_of_accounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chartOfAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($chartOfAccount['id']); ?>">
                                                                &nbsp;&nbsp;&nbsp;<?php echo e($chartOfAccount['account_name']); ?>

                                                            </option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subtypeData['subAccounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($chartOfAccount['id'] == $subAccount['parent']): ?>
                                                                <option value="<?php echo e($subAccount['id']); ?>" class="ms-5" > &nbsp; &nbsp;&nbsp;&nbsp; <?php echo e(' - '. $subAccount['account_name']); ?></option>
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </optgroup>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('CustomField') && !$customFields->isEmpty()): ?>
                                    <div class="col-md-12">
                                        <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                            <?php echo $__env->make('custom-field::formBuilder', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php echo $__env->yieldPushContent('add_invoices_agent_filed'); ?>

                                <?php echo $__env->yieldPushContent('add_invoices_field'); ?>

                                <?php echo $__env->yieldPushContent('calendar'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="loader" class="card card-flush">
            <div class="card-body">
                <div class="row">
                    <img class="loader" src="<?php echo e(asset('public/images/loader.gif')); ?>" alt="">
                </div>
            </div>
        </div>
        <div class="col-12 section_div">

        </div>
        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" onclick="location.href = '<?php echo e(route('invoice.index')); ?>';"
                class="btn btn-light me-2">
            <input type="submit" id="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
        </div>
        <?php echo e(Form::close()); ?>


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.repeater.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery-searchbox.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            var customerId = '<?php echo e($customerId); ?>';
            if (customerId > 0) {
                $('#account_type').val('Account').trigger('change');
            }
        });

        function deleteInvoiceItem($row, id, recalculateTotalsCallback) {
            if (confirm('Are you sure you want to delete this element?')) {
                $row.slideUp(function() {
                    $row.remove();
                    if (typeof recalculateTotalsCallback === 'function') {
                        recalculateTotalsCallback();
                    }
                });
                var invoice_type = $('#account_type');

                if(id)
                {
                    $.ajax({
                        url: '<?php echo e(route('invoice.product.destroy')); ?>',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': jQuery('#token').val()
                        },
                        data: {
                            'id': id,
                            'invoice_type': invoice_type,
                        },
                        cache: false,
                        success: function(data) {
                            if (data.error) {
                                toastrs('Error', data.error, 'error');
                            } else {
                                toastrs('Success', data.success, 'success');
                            }
                        },
                        error: function(data) {
                            toastrs('Error', '<?php echo e(__('something went wrong please try again')); ?>', 'error');
                        }
                    });
                }
            }
        }

        $(document).on('change', '#customer', function() {
            $('#customer_detail').removeClass('d-none');
            $('#customer_detail').addClass('d-block');
            $('#customer-box').addClass('d-none');

            var id = $(this).val() ?? $('#customer').val();
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': id,
                    'type': $('#invoice_type').val()
                },
                cache: false,
                success: function(data) {
                    if ($('#invoice_type').val() == 'childcare') {

                        $('#customer_detail').html(data.childrenInfo);
                        $('tbody').html(data.childrenData)

                    } else if ($('#invoice_type').val() == 'course') {
                        $('#customer_detail').html(data.html);

                        $('#course_order').empty();
                        $('#course_order').append(
                            '<option value=""><?php echo e(__('Select Course Order')); ?></option>');
                        $.each(data.courseorder, function(key, value) {
                            $('#course_order').append('<option value="' + key + '" >' + value +
                                '</option>');
                        });
                    } else if($('#invoice_type').val() == 'restaurantmenu'){
                        $('#customer_detail').html(data.html);

                        $('#restaurant_order').empty();
                        $('#restaurant_order').append(
                            '<option value=""><?php echo e(__('Select Restaurant Order')); ?></option>');
                        $.each(data.restaurantorder, function(key, value) {
                            $('#restaurant_order').append('<option value="' + key + '" >' + value +
                                '</option>');
                        });
                    }
                    else {
                        if (data != '') {
                            $('#customer_detail').html(data);
                        } else {
                            $('#customer-box').removeClass('d-none');
                            $('#customer_detail').removeClass('d-block');
                            $('#customer_detail').addClass('d-none');
                        }
                    }
                },
            });
        });

        $(document).on('click', '#remove', function() {
            $('#customer-box').removeClass('d-none');
            $('#customer_detail').removeClass('d-block');
            $('#customer_detail').addClass('d-none');
        })
    </script>
    <script>
        $(document).on('keyup', '.quantity', function() {

            var quntityTotalTaxPrice = 0;

            var el = $(this).parent().parent().parent().parent();

            var quantity = $(this).val();
            var price = $(el.find('.price')).val();
            var discount = $(el.find('.discount')).val();


            if (discount.length <= 0) {
                discount = 0;
            }
            if ($('#invoice_type').val() == 'vehicleinspection' || $('#invoice_type').val() == 'machinerepair' || $(
                    '#invoice_type').val() == 'mobileservice') {
                var service_charge = $('.service_charge').val();
                var service = parseFloat(service_charge);
            }


            var totalItemPrice = (quantity * price) - discount;

            var amount = (totalItemPrice);


            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            $(el.find('.amount')).html(parseFloat(itemTaxPrice) + parseFloat(amount));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemPrice = 0;
            var inputs_quantity = $(".quantity");

            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }

            if ($('#invoice_type').val() == 'vehicleinspection' || $('#invoice_type').val() == 'machinerepair' || $(
                    '#invoice_type').val() == 'mobileservice') {
                service = isNaN(service) ? 0 : service;

                subTotal = parseFloat(subTotal) + service;
            }

            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
        })

        $(document).on('keyup change', '.price', function() {
            var el = $(this).parent().parent().parent().parent();
            var price = $(this).val();

            var quantity = $(el.find('.quantity')).val();
            if (quantity.length <= 0) {
                quantity = 1;
            }
            var discount = $(el.find('.discount')).val();

            if (discount.length <= 0) {
                discount = 0;
            }

            if ($('#invoice_type').val() == 'vehicleinspection' || $('#invoice_type').val() == 'machinerepair' || $(
                    '#invoice_type').val() == 'mobileservice') {
                var service_charge = $('.service_charge').val();
                var service = parseFloat(service_charge);
            }
            var totalItemPrice = (quantity * price) - discount;

            var amount = (totalItemPrice);

            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            $(el.find('.amount')).html(parseFloat(itemTaxPrice) + parseFloat(amount));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');

            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemPrice = 0;
            var inputs_quantity = $(".quantity");
            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                if (inputs_quantity[j].value <= 0) {
                    inputs_quantity[j].value = 1;
                }
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }
            if ($('#invoice_type').val() == 'vehicleinspection' || $('#invoice_type').val() == 'machinerepair') {
                service = isNaN(service) ? 0 : service;

                subTotal = parseFloat(subTotal) + service;
            }
            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
        })

        $(document).on('keyup change', '.discount', function() {
            if ($('#invoice_type').val() != 'case') {

                var el = $(this).parent().parent().parent();
                var discount = $(this).val();
                if (discount.length <= 0) {
                    discount = 0;
                }

                if ($('#invoice_type').val() == 'vehicleinspection' || $('#invoice_type').val() ==
                    'machinerepair' || $(
                        '#invoice_type').val() == 'mobileservice') {
                    var service_charge = $('.service_charge').val();
                    var service = parseFloat(service_charge);
                }
                var price = $(el.find('.price')).val();
                var quantity = $(el.find('.quantity')).val();
                if (quantity.length <= 0) {
                    quantity = 1;
                }
                var totalItemPrice = (quantity * price) - discount;

                var amount = (totalItemPrice);


                var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
                var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
                $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

                $(el.find('.amount')).html(parseFloat(itemTaxPrice) + parseFloat(amount));

                var totalItemTaxPrice = 0;
                var itemTaxPriceInput = $('.itemTaxPrice');
                for (var j = 0; j < itemTaxPriceInput.length; j++) {
                    totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                }


                var totalItemPrice = 0;
                var inputs_quantity = $(".quantity");

                var priceInput = $('.price');
                for (var j = 0; j < priceInput.length; j++) {
                    totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
                }

                var inputs = $(".amount");

                var subTotal = 0;
                for (var i = 0; i < inputs.length; i++) {
                    subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                }
                if ($('#invoice_type').val() == 'vehicleinspection' || $('#invoice_type').val() ==
                    'machinerepair' || $(
                        '#invoice_type').val() == 'mobileservice') {
                    service = isNaN(service) ? 0 : service;

                    subTotal = parseFloat(subTotal) + service;
                }

                var totalItemDiscountPrice = 0;
                var itemDiscountPriceInput = $('.discount');

                for (var k = 0; k < itemDiscountPriceInput.length; k++) {
                    if (itemDiscountPriceInput[k].value == '') {
                        itemDiscountPriceInput[k].value = parseFloat(0);
                    }
                    totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
                }


                $('.subTotal').html(totalItemPrice.toFixed(2));
                $('.totalTax').html(totalItemTaxPrice.toFixed(2));

                $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
                $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));
            }
        })
    </script>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account') ||
            module_is_active('CMMS') ||
            module_is_active('RentalManagement') ||
            module_is_active('CarDealership') ||
            module_is_active('Sales') ||
            module_is_active('Fleet')): ?>
        <script>
            $(document).on('change', '.item', function() {
                var in_type = $('#invoice_type').val();
                if (in_type == 'product' || in_type == 'sales' || in_type == 'vehicleinspection' || in_type ==
                    'machinerepair' || in_type == 'cardealership' || in_type == 'musicinstitute' || in_type == 'fleet'
                    ) {
                    items($(this), 'Account');
                } else if (in_type == 'parts') {
                    items($(this), 'CMMS');
                } else if (in_type == 'rent') {
                    items($(this), 'Rental');
                }
            });

            function items(data, moduleName) {
                var iteams_id = data.val();
                var url = data.data('url');
                var el = data;

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('#token').val()
                    },
                    data: {
                        'product_id': iteams_id
                    },
                    cache: false,
                    success: function(data) {
                        var item = JSON.parse(data);
                        $(el.parent().parent().find('.quantity')).val(1);
                        if (item.product != null) {
                            $(el.parent().parent().find('.price')).val(item.product.sale_price);
                            $(el.parent().parent().parent().find('.pro_description')).val(item.product.description);

                        } else {
                            $(el.parent().parent().find('.price')).val(0);
                            $(el.parent().parent().parent().find('.pro_description')).val('');
                        }

                        var taxes = '';
                        var tax = [];
                        var totalItemTaxRate = 0;

                        if (item.taxes == 0) {
                            taxes += '-';
                        } else {
                            for (var i = 0; i < item.taxes.length; i++) {
                                taxes += '<span class="badge bg-primary p-2 px-3 me-1">' +
                                    item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' +
                                    '</span>';
                                tax.push(item.taxes[i].id);
                                totalItemTaxRate += parseFloat(item.taxes[i].rate);
                            }
                        }

                        var itemTaxPrice = 0;
                        if (item.product != null) {
                            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (item.product.sale_price * 1));
                        }
                        $(el.parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));
                        $(el.parent().parent().find('.itemTaxRate')).val(totalItemTaxRate.toFixed(2));
                        $(el.parent().parent().find('.taxes')).html(taxes);
                        $(el.parent().parent().find('.tax')).val(tax);
                        $(el.parent().parent().find('.unit')).html(item.unit);
                        $(el.parent().parent().find('.discount')).val(0);
                        $(el.parent().parent().find('.amount')).html(item.totalAmount);

                        var inputs = $(".amount");
                        var subTotal = 0;
                        for (var i = 0; i < inputs.length; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }

                        var totalItemPrice = 0;
                        var priceInput = $('.price');
                        var quantity = $('.quantity');

                        for (var j = 0; j < priceInput.length; j++) {
                                totalItemPrice += parseFloat(priceInput[j].value * quantity[j].value);
                            }

                        var totalItemTaxPrice = 0;
                        var itemTaxPriceInput = $('.itemTaxPrice');
                        for (var j = 0; j < itemTaxPriceInput.length; j++) {
                            totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                            if (item.product != null) {
                                $(el.parent().parent().find('.amount')).html(parseFloat(item.totalAmount) +
                                    parseFloat(itemTaxPriceInput[j].value));
                            }
                        }

                        var totalItemDiscountPrice = 0;
                        var itemDiscountPriceInput = $('.discount');

                        if ($('#invoice_type').val() == 'vehicleinspection' || $('#invoice_type').val() ==
                            'machinerepair' || $('#invoice_type').val() == 'mobileservice') {
                            var service_charge = $('.service_charge').val();
                            var service = parseFloat(service_charge);
                        }
                        for (var k = 0; k < itemDiscountPriceInput.length; k++) {
                            totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
                        }

                        $('.subTotal').html(totalItemPrice.toFixed(2));
                        $('.totalTax').html(totalItemTaxPrice.toFixed(2));

                        if ($('#invoice_type').val() == 'vehicleinspection' || $('#invoice_type').val() ==
                            'machinerepair' || $('#invoice_type').val() == 'mobileservice') {
                            service = isNaN(service) ? 0 : service;
                            $('.totalAmount').html((parseFloat(totalItemPrice) - parseFloat(
                                totalItemDiscountPrice) + parseFloat(totalItemTaxPrice) + service).toFixed(
                                2));

                        } else {

                            $('.totalAmount').html((parseFloat(totalItemPrice) - parseFloat(
                                    totalItemDiscountPrice) +
                                parseFloat(totalItemTaxPrice)).toFixed(2));
                        }
                    },
                });
            }
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Taskly') || module_is_active('LMS')): ?>
        <script>
            $(document).on('change', '.item', function() {
                var iteams_id = $(this).val();
                var el = $(this);
                $(el.parent().parent().find('.price')).val(0);
                $(el.parent().parent().find('.amount')).html(0);
                $(el.parent().parent().find('.taxes')).val(0);
                var proposal_type = $("#proposal_type").val();
                if (proposal_type == 'project') {
                    $("#tax_project").change();
                }
            });

            $(document).on('change', '#tax_project', function() {
                var tax_id = $(this).val();
                if (tax_id.length != 0) {
                    $.ajax({
                        type: 'post',
                        url: "<?php echo e(route('get.taxes')); ?>",
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>",
                            tax_id: tax_id,
                        },
                        beforeSend: function() {
                            $("#loader").removeClass('d-none');
                        },
                        success: function(response) {
                            var response = jQuery.parseJSON(response);
                            if (response != null) {
                                $("#loader").addClass('d-none');
                                var TaxRate = 0;
                                if (response.length > 0) {
                                    $.each(response, function(i) {
                                        TaxRate = parseInt(response[i]['rate']) + TaxRate;
                                    });
                                }
                                $(".itemTaxRate").val(TaxRate);
                                $(".price").change();
                            } else {
                                $(".itemTaxRate").val(0);
                                $(".price").change();
                                $('.section_div').html('');
                                toastrs('Error', 'Something went wrong please try again !', 'error');
                            }
                        },
                    });
                } else {
                    $(".itemTaxRate").val(0);
                    $('.taxes').html("");
                    $(".price").change();
                    $("#loader").addClass('d-none');
                }
            });
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account')): ?>
        <script>
            $(document).ready(function() {
                SectionGet('product');
            });
        </script>
    <?php elseif(module_is_active('Taskly')): ?>
        <script>
            $(document).ready(function() {
                SectionGet('project');
            });
        </script>
    <?php elseif(module_is_active('CMMS')): ?>
        <script>
            $(document).ready(function() {
                SectionGet('parts');
            });
        </script>
    <?php elseif(module_is_active('RentalManagement')): ?>
        <script>
            $(document).ready(function() {
                SectionGet('rent');
            });
        </script>
    <?php elseif(module_is_active('LMS')): ?>
        <script>
            $(document).ready(function() {
                CourseSectionGet('course');
            });
        </script>
    <?php elseif(module_is_active('RestaurantMenu')): ?>
        <script>
            $(document).ready(function() {
                SectionGet('restaurantmenu');
            });
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <script>
        $(document).on('click', '[data-repeater-delete]', function() {
            $(".price").change();
            $(".discount").change();
        });
    </script>
    <script>
        $(document).on('change', "[name='invoice_type_radio']", function() {
            const val = $(this).val();

            $(".invoice_div").parent().show();
            $(".invoice_div").empty();

            const handleProductInvoice = () => {
                $(".discount_apply_div").removeClass('d-none');
                $(".tax_project_div").addClass('d-none');
                $(".discount_project_div").addClass('d-none');
                $(".income_account_div").addClass('d-none');
                $(".account_id").removeAttr('required');
                var label =
                    `<?php echo e(Form::label('category_id', __('Category'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?> <?php echo e(Form::select('category_id', $category, null, ['class' => 'form-control', 'required' => 'required'])); ?>`;
                $(".invoice_div").append(label);
                $("#invoice_type").val('product');
                SectionGet(val);
            };
            const handleProjectInvoice = () => {
                $(".income_account_div").removeClass('d-none');
                $(".account_id").attr('required', true);
                $(".discount_apply_div").addClass('d-none');
                $(".tax_project_div").removeClass('d-none');
                $(".discount_project_div").removeClass('d-none');

                var label =
                    ` <?php echo e(Form::label('project', __('Project'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?> <?php echo e(Form::select('project', $projects, $isQuotation ? $quotation->category_id : null, ['class' => 'form-control', 'required' => 'required'])); ?>`
                $(".invoice_div").append(label);
                $("#invoice_type").val('project');
                var project_id = $("#project").val();
                <?php if($isQuotation): ?>
                    var project_id = '<?php echo e($quotation->category_id); ?>';
                <?php endif; ?>
                SectionGet(val, project_id);
            };
            const handlePartsInvoice = () => {
                $(".discount_apply_div").addClass('d-none');
                $(".tax_project_div").addClass('d-none');
                $(".discount_project_div").addClass('d-none');
                $(".income_account_div").addClass('d-none');
                $(".account_id").removeAttr('required');
                var label =
                    ` <?php echo e(Form::label('work_order', __('Work Orders'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?> <?php echo e(Form::select('work_order', $work_order, null, ['class' => 'form-control', 'required' => 'required'])); ?>`
                $(".invoice_div").append(label);
                $("#invoice_type").val('parts');
                SectionGet(val);
            };
            const handleRentInvoice = () => {
                $(".discount_apply_div").addClass('d-none');
                $(".tax_project_div").addClass('d-none');
                $(".discount_project_div").addClass('d-none');
                $(".income_account_div").addClass('d-none');
                $(".account_id").removeAttr('required');
                var label =
                    ` <?php echo e(Form::label('rent_type', __('Rent Type'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?> <?php echo e(Form::select('rent_type', $rent_type, null, ['class' => 'form-control', 'required' => 'required', 'onchange' => 'Calculate()'])); ?>`
                $(".invoice_div").append(label);
                $("#invoice_type").val('rent');
                SectionGet(val);
            };
            const handleCourseInvoice = () => {
                $(".income_account_div").removeClass('d-none');
                $(".account_id").attr('required', true);
                $(".tax_project_div").removeClass('d-none');
                var label =
                    ` <?php echo e(Form::label('course_order', __('Course Orders'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?> <?php echo e(Form::select('course_order', [], null, ['class' => 'form-control', 'required' => 'required'])); ?>`
                $(".invoice_div").append(label);
                $("#invoice_type").val('course');
            };
            const handleCaseInvoice = () => {
                $(".income_account_div").removeClass('d-none');
                $(".account_id").attr('required', true);
                $(".invoice_div").parent().hide();
                $("#invoice_type").val('case');
                $(".tax_project_div").addClass('d-none');
                SectionGet(val, 0, 'Items');
            };
            const handleSalesInvoice = () => {
                var options = '<option > Please Select </option>';
                <?php $__currentLoopData = $sale_invoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $invoice_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    var formattedInvoice =
                        '<?php echo e(Workdo\Sales\Entities\SalesInvoice::invoiceNumberFormat($invoice_id)); ?>';
                    options += `<option value="<?php echo e($id); ?>"> ${formattedInvoice} </option>`;
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                var label = `
                    <?php echo e(Form::label('sale_invoice', __('Sales Invoice'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                    <select name="sale_invoice" id="sale_invoice" class="form-control" required="required" onchange="Calculate()">
                        ${options}
                    </select>
                `;

                $(".invoice_div").append(label);
                $("#invoice_type").val('sales');
                $(".tax_project_div").addClass('d-none');
                $(".income_account_div").addClass('d-none');
                $(".account_id").removeAttr('required');
            };
            const handleNewspaperInvoice = () => {
                $(".income_account_div").removeClass('d-none');
                $(".account_id").attr('required', true);
                $(".invoice_div").parent().hide();
                $("#invoice_type").val('newspaper');
                $(".tax_project_div").addClass('d-none');
                SectionGet(val);
            };
            const handleChildcareInvoice = () => {
                $(".income_account_div").removeClass('d-none');
                $(".account_id").attr('required', true);
                $(".invoice_div").parent().hide();
                $("#invoice_type").val('childcare');
                $(".tax_project_div").addClass('d-none');
                SectionGet(val);
            };
            const handleMobileServiceInvoice = () => {
                $(document).on('keyup change', '.service_charge', function() {
                    var service_charge = $(this).val();
                    var service = parseFloat(service_charge);
                    service = isNaN(service) ? 0 : service;

                    var inputs = $(".amount");

                    var subTotal = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                    }
                    subTotal = subTotal + service;
                    $('.totalServiceCharge').html(service.toFixed(2));

                    $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
                });
                var label = `
                    <?php echo e(Form::label('repair_charge', __('Repair Charge'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                    <?php echo e(Form::number('repair_charge', null, ['class' => 'form-control service_charge', 'required' => 'required', 'id' => 'repair_charge', 'placeholder' => 'Enter Repair Charge', 'value' => '0'])); ?>

                `;
                $(".income_account_div").addClass('d-none');
                $(".account_id").removeAttr('required');
                $(".invoice_div").append(label);
                $("#invoice_type").val('mobileservice');
                $(".tax_project_div").addClass('d-none');
                SectionGet(val, $('#customer').val());
            };
            const handleVehicleOrMachineInvoice = () => {
                $(document).on('keyup change', '.service_charge', function() {
                    var service_charge = $(this).val();
                    var service = parseFloat(service_charge);
                    service = isNaN(service) ? 0 : service;

                    var inputs = $(".amount");

                    var subTotal = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                    }
                    subTotal = subTotal + service;
                    $('.totalServiceCharge').html(service.toFixed(2));

                    $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
                });

                var label = `
                    <?php echo e(Form::label('service_charge', __('Service Charge'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                    <?php echo e(Form::number('service_charge', null, ['class' => 'form-control service_charge', 'required' => 'required', 'id' => 'service_charge', 'placeholder' => 'Enter Service Charge', 'value' => '0'])); ?>

                `;
                $(".income_account_div").addClass('d-none');
                $(".account_id").removeAttr('required');
                $(".invoice_div").append(label);
                $(".tax_project_div").addClass('d-none');
                if (val == 'vehicleinspection') {

                    $("#invoice_type").val('vehicleinspection');
                } else {
                    $("#invoice_type").val('machinerepair');

                }
                SectionGet(val, $('#customer').val());
            };
            const handleCardealershipInvoice = () => {
                $(".income_account_div").removeClass('d-none');
                $(".account_id").attr('required', true);
                $(".invoice_div").parent().hide();
                $("#invoice_type").val('cardealership');
                $(".tax_project_div").addClass('d-none');
                SectionGet(val);
            };
            const handleMusicInvoice = () => {
                $(".discount_apply_div").addClass('d-none');
                $(".tax_project_div").addClass('d-none');
                $(".discount_project_div").addClass('d-none');
                $(".income_account_div").addClass('d-none');
                $(".account_id").removeAttr('required');
                $("#invoice_type").val('musicinstitute');
                SectionGet(val);
            };

            const handleFleetInvoice = () => {
                $(".income_account_div").removeClass('d-none');
                $(".account_id").attr('required', true);
                $(".invoice_div").parent().hide();
                $("#invoice_type").val('fleet');
                $(".tax_project_div").addClass('d-none');
                SectionGet(val);
            };
            const handleRestaurantInvoice = () => {
                $(".income_account_div").addClass('d-none');
                $(".account_id").removeAttr('required');
                $(".tax_project_div").addClass('d-none');
                var label =
                    ` <?php echo e(Form::label('restaurant_order', __('Restaurant Orders'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                    <?php echo e(Form::select('restaurant_order', [], null, ['class' => 'form-control', 'required' => 'required'])); ?>`
                $(".invoice_div").append(label);
                $("#invoice_type").val('restaurantmenu');
            };

            switch (val) {
                case 'product':
                    handleProductInvoice();
                    break;
                case 'project':
                    handleProjectInvoice();
                    break;
                case 'parts':
                    handlePartsInvoice();
                    break;
                case 'rent':
                    handleRentInvoice();
                    break;
                case 'course':
                    handleCourseInvoice();
                    break;
                case 'case':
                    handleCaseInvoice();
                    break;
                case 'sales':
                    handleSalesInvoice();
                    break;
                case 'newspaper':
                    handleNewspaperInvoice();
                    break;
                case 'childcare':
                    handleChildcareInvoice();
                    break;
                case 'mobileservice':
                    handleMobileServiceInvoice();
                    break;
                case 'vehicleinspection':
                case 'machinerepair':
                    handleVehicleOrMachineInvoice();
                    break;
                case 'cardealership':
                    handleCardealershipInvoice();
                    break;
                case 'musicinstitute':
                    handleMusicInvoice();
                    break;
                case 'restaurantmenu':
                    handleRestaurantInvoice();
                    break;
                case 'fleet':
                    handleFleetInvoice();
                    break;
                default:
                    break;
            }

            choices();
        });

        $(document).on('change', "#restaurant_order", function() {
            var title = 'Restaurant Menu';
            var project_id = '0';
            var restaurant_order = $(this).val();
            SectionGet('restaurantmenu', project_id, title, restaurant_order);
        });

        function SectionGet(type = 'product', project_id = "0", title = 'Project', course_order = '0') {
            var url = "<?php echo e(route('invoice.section.type')); ?>";
            var quotation_id = 0;
            var acction = 'create';
            <?php if($isQuotation): ?>
                var url = "<?php echo e(route('quotation.section.type')); ?>";
                var quotation_id = "<?php echo e($quotation->id); ?>";
                var acction = "edit";
                var project_id = "<?php echo e($quotation->category_id); ?>";
            <?php endif; ?>

            $.ajax({
                type: 'post',
                url: url,
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    type: type,
                    project_id: project_id,
                    acction: acction,
                    course_order: course_order,
                    quotation_id: quotation_id,
                },
                beforeSend: function() {
                    $("#loader").removeClass('d-none');
                },
                success: function(response) {
                    if (response != false) {
                        $('.section_div').html(response.html);
                        $("#loader").addClass('d-none');
                        $('.pro_name').text(title)
                        // for item SearchBox ( this function is  custom Js )
                        JsSearchBox();

                    } else {
                        $('.section_div').html('');
                        toastrs('Error', 'Something went wrong please try again !', 'error');
                    }
                },
            });
        }


        function CourseSectionGet(type = 'course', project_id = "0", title = 'Project', course_order = '0') {

            $.ajax({
                type: 'post',
                url: "<?php echo e(route('invoice.section.type')); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    type: type,
                    project_id: project_id,
                    acction: 'create',
                    course_order: course_order,
                },
                beforeSend: function() {
                    $("#loader").removeClass('d-none');
                },
                success: function(response) {
                    if (response != false) {
                        $('.section_div').html(response.html);
                        $("#loader").addClass('d-none');
                        $('.pro_name').text(title);
                        // for item SearchBox ( this function is  custom Js )
                        JsSearchBox();
                        var subtotal = 0;
                        var totalDiscount = 0;
                        var totalAmount = 0;
                        var value = response.order;

                        if (typeof value != 'undefined' && value.length != 0) {
                            value = JSON.parse(value);
                            $repeater.setList(value);
                            for (var i = 0; i < value.length; i++) {
                                var courseValue = value[i].course;
                                var total = value[i].price - value[i].discount;
                                var tr = $('#sortable-table tbody').find('tr').filter(function() {
                                    return $(this).find('.item').val() == courseValue;
                                    // $(this).find('.amount').html(parseFloat(value[i].price-value[i].discount));
                                }).each(function() {
                                    $(this).find('.amount').html(parseFloat(value[i].price - value[i]
                                        .discount));
                                });
                                subtotal += parseFloat(value[i].price);
                                totalDiscount += parseFloat(value[i].discount);
                                totalAmount += parseFloat(total);
                            }
                            $("#tax_project").trigger('change');
                            $('.subTotal').html(subtotal.toFixed(2));
                            $('.totalDiscount').html(totalDiscount.toFixed(2));
                            $('.totalAmount').html(totalAmount.toFixed(2));
                        }
                    } else {
                        $('.section_div').html('');
                        toastrs('Error', 'Something went wrong please try again !', 'error');
                    }
                },
            });
        }

        $(document).on('change', "#course_order", function() {
            var title = 'Course';
            var project_id = '0';
            var course_order = $(this).val();

            CourseSectionGet('course', project_id, title, course_order);

        });
        $(document).on('change', "#project", function() {
            var title = $(this).find('option:selected').text();
            var project_id = $(this).val();
            SectionGet('project', project_id, title);

        });

        $(document).on('change', "#sale_invoice", function() {
            var title = 'sales';
            var invoice_id = $(this).val();

            SectionGet('sales', invoice_id, 'sales');

        });
    </script>

    <script>
        $('#account_type').on('change', function() {
            var selection = $(this).val();
            
            $('.salesinvoice').addClass('d-none');
            if(selection == 'Account' || selection == 'Taskly' || selection == 'Sales')
            {
                $('.salesinvoice').removeClass('d-none');
            }

            $('#customer').empty();
            $('[name="invoice_type_radio"]').empty();

            $('#customer').append('<option value="">Please Select</option>');

            $.ajax({
                type: 'post',
                url: "<?php echo e(route('invoice.customers')); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    type: selection,
                },
                beforeSend: function() {
                    $(".loader-wrapper").removeClass('d-none');
                },
                success: function(response) {
                    var options = '';
                    if (response.label == 'Inspection Request') {
                        <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $invoice_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            var formattedInvoice =
                                '<?php echo e(Workdo\VehicleInspectionManagement\Entities\InspectionRequest::inspectionRequestIdFormat($invoice_id)); ?>';
                            options +=
                                `<option value="<?php echo e($id); ?>"> ${formattedInvoice} </option>`;
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    } else if (response.label == 'Repair Request') {
                        <?php $__currentLoopData = $machineRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $invoice_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            var formattedInvoice =
                                '<?php echo e(Workdo\MachineRepairManagement\Entities\MachineRepairRequest::machineRepairNumberFormat($invoice_id)); ?>';
                            options +=
                                `<option value="<?php echo e($id); ?>"> ${formattedInvoice} </option>`;
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    }
                    else {
                        $.each(response.customers, function(indexInArray, valueOfElement) {
                            options += '<option value="' + indexInArray + '">' +
                                valueOfElement + '</option>';
                        });
                    }

                    if (response.label == 'Child') {
                        $('#customer').after('<small class="text-danger childnote">Note: Only child with added nutrition will be show here.</small>');
                    }
                    else {
                        $('.childnote').addClass('d-none');
                    }

                    $('#customer').append(options);

                    $('[for="customer_id"]').html(response.label);

                    var optionsMap = {
                        'Taskly': 'Project Wise',
                        'Account': 'Item Wise',
                        'LMS': 'Course Wise',
                        'CMMS': 'Parts Wise',
                        'RentalManagement': 'Rent Wise',
                        'LegalCaseManagement': 'Case Wise',
                        'Sales': 'Sale Wise',
                        'Newspaper': 'Newspaper Wise',
                        'ChildcareManagement': 'Child Wise',
                        'MobileServiceManagement': 'Service Wise',
                        'VehicleInspectionManagement': 'Request Wise',
                        'MachineRepairManagement': 'Machine Wise',
                        'CarDealership': 'Deal Wise',
                        'MusicInstitute': 'Student Wise',
                        'RestaurantMenu': 'Order Wise',
                        'Fleet': 'Trips Wise',
                    };

                    if (optionsMap.hasOwnProperty(selection)) {
                        var value = mapSelectionToValue(selection);
                        if (value !== null) {
                            $('[name="invoice_type_radio"]').append('<option value="' + value + '">' +
                                optionsMap[selection] + '</option>').trigger('change');
                        }
                    }
                    $(".loader-wrapper").addClass('d-none');

                    <?php if($isQuotation): ?>
                        $('#customer').val('<?php echo e($quotation->customer_id); ?>').trigger('change');
                        $('#invoice_template').val('<?php echo e($quotation->quotation_template); ?>');
                        $('#due_date, #issue_date').val('<?php echo e($quotation->quotation_date); ?>');
                    <?php endif; ?>

                    <?php if($customerId > 0): ?>
                        $('#customer').val('<?php echo e($customerId); ?>').trigger('change');
                    <?php endif; ?>                    
                },
            });
        });

        var type = '<?php echo e($type); ?>';
        if(type == 'project'){
            $('#account_type').trigger('change');
        }

        function mapSelectionToValue(selection) {
            switch (selection) {
                case 'Taskly':
                    return 'project';
                case 'Account':
                    return 'product';
                case 'LMS':
                    return 'course';
                case 'CMMS':
                    return 'parts';
                case 'RentalManagement':
                    return 'rent';
                case 'LegalCaseManagement':
                    return 'case';
                case 'Sales':
                    return 'sales';
                case 'Newspaper':
                    return 'newspaper';
                case 'ChildcareManagement':
                    return 'childcare';
                case 'MobileServiceManagement':
                    return 'mobileservice';
                case 'VehicleInspectionManagement':
                    return 'vehicleinspection';
                case 'MachineRepairManagement':
                    return 'machinerepair';
                case 'CarDealership':
                    return 'cardealership';
                case 'MusicInstitute':
                    return 'musicinstitute';
                case 'RestaurantMenu':
                    return 'restaurantmenu';
                case 'Fleet':
                    return 'fleet';
                default:
                    return null;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#billing_type').on('change', function() {
                if ($(this).val() == 'rent') {
                    $('#due_date').prop('readonly', true);
                } else {
                    $('#due_date').prop('readonly', false);
                }
            });
        });
    </script>
    <script>
        function Calculate() {

            var rentType = document.getElementById('rent_type').value;
            var startDate = new Date(document.getElementById('issue_date').value);
            if (rentType === '0') {
                var endDate = startDate.toISOString().split('T')[0];
                document.getElementById('due_date').value = endDate;
            } else if (rentType === '1') {
                // Calculate end date for a week
                startDate.setDate(startDate.getDate() + 7);
            } else if (rentType === '2') {
                // Calculate end date for a month
                startDate.setMonth(startDate.getMonth() + 1);
            }

            // Format the date to 'YYYY-MM-DD'
            var endDate = startDate.toISOString().split('T')[0];

            // Set the calculated end date
            document.getElementById('due_date').value = endDate;
        }
    </script>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isQuotation): ?>
        <script>
            $('#account_type').val(
                '<?php echo e($quotation->account_type == 'Accounting' ? 'Account' : ($quotation->account_type == 'Projects' ? 'Taskly' : 'CMMS')); ?>'
                ).trigger('change');
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\invoice\create.blade.php ENDPATH**/ ?>
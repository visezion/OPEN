<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['workspace' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($workspaceModel)]); ?>
</div>
    <div class="min-h-screen px-4 py-8">
        <div class=""style="padding: 2rem;">
            <div class="space-y-4 text-center">
                <h1 class="text-3xl font-semibold text-slate-900">Register as a Church Member</h1>
                <p class="text-sm text-slate-500">
                    Share your info and we’ll notify the leadership team to welcome you properly.
                </p>
            </div><br>

            <?php if(session('success')): ?>
                <div class="rounded-1xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="rounded-1xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <ul class="list-disc list-inside space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo e(Form::open([
                'route' => ['churchly.self.register.store', $workspace],
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'class' => 'space-y-5 text-sm text-slate-700'
            ])); ?>


                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Full Name')); ?>

                        </label>
                        <?php echo e(Form::text('name', null, ['required', 'placeholder' => __('Enter Full Name'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Email Address')); ?>

                        </label>
                        <?php echo e(Form::email('email', null, ['required', 'placeholder' => __('Enter Email Address'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Phone Number')); ?>

                        </label>
                        <?php echo e(Form::text('phone', null, ['placeholder' => __('Enter Phone Number'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Date of Birth')); ?>

                        </label>
                        <?php echo e(Form::date('dob', null, ['max' => date('Y-m-d'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Gender')); ?>

                        </label>
                        <?php echo e(Form::select('gender', ['' => __('Select Gender'), 'Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'], null, ['required', 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Church Branch')); ?>

                        </label>
                        <?php echo e(Form::select('branch_id', ['' => __('Select Branch')] + $branches->toArray(), null, ['required', 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Department (optional)')); ?>

                        </label>
                        <?php echo e(Form::select('department_id', ['' => __('Select Department (Optional)')] + $departments->toArray(), null, ['class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Designation (optional)')); ?>

                        </label>
                        <?php echo e(Form::select('designation_id', ['' => __('Select Designation (Optional)')] + $designations->toArray(), null, ['class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                        <?php echo e(__('Church Date of Joining')); ?>

                    </label>
                    <?php echo e(Form::date('doj', null, ['max' => date('Y-m-d'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                        <?php echo e(__('Address')); ?>

                    </label>
                    <?php echo e(Form::textarea('address', null, ['rows' => 2, 'placeholder' => __('Enter Address'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Emergency Contact Name')); ?>

                        </label>
                        <?php echo e(Form::text('emergency_contact', null, ['required', 'placeholder' => __('Enter Emergency Contact Name'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                            <?php echo e(__('Emergency Contact Phone Number')); ?>

                        </label>
                        <?php echo e(Form::text('emergency_phone', null, ['required', 'placeholder' => __('Enter Emergency Contact Phone Number'), 'class' => 'mt-2 w-full rounded-1xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-200'])); ?>

                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2rem] text-slate-500">
                        <?php echo e(__('Upload Document (Optional)')); ?>

                    </label>
                    <?php echo e(Form::file('documents', ['class' => 'mt-2 w-full text-sm text-slate-600 file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-slate-700'])); ?>

                </div>

                <?php echo e(Form::hidden('is_active', 0)); ?>


                <div class="pt-1"><br>
                    <button type="submit" class="w-full" style="background-color: #070533ff; color: white; padding: 0.75rem; border-radius: 0.75rem; font-weight: 600;">
                        <?php echo e(__('Register')); ?>

                    </button>
                </div>

            <?php echo e(Form::close()); ?>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Providers/../Resources/views/members/self-register.blade.php ENDPATH**/ ?>
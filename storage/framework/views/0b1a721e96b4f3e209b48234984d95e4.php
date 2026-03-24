<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Languages')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Languages')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <?php if($lang != 'en'): ?>
            <div class=" pb-0">
                <div class="form-check form-switch custom-switch-v1 mt-0">
                    <input type="hidden" name="disable_lang" value="off">
                    <input type="checkbox" class="form-check-input input-primary" name="disable_lang" data-bs-placement="top"
                        title="<?php echo e(__('Enable/Disable')); ?>" id="disable_lang" data-bs-toggle="tooltip"
                        <?php echo e($langs->status == 1 ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="disable_lang"></label>
                </div>
            </div>
        <?php endif; ?>
        <?php if($lang != (\Auth::user()->lang ?? 'en')): ?>
            <?php echo e(Form::open(['route' => ['lang.destroy', $lang], 'class' => 'm-0'])); ?>

            <?php echo method_field('DELETE'); ?>
            <a href="#" class="btn btn-sm  bg-danger align-items-center bs-pass-para show_confirm me-2"
                data-bs-toggle="tooltip" title="" data-bs-original-title="Delete" aria-label="Delete"
                data-confirm-yes="delete-form-<?php echo e($lang); ?>"><i class="ti ti-trash text-white"></i></a>
            <?php echo e(Form::close()); ?>

        <?php endif; ?>

        <a href="#" class="btn btn-sm btn-primary me-2" data-ajax-popup="true" data-size="md"
            data-title="<?php echo e(__('Import Lang Zip File')); ?>" data-url="<?php echo e(route('import.lang.json.upload')); ?>"
            data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Import')); ?>">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="<?php echo e(route('export.lang.json')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            data-bs-original-title="<?php echo e(__('Export')); ?>">
            <i class="ti ti-file-export"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $modules = getshowModuleList();
        $module = Module_Alias_Name($module);
    ?>
    <div class="row">
<div class="col-12">
        <div class="card align-middle p-3 language-card">
            <ul class="nav nav-pills pb-3" id="pills-tab" role="tablist">
                <li class="nav-item px-1">
                    <a class="nav-link text-capitalize  <?php echo e($module == 'general' ? ' active' : ''); ?> "
                        href="<?php echo e(route('lang.index', [$lang])); ?>"><?php echo e(__('General')); ?></a>
                </li>
                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $item = Module_Alias_Name($item);
                    ?>
                    <li class="nav-item px-1">
                        <a class="nav-link text-capitalize  <?php echo e($module == $item ? ' active' : ''); ?> "
                            href="<?php echo e(route('lang.index', [$lang, $item])); ?>"><?php echo e($item); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('lang.index', [$key, $module])); ?>"
                                class="nav-link my-1 font-weight-bold <?php if($key == $lang): ?> active <?php endif; ?>">
                                <i class="d-lg-none d-block mr-1"></i>
                                <span class="text-break"><?php echo e(Str::ucfirst($language)); ?></span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end filter-box gap-3">
                        <div class="btn-box">
                            <input type="text" id="letter" placeholder="<?php echo e(__('Enter a letter to filter')); ?>"
                                class="form-control">
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button id="filter-btn" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                title="<?php echo e(__('Apply')); ?>"><i class="ti ti-search"></i></button>
                            <button id="reset-btn" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                title="<?php echo e(__('Reset')); ?>"><i class="ti ti-trash-off"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($module == 'general' || $module == ''): ?>
                <div class="card px-3">
                    <ul class="nav nav-pills nav-fill my-4 lang-tab">
                        <li class="nav-item">
                            <a data-href="#labels" class="nav-link active"><?php echo e(__('Labels')); ?></a>
                        </li>

                        <li class="nav-item">
                            <a data-toggle="tab" data-href="#messages" class="nav-link"><?php echo e(__('Messages')); ?> </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" action="<?php echo e(route('lang.store.data', [$lang, $module])); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="tab-content">
                            <div class="tab-pane active" id="labels">
                                <div class="row" id="labels-container">
                                    <?php $__currentLoopData = $arrLabel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-lg-6 label-item">
                                            <div class="form-group mb-3">
                                                <label class="form-label text-dark"><?php echo e($label); ?></label>
                                                <input type="text" class="form-control"
                                                    name="label[<?php echo e($label); ?>]" value="<?php echo e($value); ?>">
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php if($module == 'general' || $module == ''): ?>
                                <div class="tab-pane" id="messages">
                                    <?php $__currentLoopData = $arrMessage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fileName => $fileValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row">
                                            <div class="col-lg-12 label-item">
                                                <h6><?php echo e(ucfirst($fileName)); ?></h6>
                                            </div>
                                            <?php $__currentLoopData = $fileValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(is_array($value)): ?>
                                                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label2 => $value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(is_array($value2)): ?>
                                                            <?php $__currentLoopData = $value2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label3 => $value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(is_array($value3)): ?>
                                                                    <?php $__currentLoopData = $value3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label4 => $value4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if(is_array($value4)): ?>
                                                                            <?php $__currentLoopData = $value4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label5 => $value5): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div class="col-lg-6 label-item">
                                                                                    <div class="form-group mb-3">
                                                                                        <label
                                                                                            class="form-label text-dark"><?php echo e($fileName); ?>.<?php echo e($label); ?>.<?php echo e($label2); ?>.<?php echo e($label3); ?>.<?php echo e($label4); ?>.<?php echo e($label5); ?></label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>][<?php echo e($label2); ?>][<?php echo e($label3); ?>][<?php echo e($label4); ?>][<?php echo e($label5); ?>]"
                                                                                            value="<?php echo e($value5); ?>">
                                                                                    </div>
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php else: ?>
                                                                            <div class="col-lg-6 label-item">
                                                                                <div class="form-group mb-3">
                                                                                    <label
                                                                                        class="form-label text-dark"><?php echo e($fileName); ?>.<?php echo e($label); ?>.<?php echo e($label2); ?>.<?php echo e($label3); ?>.<?php echo e($label4); ?></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>][<?php echo e($label2); ?>][<?php echo e($label3); ?>][<?php echo e($label4); ?>]"
                                                                                        value="<?php echo e($value4); ?>">
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                    <div class="col-lg-6 label-item">
                                                                        <div class="form-group mb-3">
                                                                            <label
                                                                                class="form-label text-dark"><?php echo e($fileName); ?>.<?php echo e($label); ?>.<?php echo e($label2); ?>.<?php echo e($label3); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>][<?php echo e($label2); ?>][<?php echo e($label3); ?>]"
                                                                                value="<?php echo e($value3); ?>">
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <div class="col-lg-6 label-item">
                                                                <div class="form-group mb-3">
                                                                    <label
                                                                        class="form-label text-dark"><?php echo e($fileName); ?>.<?php echo e($label); ?>.<?php echo e($label2); ?></label>
                                                                    <input type="text" class="form-control"
                                                                        name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>][<?php echo e($label2); ?>]"
                                                                        value="<?php echo e($value2); ?>">
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="col-lg-6 label-item">
                                                        <div class="form-group mb-3">
                                                            <label
                                                                class="form-label text-dark"><?php echo e($fileName); ?>.<?php echo e($label); ?></label>
                                                            <input type="text" class="form-control"
                                                                name="message[<?php echo e($fileName); ?>][<?php echo e($label); ?>]"
                                                                value="<?php echo e($value); ?>">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="text-end">
                            <input type="submit" value="<?php echo e(__('Save Changes')); ?>"
                                class="btn btn-primary btn-block btn-submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('#filter-btn').on('click', function() {
                var letter = $('#letter').val().toLowerCase();

                if (!letter) {
                    toastrs('Error', 'Please enter at least one letter', 'error')
                    setTimeout(function() {
                        location.reload(true);
                    }, 1500);
                    return;
                }

                $('.label-item').each(function() {
                    var label = $(this).find('label').text().toLowerCase();
                    if (label.includes(letter)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#reset-btn').on('click', function() {
                location.reload();
            });
        });
    </script>

    <script>
        $(document).on('click', '.lang-tab .nav-link', function() {
            $('.lang-tab .nav-link').removeClass('active');
            $('.tab-pane').removeClass('active');
            $(this).addClass('active');
            var id = $('.lang-tab .nav-link.active').attr('data-href');
            $(id).addClass('active');
        });

        $(document).on('change', '#disable_lang', function() {
            var val = $(this).prop("checked");
            if (val == true) {
                var langMode = 1;
            } else {
                var langMode = 0;
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('disablelanguage')); ?>",
                datType: 'json',
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "mode": langMode,
                    "lang": "<?php echo e($lang); ?>"
                },
                success: function(data) {
                    toastrs('Success', data.message, 'success')
                    setTimeout(function() {
                        location.reload(true);
                    }, 1500);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\lang\index.blade.php ENDPATH**/ ?>
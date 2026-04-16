<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("page-breadcrumb"); ?>
    <?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
    <style>
        .email-template-show .card {
            border: 1px solid #d8e2ef;
            border-radius: 14px;
            box-shadow: none !important;
            background: #ffffff;
        }

        .email-template-show .card .card-body {
            padding: 18px;
        }

        .email-template-show .section-title {
            margin: 0 0 14px;
            font-size: 13px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #5f7696;
            font-weight: 700;
        }

        .email-template-show .form-group {
            margin-bottom: 14px;
        }

        .email-template-show .col-form-label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .04em;
            color: #5f7696 !important;
            margin-bottom: 6px;
        }

        .email-template-show .form-control,
        .email-template-show .note-editor.note-frame {
            border: 1px solid #d8e2ef !important;
            border-radius: 10px;
            box-shadow: none !important;
        }

        .email-template-show .variable-item {
            padding: 8px 10px;
            border: 1px solid #e3ebf7;
            border-radius: 10px;
            margin-bottom: 8px;
            background: #fbfdff;
        }

        .email-template-show .language-sidebar {
            border: 1px solid #d8e2ef !important;
            border-radius: 12px;
            box-shadow: none !important;
            top: 16px;
        }

        .email-template-show .language-sidebar .list-group-item {
            border-color: #e3ebf7 !important;
        }

        .email-template-show .language-sidebar .list-group-item.active {
            background: #ffffff !important;
            color: var(--bs-primary) !important;
            border-color: #d8e2ef !important;
            font-weight: 600;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row email-template-show">
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="section-title"><?php echo e(__('Template Info')); ?></h6>
                <?php echo e(Form::model($emailTemplate, array('route' => array('email_template.update', $emailTemplate->id), 'method' => 'PUT'))); ?>

                <div class="row">
                    <div class="form-group col-md-12">
                        <?php echo e(Form::label('name',__('Name'),['class'=>'col-form-label text-dark'])); ?>

                        <?php echo e(Form::text('name',null,array('class'=>'form-control font-style','disabled'=>'disabled'))); ?>

                    </div>
                    <div class="form-group col-md-12">
                        <?php echo e(Form::label('from',__('From'),['class'=>'col-form-label text-dark'])); ?>

                        <?php echo e(Form::text('from',null,array('class'=>'form-control font-style','required'=>'required'))); ?>

                    </div>
                    <?php echo e(Form::hidden('lang',$currEmailTempLang->lang,array('class'=>''))); ?>

                    <div class="col-12 text-end">
                        <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn btn-print-invoice  btn-primary m-r-10">
                    </div>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="section-title"><?php echo e(__('Template Variables')); ?></h6>
                <div class="row text-xs">
                    <?php
                        $variables = json_decode($currEmailTempLang->variables);
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($variables) > 0): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 pb-1">
                        <div class="variable-item">
                            <p class="mb-0"><?php echo e(__($key)); ?> : <span class="pull-right text-primary"><?php echo e('{'.$var.'}'); ?></span></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
            <div class="row g-3">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="card sticky-top language-sidebar">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="list-group-item list-group-item-action  <?php echo e(($currEmailTempLang->lang == $key)?'active':''); ?>" href="<?php echo e(route('manage.email.language',[$emailTemplate->id,$key])); ?>">
                                <?php echo e(Str::ucfirst($lang)); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    </div>

                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="section-title"><?php echo e(__('Email Content')); ?></h6>
                            <?php echo e(Form::model($currEmailTempLang, array('route' => array('store.email.language',$currEmailTempLang->parent_id), 'method' => 'PUT'))); ?>

                            <div class="row">
                                <div class="form-group col-12">
                                    <?php echo e(Form::label('subject',__('Subject'),['class'=>'col-form-label text-dark'])); ?>

                                    <?php echo e(Form::text('subject',null,array('class'=>'form-control font-style','required'=>'required'))); ?>

                                </div>
                                <div class="form-group col-12">
                                    <?php echo e(Form::label('content',__('Email Message'),['class'=>'col-form-label text-dark'])); ?>

                                    <?php echo e(Form::textarea('content',$currEmailTempLang->content,array('class'=>'summernote','id'=>'content','required'=>'required'))); ?>

                                </div>

                                <div class="col-md-12 text-end mb-0">
                                    <?php echo e(Form::hidden('lang',null)); ?>

                                    <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn btn-print-invoice  btn-primary m-r-10">
                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\email_templates\show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("page-breadcrumb"); ?>
    <?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-header card-body">
                <h5></h5>
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
            <div class="card-header card-body">
                <h5></h5>
                <div class="row text-xs">

                    <h6 class="font-weight-bold mb-4"><?php echo e(__('Variables')); ?></h6>
                    <?php
                        $variables = json_decode($currEmailTempLang->variables);
                    ?>
                    <?php if(!empty($variables) > 0): ?>
                    <?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 pb-1">
                        <p class="mb-1"><?php echo e(__($key)); ?> : <span class="pull-right text-primary"><?php echo e('{'.$var.'}'); ?></span></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>



                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <h5></h5>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
                    <div class="card sticky-top language-sidebar" >
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="list-group-item list-group-item-action  <?php echo e(($currEmailTempLang->lang == $key)?'active':''); ?>" href="<?php echo e(route('manage.email.language',[$emailTemplate->id,$key])); ?>">
                                <?php echo e(Str::ucfirst($lang)); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    </div>

                <div class="col-lg-9 col-md-9 col-sm-9  card">
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

                        <div class="col-md-12 text-end mb-3">
                            <?php echo e(Form::hidden('lang',null)); ?>

                            <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn btn-print-invoice  btn-primary m-r-10">
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\email_templates\show.blade.php ENDPATH**/ ?>
<?php echo e(Form::open(array('route' => array('store.language')))); ?>

<div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('code',__('Language Code'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('code',null,array('class'=>'form-control','placeholder'=>__('Language Code'),'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('fullname',__('Full Name'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('fullname',null,array('class'=>'form-control','placeholder'=>__('Enter Language Full Name'),'required'=>'required'))); ?>

            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\lang\create.blade.php ENDPATH**/ ?>
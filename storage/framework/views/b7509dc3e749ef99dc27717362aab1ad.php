<?php echo e(Form::open(['route' => 'import.lang.json', 'method' => 'POST','enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('file', __('Upload Zip File'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::file('file',  ['class' => 'form-control', 'required' => true])); ?>

                <div class=" text-xs mt-1">
                    <span class="text-danger text-xs"><?php echo e(__('Import Zip file which you have downloaded from old version')); ?></span><br>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Import')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\lang\import.blade.php ENDPATH**/ ?>
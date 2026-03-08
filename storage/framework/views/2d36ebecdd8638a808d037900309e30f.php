<form method="POST" 
      action="<?php echo e(route('discipleship.requirement.submit', $req->id)); ?>" 
      enctype="multipart/form-data"
      class="d-inline">
    <?php echo csrf_field(); ?>

    <?php if($req->type === 'file_upload'): ?>
        <input type="file" name="evidence" class="form-control form-control-sm mb-2">
    <?php endif; ?>

    <?php if($req->type === 'custom_text'): ?>
        <input type="text" name="evidence" class="form-control form-control-sm mb-2" placeholder="Enter details">
    <?php endif; ?>

    <button type="submit" class="btn btn-sm btn-primary">
        <?php echo e(__('Submit')); ?>

    </button>
</form>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\requirements\form.blade.php ENDPATH**/ ?>
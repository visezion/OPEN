<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $member->name ?? '')); ?>" required>
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $member->email ?? '')); ?>">
</div>
<div class="mb-3">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $member->phone ?? '')); ?>">
</div>
<div class="mb-3">
    <label>Date of Birth</label>
    <input type="date" name="dob" class="form-control" value="<?php echo e(old('dob', $member->dob ?? '')); ?>">
</div>
<div class="mb-3">
    <label>Address</label>
    <input type="text" name="address" class="form-control" value="<?php echo e(old('address', $member->address ?? '')); ?>">
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\partials\form.blade.php ENDPATH**/ ?>
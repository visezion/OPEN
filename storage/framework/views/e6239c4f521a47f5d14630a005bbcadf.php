<div class="favorite-list-item">
    <?php if(!empty($user->avatar)): ?>
        <div data-id="<?php echo e($user->id); ?>" data-action="0" class="avatar av-m"
             style="background-image: url('<?php echo e(get_file($user->avatar)); ?>');">
        </div>
    <?php else: ?>
        <div data-id="<?php echo e($user->id); ?>" data-action="0" class="avatar av-m"
             style="background-image: url('<?php echo e(get_file('uploads/users-avatar/avatar.png')); ?>');">
        </div>
    <?php endif; ?>
    <p><?php echo e(strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name); ?></p>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\vendor\Chatify\layouts\favorite.blade.php ENDPATH**/ ?>
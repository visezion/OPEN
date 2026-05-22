<div <?php echo e($attributes->merge(['class' => $id])); ?>></div>
<script type="text/javascript">
    Paddle.Checkout.open(<?php echo json_encode($options(), 15, 512) ?>);
</script>
<?php /**PATH C:\xampp\htdocs\OPEN\vendor\laravel\cashier-paddle\resources\views\components\checkout.blade.php ENDPATH**/ ?>
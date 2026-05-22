<?php ($vendor = ['vendor' => (int) config('cashier.vendor_id')]); ?>

<script src="https://cdn.paddle.com/paddle/paddle.js"></script>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('cashier.sandbox')): ?>
    <script type="text/javascript">
        Paddle.Environment.set('sandbox');
    </script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<script type="text/javascript">
    Paddle.Setup(<?php echo json_encode($vendor, 15, 512) ?>);
</script>
<?php /**PATH C:\xampp\htdocs\OPEN\vendor\laravel\cashier-paddle\resources\views\js.blade.php ENDPATH**/ ?>
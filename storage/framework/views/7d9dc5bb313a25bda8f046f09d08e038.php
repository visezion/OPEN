<?php $__env->startSection('title', "Role details"); ?>

<?php $__env->startSection('content'); ?>
  <div class="flex flex-col">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-32">
      <div
        class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200 p-8"
      >
        <label class="flex justify-between w-4/12">
          <span class="text-gray-900 font-bold">Name/Code:</span>
          <span class="ml-4 text-gray-800"><?php echo e($role->name); ?></span>
        </label>

        <label class="flex justify-between w-4/12 my-4">
          <span class="text-gray-900 font-bold">Display Name:</span>
          <span class="ml-4 text-gray-800"><?php echo e($role->display_name); ?></span>
        </label>

        <label class="flex justify-between w-4/12 my-4">
          <span class="text-gray-900 font-bold">Description:</span>
          <span class="ml-4 text-gray-800"><?php echo e($role->description); ?></span>
        </label>
        <span class="text-gray-900 font-bold">Permissions:</span>
        <ul class="grid grid-cols-1 md:grid-cols-4 list-inside">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="text-gray-800 list-disc" ><?php echo e($permission->display_name ?? $permission->name); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
        <div class="flex justify-end">
          <a
            href="<?php echo e(route("laratrust.roles.index")); ?>"
            class="text-blue-600 hover:text-blue-900"
          >
            Back
          </a>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('laratrust::panel.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\vendor\santigarcor\laratrust\resources\views\panel\roles\show.blade.php ENDPATH**/ ?>
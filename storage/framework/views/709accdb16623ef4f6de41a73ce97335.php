<?php $__env->startSection('title', 'Permissions'); ?>

<?php $__env->startSection('content'); ?>
  <div class="flex flex-col">
    <?php if(config('laratrust.panel.create_permissions')): ?>
    <a
      href="<?php echo e(route('laratrust.permissions.create')); ?>"
      class="self-end bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
    >
      + New Permission
    </a>
    <?php endif; ?>
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
      <div class="mt-4 align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="th">Id</th>
              <th class="th">Name/Code</th>
              <th class="th">Display Name</th>
              <th class="th">Description</th>
              <th class="th"></th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="td text-sm leading-5 text-gray-900">
                <?php echo e($permission->getKey()); ?>

              </td>
              <td class="td text-sm leading-5 text-gray-900">
                <?php echo e($permission->name); ?>

              </td>
              <td class="td text-sm leading-5 text-gray-900">
                <?php echo e($permission->display_name); ?>

              </td>
              <td class="td text-sm leading-5 text-gray-900">
                <?php echo e($permission->description); ?>

              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                <a href="<?php echo e(route('laratrust.permissions.edit', $permission->getKey())); ?>" class="text-blue-600 hover:text-blue-900">Edit</a>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php echo e($permissions->links('laratrust::panel.pagination')); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('laratrust::panel.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\vendor\santigarcor\laratrust\resources\views\panel\permissions\index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Roles'); ?>

<?php $__env->startSection('content'); ?>
  <div class="flex flex-col">
    <a
      href="<?php echo e(route('laratrust.roles.create')); ?>"
      class="self-end bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
    >
      + New Role
    </a>
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
      <div class="mt-4 align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="th">Id</th>
              <th class="th">Display Name</th>
              <th class="th">Name</th>
              <th class="th"># Permissions</th>
              <th class="th"></th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="td text-sm leading-5 text-gray-900">
                <?php echo e($role->getKey()); ?>

              </td>
              <td class="td text-sm leading-5 text-gray-900">
                <?php echo e($role->display_name); ?>

              </td>
              <td class="td text-sm leading-5 text-gray-900">
                <?php echo e($role->name); ?>

              </td>
              <td class="td text-sm leading-5 text-gray-900">
                <?php echo e($role->permissions_count); ?>

              </td>
              <td class="flex justify-end px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                <?php if(\Laratrust\Helper::roleIsEditable($role)): ?>
                <a href="<?php echo e(route('laratrust.roles.edit', $role->getKey())); ?>" class="text-blue-600 hover:text-blue-900">Edit</a>
                <?php else: ?>
                <a href="<?php echo e(route('laratrust.roles.show', $role->getKey())); ?>" class="text-blue-600 hover:text-blue-900">Details</a>
                <?php endif; ?>
                <form
                  action="<?php echo e(route('laratrust.roles.destroy', $role->getKey())); ?>"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete the record?');"
                >
                  <?php echo method_field('DELETE'); ?>
                  <?php echo csrf_field(); ?>
                  <button
                    type="submit"
                    class="<?php echo e(\Laratrust\Helper::roleIsDeletable($role) ? 'text-red-600 hover:text-red-900' : 'text-gray-600 hover:text-gray-700 cursor-not-allowed'); ?> ml-4"
                    <?php if(!\Laratrust\Helper::roleIsDeletable($role)): ?> disabled <?php endif; ?>
                  >Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php echo e($roles->links('laratrust::panel.pagination')); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('laratrust::panel.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\vendor\santigarcor\laratrust\resources\views\panel\roles\index.blade.php ENDPATH**/ ?>
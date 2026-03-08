<?php $__env->startSection('title', 'Roles Assignment'); ?>

<?php $__env->startSection('content'); ?>
  <div class="flex flex-col">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
      <div
        x-data="{ model: <?php if($modelKey): ?> '<?php echo e($modelKey); ?>' <?php else: ?> 'initial' <?php endif; ?> }"
        x-init="$watch('model', value => value != 'initial' ? window.location = `?model=${value}` : '')"
        class="mt-4 align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200 p-4"
      >
        <span class="text-gray-700">User model to assign roles/permissions</span>
        <label class="block w-3/12">
          <select class="form-select block w-full mt-1" x-model="model">
            <option value="initial" disabled selected>Select a user model</option>
            <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($model); ?>"><?php echo e(ucwords($model)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </label>
        <div class="flex mt-4 align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg ">
          <table class="min-w-full">
            <thead>
              <tr>
                <th class="th">Id</th>
                <th class="th">Name</th>
                <th class="th"># Roles</th>
                <?php if(config('laratrust.panel.assign_permissions_to_user')): ?><th class="th"># Permissions</th><?php endif; ?>
                <th class="th"></th>
              </tr>
            </thead>
            <tbody class="bg-white">
              <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="td text-sm leading-5 text-gray-900">
                  <?php echo e($user->getKey()); ?>

                </td>
                <td class="td text-sm leading-5 text-gray-900">
                  <?php echo e($user->name ?? 'The model doesn\'t have a `name` attribute'); ?>

                </td>
                <td class="td text-sm leading-5 text-gray-900">
                  <?php echo e($user->roles_count); ?>

                </td>
                <?php if(config('laratrust.panel.assign_permissions_to_user')): ?>
                <td class="td text-sm leading-5 text-gray-900">
                  <?php echo e($user->permissions_count); ?>

                </td>
                <?php endif; ?>
                <td class="flex justify-end px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                  <a
                    href="<?php echo e(route('laratrust.roles-assignment.edit', ['roles_assignment' => $user->getKey(), 'model' => $modelKey])); ?>"
                    class="text-blue-600 hover:text-blue-900"
                  >Edit</a>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
        <?php if($modelKey): ?>
          <?php echo e($users->appends(['model' => $modelKey])->links('laratrust::panel.pagination')); ?>

        <?php endif; ?>

      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('laratrust::panel.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\vendor\santigarcor\laratrust\resources\views\panel\roles-assignment\index.blade.php ENDPATH**/ ?>
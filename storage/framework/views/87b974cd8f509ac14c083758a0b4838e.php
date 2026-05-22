<?php $__env->startSection('title', "Edit {$modelKey}"); ?>

<?php $__env->startSection('content'); ?>
  <div>
  </div>
  <div class="flex flex-col">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-32">
      <form
        method="POST"
        action="<?php echo e(route('laratrust.roles-assignment.update', ['roles_assignment' => $user->getKey(), 'model' => $modelKey])); ?>"
        class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200 p-8"
      >
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <label class="block">
          <span class="text-gray-700">Name</span>
          <input
            class="form-input mt-1 block w-full bg-gray-200 text-gray-600"
            name="name"
            placeholder="this-will-be-the-code-name"
            value="<?php echo e($user->name ?? 'The model doesn\'t have a `name` attribute'); ?>"
            readonly
            autocomplete="off"
          >
        </label>
        <span class="block text-gray-700 mt-4">Roles</span>
        <div class="flex flex-wrap justify-start mb-4">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="inline-flex items-center mr-6 my-2 text-sm" style="flex: 1 0 20%;">
              <input
                type="checkbox"
                <?php if($role->assigned && !$role->isRemovable): ?>
                class="form-checkbox focus:shadow-none focus:border-transparent text-gray-500 h-4 w-4"
                <?php else: ?>
                class="form-checkbox h-4 w-4"
                <?php endif; ?>
                name="roles[]"
                value="<?php echo e($role->getKey()); ?>"
                <?php echo $role->assigned ? 'checked' : ''; ?>

                <?php echo $role->assigned && !$role->isRemovable ? 'onclick="return false;"' : ''; ?>

              >
              <span class="ml-2 <?php echo $role->assigned && !$role->isRemovable ? 'text-gray-600' : ''; ?>">
                <?php echo e($role->display_name ?? $role->name); ?>

              </span>
            </label>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($permissions): ?>
          <span class="block text-gray-700 mt-4">Permissions</span>
          <div class="flex flex-wrap justify-start mb-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <label class="inline-flex items-center mr-6 my-2 text-sm" style="flex: 1 0 20%;">
                <input
                  type="checkbox"
                  class="form-checkbox h-4 w-4"
                  name="permissions[]"
                  value="<?php echo e($permission->getKey()); ?>"
                  <?php echo $permission->assigned ? 'checked' : ''; ?>

                >
                <span class="ml-2"><?php echo e($permission->display_name ?? $permission->name); ?></span>
              </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="flex justify-end">
          <a
            href="<?php echo e(route("laratrust.roles-assignment.index", ['model' => $modelKey])); ?>"
            class="btn btn-red mr-4"
          >
            Cancel
          </a>
          <button class="btn btn-blue" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('laratrust::panel.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\vendor\santigarcor\laratrust\resources\views\panel\roles-assignment\edit.blade.php ENDPATH**/ ?>
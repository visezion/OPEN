<?php $__env->startSection('title', $model ? "Edit {$type}" : "New {$type}"); ?>

<?php $__env->startSection('content'); ?>
  <div>
  </div>
  <div class="flex flex-col">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-32">
      <form
        x-data="laratrustForm()"
        x-init="<?php echo $model ? '' : '$watch(\'displayName\', value => onChangeDisplayName(value))'; ?>"
        method="POST"
        action="<?php echo e($model ? route("laratrust.{$type}s.update", $model->getKey()) : route("laratrust.{$type}s.store")); ?>"
        class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200 p-8"
      >
        <?php echo csrf_field(); ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($model): ?>
          <?php echo method_field('PUT'); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <label class="block">
          <span class="text-gray-700">Name/Code</span>
          <input
            class="form-input mt-1 block w-full bg-gray-200 text-gray-600 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            name="name"
            placeholder="this-will-be-the-code-name"
            :value="name"
            readonly
            autocomplete="off"
          >
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <div class="text-red-500 text-sm mt-1"><?php echo e($message); ?> </div>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </label>

        <label class="block my-4">
          <span class="text-gray-700">Display Name</span>
          <input
            class="form-input mt-1 block w-full"
            name="display_name"
            placeholder="Edit user profile"
            x-model="displayName"
            autocomplete="off"
          >
        </label>

        <label class="block my-4">
          <span class="text-gray-700">Description</span>
          <textarea
            class="form-textarea mt-1 block w-full"
            rows="3"
            name="description"
            placeholder="Some description for the <?php echo e($type); ?>"
          ><?php echo e($model->description ?? old('description')); ?></textarea>
        </label>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type == 'role'): ?>
          <span class="block text-gray-700">Permissions</span>
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
            href="<?php echo e(route("laratrust.{$type}s.index")); ?>"
            class="btn btn-red mr-4"
          >
            Cancel
          </a>
          <button class="btn btn-blue" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
  <script>
    window.laratrustForm =  function() {
      return {
        displayName: '<?php echo e($model->display_name ?? old('display_name')); ?>',
        name: '<?php echo e($model->name ?? old('name')); ?>',
        toKebabCase(str) {
          return str &&
            str
              .match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g)
              .map(x => x.toLowerCase())
              .join('-')
              .trim();
        },
        onChangeDisplayName(value) {
          this.name = this.toKebabCase(value);
        }
      }
    }
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('laratrust::panel.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\vendor\santigarcor\laratrust\resources\views\panel\edit.blade.php ENDPATH**/ ?>
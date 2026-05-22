<?php echo e(Form::open(['method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'upload_form', 'class'=>'needs-validation', 'novalidate'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12 mb-6">
            <?php echo e(Form::label('file', __('Download Sample Customer CSV File'), ['class' => 'col-form-label text-danger '])); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(check_file('uploads/sample/sample_project.csv')): ?>
                <a href="<?php echo e(asset('uploads/sample/sample_user.csv')); ?>"
                    class="btn btn-sm btn-primary btn-icon-only mx-2">
                    <i class="fa fa-download"></i>
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="col-md-12 mt-1">
            <?php echo e(Form::label('file', __('Select CSV File'), ['class' => 'col-form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
            <div class="choose-file form-group">
                <label for="file" class="col-form-label">
                    <input type="file" class="form-control" name="file" id="file" accept=".csv" name="upload_file" data-filename="upload_file" required>
                </label>
                <p class="upload_file"></p>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
    <button type="submit" value="<?php echo e(__('Upload')); ?>" class="btn btn-primary ms-2"><?php echo e(__('Upload')); ?></button>
    <a href="" data-url="<?php echo e(route('users.import.modal')); ?>" data-ajax-popup-over="true" title="<?php echo e(__('Create')); ?>" data-size="xl" data-title="<?php echo e(__('Import User CSV Data')); ?>"  class="d-none import_modal_show"></a>
</div>
<?php echo e(Form::close()); ?>

<script>
    $('#upload_form').on('submit', function(event)
    {
        event.preventDefault();
        let data = new FormData(this);
        data.append('_token', "<?php echo e(csrf_token()); ?>");
        $.ajax({
            url: "<?php echo e(route('users.import')); ?>",
            method: "POST",
            data: data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.error != '')
                {
                    toastrs('Error',data.error, 'error');
                } else {
                    $('#commonModal').modal('hide');
                    $(".import_modal_show").trigger( "click" );
                    setTimeout(function() {
                        SetData(data.output);
                    }, 700);
                }
            }
        });

    });

    if(count < 4)
    {
        var process_area = document.getElementById("process_area");
        if(process_area)
        {
            $('#process_area').html(params);
        }
        else
        {
            setTimeout(function() {
                SetData(params,count+1);
            }, 500);
        }
    }
    else
    {
        toastrs('Success', '<?php echo e(__("Something went wrong please try again!")); ?>', 'success');
    }

</script>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\users\import.blade.php ENDPATH**/ ?>
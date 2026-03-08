<?php echo e(Form::model($coupon, array('route' => array('coupons.update', $coupon->id), 'method' => 'PUT','class' => 'needs-validation', 'novalidate'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('name',__('Name'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::text('name',null,array('class'=>'form-control font-style','required'=>'required','placeholder'=>'Enter Name' ))); ?>

        </div>

        <div class="form-group col-md-12">
            <?php echo e(Form::label('type',__('Type'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::select('type',$coupanType,null,array('class'=>'form-control font-style','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6 included_module">
            <?php if($coupon->type == 'fixed'): ?>
                <?php echo e(Form::label('included_module',__('Included Plan'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('included_module[]',$plans,explode(',',$coupon->included_module),['class'=>'form-control multi-select choices','id'=>'included_module','multiple'])); ?>

            <?php endif; ?>
        </div>
        <div class="form-group col-md-6 excluded_module">
            <?php if($coupon->type == 'fixed'): ?>
                <?php echo e(Form::label('excluded_module',__('Excluded Plan'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('excluded_module[]',$plans,explode(',',$coupon->excluded_module),['class'=>'form-control multi-select choices','id'=>'excluded_module','multiple'])); ?>

            <?php endif; ?>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('minimum_spend',__('Minimum Spend'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::number('minimum_spend',null,['class'=>'form-control','required'=>'required','placeholder'=>'Enter Minimum Spend'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('maximum_spend',__('Maximum Spend'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::number('maximum_spend',null,['class'=>'form-control','required'=>'required','placeholder'=>'Enter Maximum Spend'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('discount',__('Discount'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::number('discount',null,array('class'=>'form-control','required'=>'required','step'=>'0.01','placeholder'=>'Enter Discount'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('usage_limit_per_coupon',__('Usage limit per coupon'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::number('usage_limit_per_coupon',$coupon->limit,array('class'=>'form-control','required'=>'required','placeholder'=>'Enter Usage limit per coupon'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('usage_limit_per_user',__('Usage limit per user'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::number('usage_limit_per_user',$coupon->limit_per_user,array('class'=>'form-control','required'=>'required','placeholder'=>'Enter Usage limit per user'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('expiry_date',__('Expiry Date'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::date('expiry_date',null,array('class'=>'form-control','required'=>'required','placeholder'=>'Enter Expiry Date'))); ?>

        </div>

         <div class="form-group col-md-12">
            <?php echo e(Form::label('code',__('Code'),['class'=>'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
            <?php echo e(Form::text('code',null,array('class'=>'form-control','required'=>'required'))); ?>

        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>

<script>
    $(document).ready(function(){
        $('select[name=type]').trigger('change');
    });
    $(document).on('change','#included_module', function(){

        var plansJsonString = '<?php echo $plans; ?>';
        var plans = JSON.parse(plansJsonString);
        var selectedPlans = $(this).val();
        var excludedSelected = $('#excluded_module').val();
        var filteredPlans = {};
        selectedPlans = selectedPlans ? Array.isArray(selectedPlans) ? selectedPlans : [selectedPlans] : [];

        Object.keys(plans).forEach(function(key) {
            if (!selectedPlans.includes(key)) {
                filteredPlans[key] = plans[key];
            }
        });
        var options = '';
        Object.keys(filteredPlans).forEach(function(value){
            options += '<option value=' + value + (excludedSelected.includes(value) ? ' selected' : '') + '>' + filteredPlans[value] + '</option>';

        });

        var select = `<label for="excluded_module" class="form-label">Excluded Plan</label>
                        <select class="form-control multi-select choices" name="excluded_module[]" id="excluded_module" multiple>`+options+`</select>`;
        $('.excluded_module').html(select);

        var multipleCancelButton = new Choices('#excluded_module', {
            removeItemButton: true,
        });

    });

    $(document).on('change','#excluded_module', function(){
        var plansJsonString = '<?php echo $plans; ?>';
        var plans = JSON.parse(plansJsonString);
        var selectedPlans = $(this).val();
        var includedSelected = $('#included_module').val();
        var filteredPlans = {};
        selectedPlans = selectedPlans ? Array.isArray(selectedPlans) ? selectedPlans : [selectedPlans] : [];

        Object.keys(plans).forEach(function(key) {
            if (!selectedPlans.includes(key)) {
                filteredPlans[key] = plans[key];
            }
        });

        var options = '';
        Object.keys(filteredPlans).forEach(function(value){
            options += '<option value=' + value + (includedSelected.includes(value) ? ' selected' : '') + '>' + filteredPlans[value] + '</option>';
        });

        var select = `<label for="included_module" class="form-label">Included Plan</label>
                    <select class="form-control multi-select choices" name="included_module[]" id="included_module" multiple>`+options+`</select>`;
        $('.included_module').html(select);

        var multipleCancelButton = new Choices('#included_module', {
            removeItemButton: true,
        });
    });

    $(document).on('change','select[name=type]',function(){
        var selectedVal = $(this).val();
        if(selectedVal == 'fixed'){
            renderHTML();
        }
        else{
            $('.included_module').html('');
            $('.excluded_module').html('');
        }
    });
    function renderHTML(){
        var plansJsonString = '<?php echo $plans; ?>';
        var plans = JSON.parse(plansJsonString);

        var inoption = '';
        var exoption = '';
        Object.keys(plans).forEach((value,key)=>{
            var included_module = '<?php echo e(json_encode(explode(',',$coupon->included_module))); ?>';
            var excluded_module = '<?php echo e(json_encode(explode(',',$coupon->excluded_module))); ?>';
            inoption += '<option value=' + value + (included_module.includes(value) ? ' selected' : '') + '>'+plans[value]+'</option>';
            exoption += '<option value=' + value + (excluded_module.includes(value) ? ' selected' : '') + '>'+plans[value]+'</option>';
        });
        var includedHTML = `<label for="included_module" class="form-label">Included Plan</label>
                    <select class="form-control multi-select choices" name="included_module[]" id="included_module" multiple>`+inoption+`</select>`;

        $('.included_module').html(includedHTML)

        var excludedHTML = `<label for="excluded_module" class="form-label">Excluded Plan</label>
                    <select class="form-control multi-select choices" name="excluded_module[]" id="excluded_module" multiple>`+exoption+`</select>`;

        $('.excluded_module').html(excludedHTML);

        $('#excluded_module').trigger('change');
        $('#included_module').trigger('change');
    }
</script>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\coupon\edit.blade.php ENDPATH**/ ?>
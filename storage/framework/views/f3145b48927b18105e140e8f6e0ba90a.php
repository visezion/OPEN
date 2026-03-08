<?php echo e(Form::open(['route' => 'workspace.store', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    <div class="form-group">
        <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('name', null, ['class' => 'form-control','required'=>'required','placeholder' => __('Enter Workspace Name')])); ?>

    </div>
    
    <div class="col-md-6 mb-3">
        <label for="domain_switch"><?php echo e(__('Custom domain enable')); ?></label>
        <div class="form-check form-switch custom-switch-v1 float-end">
            <input type="checkbox" name="domain_switch" class="form-check-input input-primary pointer" value="on"
                id="domain_switch">
            <label class="form-check-label" for="domain_switch"></label>
        </div>
    </div>
    <div class="row domain-setup d-none">
        <div class="col-md-6">
            <label class="btn btn-outline-primary w-100">
                <input type="radio" class="domain_click radio-button d-none" name="enable_domain" value="enable_domain"
                    id="enable_domain">
                <?php echo e(__('Domain')); ?>

            </label>
        </div>
        <div class="col-md-6">
            <label class="btn btn-outline-primary w-100 ">
                <input type="radio" class="domain_click radio-button d-none" name="enable_domain" value="enable_subdomain"
                    id="enable_subdomain">
                <?php echo e(__('Sub Domain')); ?>

            </label>
        </div>
    </div>
    <div class="row domain-setup d-none mt-3">
        <div class="form-group col-md-12 domain">
            <?php echo e(Form::label('store_domain', __('Custom Domain'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('domains', null, ['class' => 'form-control', 'placeholder' => __('xyz.com')])); ?>

            <small class="text-danger"><?php echo e(__('Note : Before add Custom Domain, your domain A record is pointing to our server IP : '. $serverIp)); ?></small>
        </div>
        <div class="form-group col-md-12 sundomain">
            <?php echo e(Form::label('store_subdomain', __('Sub Domain'), ['class' => 'form-label'])); ?>

            <div class="input-group">
                <?php echo e(Form::text('subdomain', null, ['class' => 'form-control', 'placeholder' => __('Enter Domain')])); ?>

                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">.<?php echo e($subdomain_name); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn  btn-primary'])); ?>

</div>
<?php echo e(Form::close()); ?>


<script>
    $(document).on('change', '#domain_switch', function() {
        if ($(this).is(':checked')) {
            $('.domain-setup').removeClass('d-none');
        } else {
            $('.domain-setup').addClass('d-none');
        }
        $('.sundomain').hide();
    });
    $(document).on('change', '.domain_click#enable_domain', function(e) {
        $('.domain').show();
        $('.sundomain').hide();
        $('#domainnote').show();
        $("#enable_domain").parent().addClass('active');
        $("#enable_storelink").parent().removeClass('active');
        $("#enable_subdomain").parent().removeClass('active');
    });
    $(document).on('change', '.domain_click#enable_subdomain', function(e) {
        $('.domain').hide();
        $('.sundomain').show();
        $('#domainnote').hide();
        $("#enable_subdomain").parent().addClass('active');
        $("#enable_domain").parent().removeClass('active');
        $("#enable_domain").parent().removeClass('active');
    });
</script>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views/workspace/create.blade.php ENDPATH**/ ?>
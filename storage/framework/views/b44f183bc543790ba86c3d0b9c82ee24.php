<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Proposal Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Proposal')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('change', '.status_change', function() {
            var status = this.value;
            var url = $(this).data('url');
            $.ajax({
                url: url + '?status=' + status,
                type: 'GET',
                cache: false,
                success: function(data) {
                    location.reload();
                },
            });
        });

        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')
        });
    </script>
    <script src="<?php echo e(asset('assets/js/plugins/dropzone-amd-module.min.js')); ?>"></script>
    <script>
        Dropzone.autoDiscover = false;
        myDropzone = new Dropzone("#dropzonewidget", {
            maxFiles: 20,
            maxFilesize: 20,
            parallelUploads: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.txt",
            url: "<?php echo e(route('proposal.file.upload', [$proposal->id])); ?>",
            success: function(file, response) {
                if (response.is_success) {
                    // dropzoneBtn(file, response);
                    location.reload();
                    myDropzone.removeFile(file);
                    toastrs('<?php echo e(__('Success')); ?>', 'File Successfully Uploaded', 'success');
                } else {
                    location.reload();
                    myDropzone.removeFile(response.error);
                    toastrs('Error', response.error, 'error');
                }
            },
            error: function(file, response) {
                myDropzone.removeFile(file);
                location.reload();
                if (response.error) {
                    toastrs('Error', response.error, 'error');
                } else {
                    toastrs('Error', response, 'error');
                }
            }
        });
        myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("proposal_id", <?php echo e($proposal->id); ?>);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
    <div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->is_convert == 0): ?>
            <?php if (app('laratrust')->hasPermission('proposal convert invoice')) : ?>
                <div class="action-btn mb-1">
                    <?php echo Form::open([
                        'method' => 'get',
                        'route' => ['proposal.convert', $proposal->id],
                        'id' => 'proposal-form-' . $proposal->id,
                    ]); ?>

                    <a href="#" class="btn btn-sm bg-success align-items-center bs-pass-para show_confirm"
                        data-bs-toggle="tooltip" title="" data-bs-original-title="<?php echo e(__('Convert to Invoice')); ?>"
                        aria-label="Delete" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                        data-confirm-yes="proposal-form-<?php echo e($proposal->id); ?>">
                        <i class="ti ti-exchange text-white"></i>
                    </a>
                    <?php echo e(Form::close()); ?>

                </div>
            <?php endif; // app('laratrust')->permission ?>
        <?php else: ?>
            <?php if (app('laratrust')->hasPermission('invoice show')) : ?>
                <div class="action-btn ms-2">
                    <a href="<?php echo e(route('invoice.show', \Crypt::encrypt($proposal->converted_invoice_id))); ?>"
                        class="btn btn-sm bg-success align-items-center" data-bs-toggle="tooltip"
                        title="<?php echo e(__('Already convert to Invoice')); ?>">
                        <i class="ti ti-eye text-white"></i>
                    </a>
                </div>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Retainer')): ?>
            <?php echo $__env->make('retainer::setting.convert_retainer', ['proposal' => $proposal, 'type' => 'view'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="action-btn ms-2">
            <a href="#" class="btn btn-sm bg-primary align-items-center cp_link"
                data-link="<?php echo e(route('pay.proposalpay', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id))); ?>"
                data-bs-toggle="tooltip" title="<?php echo e(__('Click to Copy Proposal Link')); ?>"
                data-original-title="<?php echo e(__('Click to Copy Proposal Link')); ?>">
                <i class="ti ti-file text-white"></i>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if (app('laratrust')->hasPermission('proposal send')) : ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->status != 4): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row timeline-wrapper">
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="progress mb-3">
                                <div class="progress-value"></div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <div class="timeline-icons ">
                                    <i class="ti ti-plus text-primary"></i>
                                </div>
                                <div class="invoice-content">
                                    <h2 class="text-primary h5 mb-2"><?php echo e(__('Create Proposal')); ?></h2>
                                    <p class="text-sm mb-3">
                                        <?php echo e(__('Created on ')); ?><?php echo e(company_date_formate($proposal->issue_date)); ?>

                                    </p>
                                    <?php if (app('laratrust')->hasPermission('proposal edit')) : ?>
                                        <a href="<?php echo e(route('proposal.edit', \Crypt::encrypt($proposal->id))); ?>"
                                            class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                            data-original-title="<?php echo e(__('Edit')); ?>">
                                            <i class="ti ti-pencil me-1"></i><?php echo e(__('Edit')); ?></a>
                                    <?php endif; // app('laratrust')->permission ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="progress mb-3">
                                <div class="<?php echo e($proposal->status !== 0 ? 'progress-value' : ''); ?>"></div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <div class="timeline-icons ">
                                    <i class="ti ti-send text-warning"></i>
                                </div>
                                <div class="invoice-content">
                                    <h6 class="text-warning h5 mb-2"><?php echo e(__('Send Proposal')); ?></h6>
                                    <p class="text-sm mb-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->status != 0): ?>
                                            <?php echo e(__('Sent on')); ?>

                                            <?php echo e(company_date_formate($proposal->send_date)); ?>

                                        <?php else: ?>
                                            <?php if (app('laratrust')->hasPermission('proposal send')) : ?>
                                                <?php echo e(__('Status')); ?> : <?php echo e(__('Not Sent')); ?>

                                            <?php endif; // app('laratrust')->permission ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->status == 0): ?>
                                        <?php if (app('laratrust')->hasPermission('proposal send')) : ?>
                                            <a href="<?php echo e(route('proposal.sent', $proposal->id)); ?>" class="btn btn-sm btn-warning"
                                                data-bs-toggle="tooltip" data-original-title="<?php echo e(__('Mark Sent')); ?>"><i
                                                    class="ti ti-send me-1"></i><?php echo e(__('Send')); ?></a>
                                        <?php endif; // app('laratrust')->permission ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="progress mb-3">
                                <div class="<?php echo e($proposal->status !== 0 ? 'progress-value' : ''); ?>"></div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <div class="timeline-icons ">
                                    <i class="ti ti-report-money text-info"></i>
                                </div>
                                <div class="invoice-content">
                                    <h6 class="text-info h5 mb-2"><?php echo e(__('Proposal Status')); ?></h6>
                                    <p class="text-sm mb-3"><?php echo e(__('Status')); ?> :
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->status == 0): ?>
                                            <span><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php elseif($proposal->status == 1): ?>
                                            <span><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php elseif($proposal->status == 2): ?>
                                            <span><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php elseif($proposal->status == 3): ?>
                                            <span><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php elseif($proposal->status == 4): ?>
                                            <span><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; // app('laratrust')->permission ?>

    <div class="row row-gap justify-content-between align-items-center mb-3">
        <div class="col-md-6">
            <ul class="nav nav-pills nav-fill cust-nav information-tab proposal-tab" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="proposal-tab" data-bs-toggle="pill" data-bs-target="#proposal"
                        type="button"><?php echo e(__('Proposal')); ?></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="proposal-attechment-tab" data-bs-toggle="pill"
                        data-bs-target="#proposal-attechment" type="button"><?php echo e(__('Attachment')); ?></button>
                </li>
            </ul>
        </div>

        <div class="col-md-6 apply-wrp d-flex align-items-center justify-content-between justify-content-md-end">
            <select class="form-control w-auto apply-credit status_change" name="status"
                data-url="<?php echo e(route('proposal.status.change', $proposal->id)); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k); ?>" <?php echo e($proposal->status == $k ? 'selected' : ''); ?>>
                        <?php echo e($val); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
            <div class="all-button-box mx-2">
                <a href="<?php echo e(route('proposal.pdf', Crypt::encrypt($proposal->id))); ?>" class="btn btn-sm btn-primary"
                    target="_blank"><?php echo e(__('Download')); ?></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="proposal" role="tabpanel"
                    aria-labelledby="pills-user-tab-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice">
                                <div class="invoice-print">
                                    <div class="row row-gap invoice-title border-1 border-bottom  pb-3 mb-3">
                                        <div class="col-sm-4  col-12">
                                            <h2 class="h3 mb-0"><?php echo e(__('Proposal')); ?></h2>
                                        </div>
                                        <div class="col-sm-8  col-12">
                                            <div
                                                class="d-flex invoice-wrp flex-wrap align-items-center gap-md-2 gap-1 justify-content-end">
                                                <div
                                                    class="d-flex invoice-date flex-wrap align-items-center justify-content-end gap-md-3 gap-1">
                                                    <p class="mb-0"><strong><?php echo e(('Issue Date')); ?> :</strong>
                                                        <?php echo e(company_date_formate($proposal->issue_date)); ?></p>
                                                </div>
                                                <h3 class="invoice-number mb-0">
                                                    <?php echo e(\App\Models\Proposal::proposalNumberFormat($proposal->proposal_id)); ?>

                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-sm-4 p-3 invoice-billed">
                                        <div class="row row-gap">
                                            <div class="col-lg-4 col-sm-6">
                                                <p class="mb-3">
                                                    <strong class="h5 mb-1"><?php echo e(__('Name ')); ?> :
                                                    </strong><?php echo e(!empty($customer->name) ? $customer->name : ''); ?>

                                                </p>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($customer->billing_name) && !empty($customer->billing_address) && !empty($customer->billing_zip)): ?>
                                                    <div>
                                                        <p class="mb-2"><strong
                                                                class="h5 mb-1 d-block"><?php echo e(__('Billed To')); ?> :</strong>
                                                            <span class="text-muted d-block" style="max-width:80%">
                                                                <?php echo e(!empty($customer->billing_name) ? $customer->billing_name : ''); ?>

                                                                <?php echo e(!empty($customer->billing_address) ? $customer->billing_address : ''); ?>

                                                                <?php echo e(!empty($customer->billing_city) ? $customer->billing_city . ' ,' : ''); ?>

                                                                <?php echo e(!empty($customer->billing_state) ? $customer->billing_state . ' ,' : ''); ?>

                                                                <?php echo e(!empty($customer->billing_zip) ? $customer->billing_zip : ''); ?>

                                                                <?php echo e(!empty($customer->billing_country) ? $customer->billing_country : ''); ?>

                                                            </span>
                                                        </p>
                                                        <p class="mb-1 text-dark">
                                                            <?php echo e(!empty($customer->billing_phone) ? $customer->billing_phone : ''); ?>

                                                        </p>
                                                        <p class="mb-0">
                                                            <strong><?php echo e(__('Tax Number ')); ?> :
                                                            </strong><?php echo e(!empty($customer->tax_number) ? $customer->tax_number : ''); ?>

                                                        </p>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>


                                            <div class="col-lg-4 col-sm-6">
                                                <p class="mb-3">
                                                    <strong class="h5 mb-1"><?php echo e(__('Email ')); ?> :
                                                    </strong><?php echo e(!empty($customer->email) ? $customer->email : ''); ?>

                                                </p>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['proposal_shipping_display']) && $company_settings['proposal_shipping_display'] == 'on'): ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($customer->shipping_name) && !empty($customer->shipping_address) && !empty($customer->shipping_zip)): ?>
                                                        <div>
                                                            <p class="mb-2">
                                                                <strong class="h5 mb-1 d-block"><?php echo e(__('Shipped To')); ?>

                                                                    :</strong>
                                                                <span class="text-muted d-block" style="max-width:80%">
                                                                    <?php echo e(!empty($customer->shipping_name) ? $customer->shipping_name : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_address) ? $customer->shipping_address : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_city) ? $customer->shipping_city . ' ,' : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_state) ? $customer->shipping_state . ' ,' : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_zip) ? $customer->shipping_zip : ''); ?>

                                                                    <?php echo e(!empty($customer->shipping_country) ? $customer->shipping_country : ''); ?>

                                                                </span>
                                                            </p>
                                                            <p class="mb-1 text-dark">
                                                                <?php echo e(!empty($customer->shipping_phone) ? $customer->shipping_phone : ''); ?>

                                                            </p>
                                                            <p class="mb-0">
                                                                <strong><?php echo e(__('Tax Number ')); ?> :
                                                                </strong><?php echo e(!empty($customer->tax_number) ? $customer->tax_number : ''); ?>

                                                            </p>
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>


                                            <div class="col-lg-2 col-sm-6">
                                                <strong class="h5 d-block mb-2"><?php echo e(__('Status')); ?> :</strong>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->status == 0): ?>
                                                    <span
                                                        class="badge fix_badge bg-primary p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                                <?php elseif($proposal->status == 1): ?>
                                                    <span
                                                        class="badge fix_badge bg-info p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                                <?php elseif($proposal->status == 2): ?>
                                                    <span
                                                        class="badge fix_badge bg-secondary p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                                <?php elseif($proposal->status == 3): ?>
                                                    <span
                                                        class="badge fix_badge bg-warning p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                                <?php elseif($proposal->status == 4): ?>
                                                    <span
                                                        class="badge fix_badge bg-danger p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($company_settings['proposal_qr_display']) && $company_settings['proposal_qr_display'] == 'on'): ?>
                                                <div class="col-lg-2 col-sm-6">
                                                    <div class="float-sm-end qr-code">
                                                        <div class="col">
                                                            <div class="float-sm-end">
                                                                <?php echo DNS2D::getBarcodeHTML(
                                                                    route('pay.proposalpay', \Illuminate\Support\Facades\Crypt::encrypt($proposal->id)),
                                                                    'QRCODE',
                                                                    2,
                                                                    2,
                                                                ); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($customFields) && count($proposal->customField) > 0): ?>
                                        <div class="px-4 mt-3">
                                            <div class="row row-gap">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-xxl-3 col-sm-6">
                                                        <strong class="d-block mb-1"><?php echo e($field->name); ?> </strong>

                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($field->type == 'attachment'): ?>
                                                            <a href="<?php echo e(get_file($proposal->customField[$field->id])); ?>"
                                                                target="_blank">
                                                                <img src=" <?php echo e(get_file($proposal->customField[$field->id])); ?> "
                                                                    class="wid-120 rounded">
                                                            </a>
                                                        <?php else: ?>
                                                            <p class="mb-0">
                                                                <?php echo e(!empty($proposal->customField[$field->id]) ? $proposal->customField[$field->id] : '-'); ?>

                                                            </p>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="invoice-summary mt-3">
                                        <div class="invoice-title border-1 border-bottom mb-3 pb-2">
                                            <h3 class="h4 mb-0"><?php echo e(__('Item Summary')); ?></h3>
                                            <small><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <table class="table mb-0 table-striped">
                                                <tr>
                                                    <th data-width="40" class="text-white bg-primary text-uppercase">#</th>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Item Type')); ?></th>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Item')); ?></th>
                                                    <?php elseif($proposal->proposal_module == 'taskly'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Project')); ?></th>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                        <th class="text-white bg-primary text-uppercase">
                                                            <?php echo e(__('Quantity')); ?>

                                                        </th>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Rate')); ?>

                                                    </th>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Discount')); ?>

                                                    </th>
                                                    <th class="text-white bg-primary text-uppercase"><?php echo e(__('Tax')); ?>

                                                    </th>
                                                    <th class="text-white bg-primary text-uppercase">
                                                        <?php echo e(__('Description')); ?></th>
                                                    <th class="text-right text-white bg-primary text-uppercase"
                                                        width="12%">
                                                        <?php echo e(__('Price')); ?><br>
                                                        <small
                                                            class="text-danger font-weight-bold"><?php echo e(__('After discount & tax')); ?></small>
                                                    </th>
                                                </tr>

                                                <?php
                                                    $totalQuantity = 0;
                                                    $totalRate = 0;
                                                    $totalTaxPrice = 0;
                                                    $totalDiscount = 0;
                                                    $taxesData = [];
                                                    $TaxPrice_array = [];
                                                ?>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $iteams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $iteam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($iteam->tax)): ?>
                                                        <?php
                                                            $taxes = \App\Models\Proposal::tax($iteam->tax);
                                                            $totalQuantity += $iteam->quantity;
                                                            $totalRate += $iteam->price;
                                                            $totalDiscount += $iteam->discount;
                                                            foreach ($taxes as $taxe) {
                                                                $taxDataPrice = \App\Models\Proposal::taxRate(
                                                                    $taxe->rate,
                                                                    $iteam->price,
                                                                    $iteam->quantity,
                                                                    $iteam->discount,
                                                                );
                                                                if (array_key_exists($taxe->name, $taxesData)) {
                                                                    $taxesData[$taxe->name] =
                                                                        $taxesData[$taxe->name] + $taxDataPrice;
                                                                } else {
                                                                    $taxesData[$taxe->name] = $taxDataPrice;
                                                                }
                                                            }
                                                        ?>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <tr>
                                                        <td><?php echo e($key + 1); ?></td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account'): ?>
                                                            <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?>

                                                            </td>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                                            </td>
                                                        <?php elseif($proposal->proposal_module == 'taskly'): ?>
                                                            
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->title : '--'); ?>

                                                            </td>
                                                        <?php elseif($proposal->proposal_module == 'cmms'): ?>
                                                            <td><?php echo e(!empty($iteam->product_type) ? Str::ucfirst($iteam->product_type) : '--'); ?>

                                                            </td>
                                                            <td><?php echo e(!empty($iteam->product()) ? $iteam->product()->name : ''); ?>

                                                            </td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                            <td><?php echo e($iteam->quantity); ?></td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <td><?php echo e(currency_format_with_sym($iteam->price)); ?></td>
                                                        <td>
                                                            <?php echo e(currency_format_with_sym($iteam->discount)); ?>

                                                        </td>
                                                        <td>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($iteam->tax)): ?>
                                                                <table>
                                                                    <?php
                                                                        $totalTaxRate = 0;
                                                                        $data = 0;
                                                                    ?>
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            $taxPrice = \App\Models\Proposal::taxRate(
                                                                                $tax->rate,
                                                                                $iteam->price,
                                                                                $iteam->quantity,
                                                                                $iteam->discount,
                                                                            );
                                                                            $totalTaxPrice += $taxPrice;
                                                                            $data += $taxPrice;
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo e($tax->name . ' (' . $tax->rate . '%)'); ?>

                                                                            </td>
                                                                            <td><?php echo e(currency_format_with_sym($taxPrice)); ?>

                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                    <?php
                                                                        array_push($TaxPrice_array, $data);
                                                                    ?>
                                                                </table>
                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </td>
                                                        <?php
                                                            $tr_tex =
                                                                array_key_exists($key, $TaxPrice_array) == true
                                                                    ? $TaxPrice_array[$key]
                                                                    : 0;
                                                        ?>
                                                        <td><?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?></td>
                                                        <td class="text-center">
                                                            <?php echo e(currency_format_with_sym($iteam->price * $iteam->quantity - $iteam->discount + $tr_tex)); ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                            <td></td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                        <td class="bg-color"><b><?php echo e(__('Total')); ?></b></td>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->proposal_module == 'account' || $proposal->proposal_module == 'cmms'): ?>
                                                            <td class="bg-color"><b><?php echo e($totalQuantity); ?></b></td>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <td class="bg-color">
                                                            <b><?php echo e(currency_format_with_sym($totalRate)); ?></b>
                                                        </td>
                                                        <td class="bg-color">
                                                            <b><?php echo e(currency_format_with_sym($totalDiscount)); ?></b>
                                                        </td>
                                                        <td class="bg-color">
                                                            <b><?php echo e(currency_format_with_sym($totalTaxPrice)); ?></b>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <?php
                                                        $colspan = 7;
                                                        $customerInvoices = ['taskly', 'account', 'cmms', 'cardealership', 'RestaurantMenu', 'rent' , 'Fleet'];

                                                        if (in_array($proposal->invoice_module, $customerInvoices)) {
                                                            $colspan = 7;
                                                        }

                                                        if ($proposal->proposal_module == 'taskly') {
                                                            $colspan = 5;
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Sub Total')); ?></td>
                                                        <td class="text-right"><b><?php echo e(currency_format_with_sym($proposal->getSubTotal())); ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="text-right"><?php echo e(__('Discount')); ?></td>
                                                        <td class="text-right"><b><?php echo e(currency_format_with_sym($proposal->getTotalDiscount())); ?></b>
                                                        </td>
                                                    </tr>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($taxesData)): ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td colspan="<?php echo e($colspan); ?>"></td>
                                                                <td class="text-right"><?php echo e($taxName); ?></td>
                                                                <td class="text-right"><b><?php echo e(currency_format_with_sym($taxPrice)); ?></b></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <tr>
                                                        <td colspan="<?php echo e($colspan); ?>"></td>
                                                        <td class="blue-text text-right"><?php echo e(__('Total')); ?></td>
                                                        <td class="blue-text text-right"><b><?php echo e(currency_format_with_sym($proposal->getTotal())); ?></b></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade" id="proposal-attechment" role="tabpanel" aria-labelledby="pills-user-tab-4">
                    <div class="row">
                        <div class="col-3">
                            <div class="card border-primary border">
                                <div class="card-body table-border-style">
                                    <div class="col-md-12 dropzone browse-file" id="dropzonewidget">
                                        <div class="dz-message my-5" data-dz-message>
                                            <span><?php echo e(__('Drop files here to upload')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="card border-primary border">
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table mb-0 pc-dt-simple" id="attachment">
                                            <thead>
                                                <tr>
                                                    <th class="text-dark"><?php echo e(__('#')); ?></th>
                                                    <th class="text-dark"><?php echo e(__('File Name')); ?></th>
                                                    <th class="text-dark"><?php echo e(__('File Size')); ?></th>
                                                    <th class="text-dark"><?php echo e(__('Date Created')); ?></th>
                                                    <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                                </tr>
                                            </thead>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $proposal_attachment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <td><?php echo e(++$key); ?></td>
                                                <td><?php echo e($attachment->file_name); ?></td>
                                                <td><?php echo e($attachment->file_size); ?></td>
                                                <td><?php echo e(company_date_formate($attachment->created_at)); ?></td>
                                                <td>
                                                    <div class="action-btn me-2">
                                                        <a href="<?php echo e(url($attachment->file_path)); ?>" data-bs-toggle="tooltip"
                                                            class="mx-3 btn btn-sm align-items-center bg-primary"
                                                            title="<?php echo e(__('Download')); ?>" target="_blank" download>
                                                            <i class="ti ti-download text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn">
                                                        <?php echo e(Form::open(['route' => ['proposal.attachment.destroy', $attachment->id], 'class' => 'm-0'])); ?>

                                                        <?php echo method_field('DELETE'); ?>
                                                        <a href="#"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                            data-confirm-yes="delete-form-<?php echo e($attachment->id); ?>">
                                                            <i class="ti ti-trash text-white text-white"></i>
                                                        </a>
                                                        <?php echo e(Form::close()); ?>

                                                    </div>
                                                </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\proposal\view.blade.php ENDPATH**/ ?>
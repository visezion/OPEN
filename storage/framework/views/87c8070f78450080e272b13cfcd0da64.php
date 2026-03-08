<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Ticket')); ?> - <?php echo e($ticket->ticket_id); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-wrapper create-ticket ticket-desc justify-content-between flex-column auth-v1">
        <div class="bg-auth-side"></div>
        <div class="auth-content">
            <div class="row align-items-center justify-content-center text-start">
                <div class="col-12">
                    <div class="card rounded-4">
                        <div class="ticket-title text-center bg-primary">
                            <h4 class="text-white mb-0"><?php echo e(__('Ticket')); ?> - <?php echo e($ticket->ticket_id); ?></h4>
                        </div>
                       <div class="card-body w-100 p-sm-4 p-3">
                        <?php echo csrf_field(); ?>
                        <div class="card mb-3">
                            <div class="card-header p-3">
                                <h6 class="mb-0"><?php echo e($ticket->name); ?>

                                    <small>(<?php echo e($ticket->created_at->diffForHumans()); ?>)</small></h6>
                            </div>
                            <div class="card-body p-3 w-100">
                                <div>
                                    <p><?php echo $ticket->description; ?></p>
                                </div>
                                <?php
                                    $attachments = json_decode($ticket->attachments);
                                ?>
                                <?php if(!is_null($attachments) && count($attachments) > 0): ?>
                                    <div>
                                        <b><?php echo e(__('Attachments')); ?> :</b>
                                        <ul class="list-group list-group-flush">
                                            <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-group-item pb-0 px-0">
                                                    <?php echo e($attachment->name); ?><a download="<?php echo e($attachment->name); ?>"
                                                        href="<?php echo e(get_file($attachment->path)); ?>" class="edit-icon py-1 ml-2"
                                                        title="<?php echo e(__('Download')); ?>"><i
                                                            class="fa fa-download ms-2"></i></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $__currentLoopData = $ticket->conversions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-3">
                                <div class="card-header p-3">
                                    <h6 class="mb-0"><?php echo e($conversion->replyBy()->name); ?>

                                        <small>(<?php echo e($conversion->created_at->diffForHumans()); ?>)</small>
                                    </h6>
                                </div>
                                <div class="card-body p-3 w-100">
                                    <div><?php echo $conversion->description; ?></div>
                                    <?php
                                        $attachments = json_decode($conversion->attachments);
                                    ?>
                                    <?php if(count($attachments)): ?>
                                        <div class="m-1">
                                            <b><?php echo e(__('Attacbhments')); ?> :</b>
                                            <ul class="list-group list-group-flush">

                                                <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="list-group-item px-0">
                                                        <?php echo e($attachment->name); ?><a download="<?php echo e($attachment->name); ?>"
                                                            href="<?php echo e(get_file($attachment->path)); ?>"
                                                            class="edit-icon py-1 ml-2" title="<?php echo e(__('Download')); ?>"><i
                                                                class="fa fa-download ms-2"></i></a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if($ticket->status != 'Closed'): ?>
                            <div class="card mb-3">
                                <div class="card-body p-3 w-100">
                                    <form method="post"
                                        action="<?php echo e(route('helpdesk-ticket.reply', [$ticket->ticket_id])); ?>"
                                        enctype="multipart/form-data" id="ckeditorForm">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label class="require form-label"><?php echo e(__('Description')); ?></label>

                                                <textarea name="reply_description"
                                                    class="form-control summernote  <?php echo e(!empty($errors->first('reply_description')) ? 'is-invalid' : ''); ?>" required
                                                    id="help-desc"><?php echo e(old('reply_description')); ?></textarea>

                                                <div class="invalid-feedback">
                                                    <?php echo e($errors->first('reply_description')); ?>

                                                </div>
                                                <p class="text-danger d-none" id="skill_validation">
                                                    <?php echo e(__('Description filed is required.')); ?></p>
                                            </div>
                                            <div class="form-group col-md-12 file-group">
                                                <label class="require form-label"><?php echo e(__('Attachments')); ?></label>
                                                <label
                                                    class="form-label"><small>(<?php echo e(__('You can select multiple files')); ?>)</small></label>
                                                <div class="choose-file form-group mb-0">
                                                    <label for="file" class="form-label mb-0">

                                                        <input type="file"
                                                            class="form-control <?php echo e($errors->has('reply_attachments') ? 'is-invalid' : ''); ?>"
                                                            multiple="" name="reply_attachments[]" id="file"
                                                            data-filename="multiple_reply_file_selection">
                                                        <div class="invalid-feedback">
                                                            <?php echo e($errors->first('reply_attachments')); ?>

                                                        </div>
                                                    </label>
                                                    <p class="multiple_reply_file_selection"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0 col-md-12">
                                            <div class="text-center">
                                                <input type="hidden" name="status" value="In Progress" />
                                                <button
                                                    class="btn btn-submit btn-primary btn-block"><?php echo e(__('Submit')); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="card">
                                <div class="card-body p-3">
                                    <p class="text-blue font-weight-bold text-center mb-0">
                                        <?php echo e(__('Ticket is closed you cannot replay.')); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                       </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>

    <script>

        $("#SummernoteForm").submit(function(e)
        {

            var desc = $("#reply_description").val();
            if(!isNaN(desc))
            {
                $('#skill_validation').removeClass('d-none')
                event.preventDefault();
            }
            else
            {
                $('#skill_validation').addClass('d-none')
            }

        });
    </script>

    <script>
        // for Choose file
        $(document).on('change', 'input[type=file]', function() {
            var names = '';
            var files = $('input[type=file]')[0].files;

            for (var i = 0; i < files.length; i++) {
                names += files[i].name + '<br>';
            }
            $('.' + $(this).attr('data-filename')).html(names);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('helpdesk_ticket.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\helpdesk_ticket\show.blade.php ENDPATH**/ ?>
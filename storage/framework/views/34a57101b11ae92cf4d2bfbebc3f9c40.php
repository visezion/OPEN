<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Reply Ticket')); ?> - <?php echo e($ticket->ticket_id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Tickets')); ?>,<?php echo e(__('Reply')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
<div>
    <?php if (app('laratrust')->hasPermission('helpdesk ticket edit')) : ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->id == $ticket->created_by || Auth::user()->type == 'super admin'): ?>
            <div class="btn btn-sm btn-info btn-icon m-1 float-end">
                <a href="#ticket-info" class="" type="button" data-bs-toggle="collapse" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="<?php echo e(__('Edit Ticket')); ?>"><i class="ti ti-pencil text-white"></i></a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; // app('laratrust')->permission ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <?php if (app('laratrust')->hasPermission('helpdesk ticket edit')) : ?>
        <?php echo e(Form::model($ticket, ['route' => ['helpdesk.update', $ticket->id], 'id' => 'ticket-info', 'class' => 'collapse mt-3 needs-validation', 'method' => 'PUT', 'enctype' => 'multipart/form-data','novalidate'])); ?>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->type == 'super admin'): ?>
                            <div class="row">
                                <div class="form-group col-md-6" id="customname">
                                    <?php
                                        $name =  'Customers';
                                    ?>
                                    <label class="require form-label"><?php echo e($name); ?></label><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                                            <select  class="form-control select_person_email" name="name"  <?php echo e(!empty($errors->first('name')) ? 'is-invalid' : ''); ?> required="">
                                                <option value=""><?php echo e(__('Select User')); ?></option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?> " <?php echo e($ticket->user_id == $key ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </select>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('name')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="require form-label"><?php echo e(__('Email')); ?></label><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                                    <input class="form-control emailAddressField <?php echo e(!empty($errors->first('email')) ? 'is-invalid' : ''); ?>"
                                        type="email" name="email" id="emailAddressField" required="" value="<?php echo e($ticket->email); ?>"
                                        placeholder="<?php echo e(__('Email')); ?>" readonly  style="background-color:#e9ecef ">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('email')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('email')); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Category')); ?></label><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                                <select class="form-select <?php echo e(!empty($errors->first('category')) ? 'is-invalid' : ''); ?>"
                                    name="category" required="">
                                    <option value=""><?php echo e(__('Select Category')); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if($ticket->category == $category->id): ?> selected <?php endif; ?>>
                                            <?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('category')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('category')); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Status')); ?></label><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                                <select class="form-select <?php echo e(!empty($errors->first('status')) ? 'is-invalid' : ''); ?>"
                                    name="status" required="">
                                    <option value="In Progress" <?php if($ticket->status == 'In Progress'): ?> selected <?php endif; ?>>
                                        <?php echo e(__('In Progress')); ?></option>
                                    <option value="On Hold" <?php if($ticket->status == 'On Hold'): ?> selected <?php endif; ?>>
                                        <?php echo e(__('On Hold')); ?></option>
                                    <option value="Closed" <?php if($ticket->status == 'Closed'): ?> selected <?php endif; ?>>
                                        <?php echo e(__('Closed')); ?></option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('status')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('status')); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Subject')); ?></label><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
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
                                <input class="form-control <?php echo e(!empty($errors->first('subject')) ? 'is-invalid' : ''); ?>"
                                    type="text" name="subject" required="" value="<?php echo e($ticket->subject); ?>"
                                    placeholder="<?php echo e(__('Subject')); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('subject')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('subject')); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Attachments')); ?>

                                    <small>(<?php echo e(__('You can select multiple files')); ?>)</small> </label>
                                <div class="choose-file form-group">
                                    <label for="file" class="form-label d-block">


                                        <input type="file" name="attachments[]" id="file"
                                            class="form-control mb-2 <?php echo e($errors->has('attachments') ? ' is-invalid' : ''); ?>"
                                            multiple="" data-filename="multiple_file_selection"
                                            onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">

                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('attachments')); ?>

                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-12 ">
                                <div class="mx-3">
                                    <p class="multiple_file_selection mb-0"></p>
                                    <div class="w-100 attachment_list row">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($ticket->attachments)): ?>
                                            <?php $attachments = json_decode($ticket->attachments); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-auto px-0 mt-2">
                                                    <a download="" href="<?php echo e(get_file($attachment->path)); ?>"
                                                        class="btn btn-sm btn-primary d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>"><i
                                                            class="ti ti-arrow-bar-to-down me-2"></i>
                                                        <?php echo e($attachment->name); ?></a>

                                                    <a class="bg-danger ms-2 mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        title="<?php echo e(__('Delete')); ?>"
                                                        onclick="(confirm('Are You Sure?')?(document.getElementById('user-form-<?php echo e($index); ?>').submit()):'');"><i
                                                            class="ti ti-trash text-white"></i></a>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12 mt-2">
                                <label class="require form-label"><?php echo e(__('Description')); ?></label>
                                <textarea name="description"
                                    class="form-control summernote <?php echo e(!empty($errors->first('description')) ? 'is-invalid' : ''); ?>" id="description"><?php echo $ticket->description; ?></textarea>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('description')): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('description')); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <div class="text-end">
                            <a class="btn btn-secondary me-1"
                                href="<?php echo e(route('helpdesk.index')); ?>"><?php echo e(__('Cancel')); ?></a>
                            <button class="btn btn-primary btn-block btn-submit" type="submit"><?php echo e(__('Update')); ?></button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <?php echo e(Form::close()); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($ticket->attachments)): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <form method="post" id="user-form-<?php echo e($index); ?>"
                    action="<?php echo e(route('helpdesk-ticket.attachment.destroy', [$ticket->id, $index])); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                </form>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; // app('laratrust')->permission ?>
    <div class="row mt-3">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6>
                            <span class="text-left">
                                <?php echo e($ticket->name); ?> <small>(<?php echo e($ticket->created_at->diffForHumans()); ?>)</small>
                                <span class="d-block"><small><?php echo e($ticket->email); ?></small></span>
                            </span>
                        </h6>
                        <small>
                            <span class="text-right">
                                <?php echo e(__('Status')); ?> : <span
                                    class="badge <?php if($ticket->status == 'In Progress'): ?> badge bg-warning  <?php elseif($ticket->status == 'On Hold'): ?> badge bg-danger <?php else: ?> badge bg-success <?php endif; ?>"><?php echo e(__($ticket->status)); ?></span>
                            </span>
                            <span class="d-block">
                                <?php echo e(__('Category')); ?> : <span
                                    class="badge bg-primary"><?php echo e($ticket->tcategory ? $ticket->tcategory->name : '-'); ?></span>
                            </span>
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <p><?php echo $ticket->description; ?></p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($ticket->attachments)): ?>
                        <?php $attachments = json_decode($ticket->attachments); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($attachments)): ?>
                            <div class="m-1">
                                <h6><?php echo e(__('Attachments')); ?> :</h6>
                                <ul class="list-group list-group-flush">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item px-0">
                                            <?php echo e($attachment->name); ?> <a download=""
                                                href="<?php echo e(get_file($attachment->path)); ?>" class="edit-icon py-1 ml-2"
                                                title="<?php echo e(__('Download')); ?>"><i class="fas fa-download ms-2"></i></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $ticket->conversions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div class="card-header">
                        <h6><?php echo e($conversion->replyBy()->name); ?>

                            <small>(<?php echo e($conversion->created_at->diffForHumans()); ?>)</small>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div><?php echo $conversion->description; ?></div>
                        <?php $attachments = json_decode($conversion->attachments); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($attachments)): ?>
                            <div class="m-1">
                                <h6><?php echo e(__('Attachments')); ?> :</h6>
                                <ul class="list-group list-group-flush">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item px-0">
                                            <?php echo e($attachment->name); ?><a download=""
                                                href="<?php echo e(get_file($attachment->path)); ?>" class="edit-icon py-1 ml-2"
                                                title="<?php echo e(__('Download')); ?>"><i class="fa fa-download ms-2"></i></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <?php if (app('laratrust')->hasPermission('helpdesk ticket reply')) : ?>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h6><?php echo e(__('Add Reply')); ?>

                                </h6>
                            </div>
                            <form method="post" id="SummernoteForm" action="<?php echo e(route('helpdesk-ticket.conversion.store', $ticket->id)); ?>"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="require form-label"><?php echo e(__('Description')); ?></label>
                                        <textarea name="reply_description" class="form-control summernote" id="reply_description"></textarea>
                                        <div class="invalid-feedback d-block ">
                                            <?php echo e($errors->first('reply_description')); ?>

                                        </div>
                                    </div>

                                    <p class="text-danger d-none" id="skill_validation"><?php echo e(__('Description filed is required.')); ?></p>
                                    <div class="form-group file-group">
                                        <label class="require form-label"><?php echo e(__('Attachments')); ?></label>
                                        <label
                                            class="form-label"><small>(<?php echo e(__('You can select multiple files')); ?>)</small></label>
                                        <div class="choose-file">
                                            <label for="file" class="form-label d-block">

                                                <input type="file" name="reply_attachments[]" id="file"
                                                    class="form-control mb-2 <?php echo e($errors->has('reply_attachments') ? ' is-invalid' : ''); ?>"
                                                    multiple="" data-filename="multiple_reply_file_selection"
                                                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">

                                                <div class="invalid-feedback">
                                                    <?php echo e($errors->first('reply_attachments.*')); ?>

                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <p class="multiple_reply_file_selection"></p>
                                    <div class="text-end">
                                        <button class="btn btn-primary btn-block mt-2 btn-submit"
                                            type="submit" id="save"><?php echo e(__('Submit')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h6><?php echo e(__('Note')); ?>

                                </h6>
                            </div>
                            <form method="post" id="notesform" action="<?php echo e(route('helpdesk-ticket.note.store', $ticket->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="card-body adjust_card_width">
                                    <div class="form-group ckfix_height">
                                        <textarea name="note" class="form-control summernote" id="note"><?php echo e($ticket->note); ?></textarea>

                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('note')); ?>

                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary btn-block mt-2 btn-submit"
                                            type="submit"><?php echo e(__('Add Note')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; // app('laratrust')->permission ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
        $("#notesform").submit(function(e)
        {
            var desc = $("#notesform iframe").val().find("body").text();
            if(!isNaN(desc))
            {
                $('#note_validation').removeClass('d-none')
                event.preventDefault();
            }
            else
            {
                $('#note_validation').addClass('d-none')
            }

        });
    </script>
    <script>
        $(document).on('change', '.select_person_email', function() {
            var userId = $(this).val();
            $.ajax({
                url: '<?php echo e(route('helpdesk-tickets.getuser')); ?>',
                type: 'POST',
                data: {
                    "user_id": userId,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    if(data.email)
                    {
                        $('.emailAddressField').val(data.email);
                        $('.emailAddressField').prop('readonly', true);
                        $('.emailAddressField').css('background-color', '#e9ecef');
                    }else{
                        $('.emailAddressField').val('');
                        $('.emailAddressField').prop('readonly', false);
                        $('.emailAddressField').css('background-color', '');
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('css'); ?>
    <style>
        .attachment_list li {
            list-style: none;
            display: inline;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\helpdesk_ticket\edit.blade.php ENDPATH**/ ?>
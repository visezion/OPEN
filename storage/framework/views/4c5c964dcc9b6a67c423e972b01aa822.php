

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Feedback Management ')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Feedback Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
        
    </style>
    <span>
          
         <a href="<?php echo e(route('feedback.dashboard')); ?>" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Feedback Dashboard">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
        <a href="<?php echo e(route('feedback.create')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> 
        </a>
   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <!-- Filters -->
            

            <!-- Feedback Table -->
            <div class="card">
                <div class="card-body table-responsive"> 
                    <form method="GET" action="<?php echo e(route('feedback.index')); ?>" class="row mb-3 g-2 align-items-end">
                       <div class="col-md-2 d-flex align-items-center">
                            <label class="form-label me-2 mb-0" for="per_page"><?php echo e(__('Pages:')); ?></label>
                            <select name="per_page" id="per_page" class="form-control form-control-sm w-auto me-2">
                                <?php $__currentLoopData = [10, 15, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($size); ?>" <?php echo e(request('per_page', 15) == $size ? 'selected' : ''); ?>>
                                        <?php echo e($size); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="form-label mb-0"><?php echo e(__('entries')); ?></span>
                        </div>

                        <div class="col-md-2">
                            <select name="type" class="form-control form-control-sm">
                                <option value=""><?php echo e(__('All Types')); ?></option>
                                <option value="internal" <?php echo e(request('type') == 'internal' ? 'selected' : ''); ?>><?php echo e(__('Internal')); ?></option>
                                <option value="public" <?php echo e(request('type') == 'public' ? 'selected' : ''); ?>><?php echo e(__('Public')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control form-control-sm">
                                <option value=""><?php echo e(__('All Statuses')); ?></option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                <option value="reviewed" <?php echo e(request('status') == 'reviewed' ? 'selected' : ''); ?>><?php echo e(__('Reviewed')); ?></option>
                                <option value="resolved" <?php echo e(request('status') == 'resolved' ? 'selected' : ''); ?>><?php echo e(__('Resolved')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-control form-control-sm">
                                <option value=""><?php echo e(__('All Categories')); ?></option>
                                <option value="suggestion" <?php echo e(request('category') == 'suggestion' ? 'selected' : ''); ?>><?php echo e(__('Suggestion')); ?></option>
                                <option value="complaint" <?php echo e(request('category') == 'complaint' ? 'selected' : ''); ?>><?php echo e(__('Complaint')); ?></option>
                                <option value="praise" <?php echo e(request('category') == 'praise' ? 'selected' : ''); ?>><?php echo e(__('Praise')); ?></option>
                                <option value="other" <?php echo e(request('category') == 'other' ? 'selected' : ''); ?>><?php echo e(__('Other')); ?></option>
                            </select>
                        </div>
                         <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search with (title or message)" value="<?php echo e(request('search')); ?>">
                        </div>
                         
                        <div class="col-md-1">
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="ti ti-filter"></i>
                            </button>
                        </div>
                    </form>

                    <table class="table table-bordered" id="feedback-table">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Depertment')); ?></th>
                                <th><?php echo e(__('Title')); ?></th>
                                <th><?php echo e(__('Type')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Submitted By')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                   <td><?php echo e($item->department->name ?? 'No Department'); ?></td>
                                    <td><?php echo e($item->title ?? 'No Title'); ?></td>
                                    <td><span class="badge bg-info"><?php echo e(ucfirst($item->type)); ?></span></td>
                                    <td><span class="badge bg-<?php echo e($item->status == 'pending' ? 'warning' : ($item->status == 'reviewed' ? 'primary' : 'success')); ?>"><?php echo e(ucfirst($item->status)); ?></span></td>
                                    <td><?php echo e($item->is_anonymous ? 'Anonymous' : ($item->name ?? 'N/A')); ?></td>
                                    <td><?php echo e($item->created_at->format('d M Y')); ?></td>
                                    <td>
                                         <?php if (app('laratrust')->hasPermission('feedback review')) : ?>
                                            <a href="<?php echo e(route('feedback.review', \Illuminate\Support\Facades\Crypt::encrypt( $item->id))); ?>" class="btn btn-sm btn-outline-primary" title="Review"><i class="ti ti-file"></i></a>
                                        <?php endif; // app('laratrust')->permission ?>
                                        <a href="<?php echo e(route('feedback.show', \Illuminate\Support\Facades\Crypt::encrypt( $item->id))); ?>" class="btn btn-sm btn-outline-info" title="Review"><i class="ti ti-eye"></i></a>
                                        <?php if (app('laratrust')->hasPermission('feedback edit')) : ?>
                                            <a href="<?php echo e(route('feedback.edit', \Illuminate\Support\Facades\Crypt::encrypt( $item->id))); ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="ti ti-edit"></i></a>
                                        <?php endif; // app('laratrust')->permission ?>
                                       <?php if (app('laratrust')->hasPermission('feedback delete')) : ?>
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['feedback.destroy', Crypt::encrypt($item->id)], 'class' => 'delete-feedback-form', 'style'=>'display:inline']); ?>

                                            <button type="submit" class="btn btn-sm btn-outline-danger show_confirm" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        <?php echo Form::close(); ?>

                                    <?php endif; // app('laratrust')->permission ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
              
                    <?php if($feedbacks->hasPages()): ?>
                       <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap small text-muted">
                        <div class="mb-2 mb-md-0">
                            Showing <strong><?php echo e($feedbacks->firstItem()); ?></strong> to <strong><?php echo e($feedbacks->lastItem()); ?></strong> of <strong><?php echo e($feedbacks->total()); ?></strong> results
                        </div>
                        <div> 
                           <?php echo e($feedbacks->links('pagination::bootstrap-5')); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\index.blade.php ENDPATH**/ ?>
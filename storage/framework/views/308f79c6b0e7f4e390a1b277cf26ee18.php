<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<style>
    .settings-page .setting-sidebar {
        top: 16px !important;
        border: 1px solid #d8e2ef;
        border-radius: 14px;
        box-shadow: none !important;
        background: #ffffff;
    }

    .settings-page .setting-sidebar .list-group-item {
        border-color: #e3ebf7 !important;
        padding: 12px 14px;
    }

    .settings-page .setting-sidebar .list-group-item.active,
    .settings-page .setting-sidebar .list-group-item:hover {
        background: #ffffff !important;
        color: var(--bs-primary) !important;
        border-color: #d8e2ef !important;
    }

    .settings-page .setting-menu-div {
        min-height: 420px;
    }

    .settings-page .setting-menu-div .card {
        border: 1px solid #d8e2ef;
        border-radius: 14px;
        box-shadow: none !important;
        background: #ffffff;
    }

    .settings-page .setting-menu-div .card-header {
        border-bottom: 1px solid #d8e2ef;
        background: #ffffff;
    }

    .settings-page .setting-menu-div .card-footer {
        border-top: 1px solid #d8e2ef;
        background: #ffffff;
    }

    .settings-page .setting-menu-div .form-control,
    .settings-page .setting-menu-div .form-select,
    .settings-page .setting-menu-div .select2-container--default .select2-selection--single,
    .settings-page .setting-menu-div .select2-container--default .select2-selection--multiple,
    .settings-page .setting-menu-div .note-editor.note-frame {
        border-color: #d8e2ef !important;
        box-shadow: none !important;
    }

    .settings-page .setting-menu-div .table-responsive {
        border: 1px solid #d8e2ef;
        border-radius: 12px;
        box-shadow: none !important;
        background: #ffffff;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row settings-page g-3">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top setting-sidebar">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <?php echo getSettingMenu(); ?>

                        </div>
                    </div>
                </div>
                <div class="col-xl-9 setting-menu-div">
                    
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>

        <script>
            $(document).ready(function() {
                loadSettingSectionFromHash();
            });

            $(document).on("click", ".setting-menu-nav", function(e) {
                e.preventDefault();

                var hash = ($(this).attr('href') || '').replace('#', '');
                if (hash && window.location.hash !== '#' + hash) {
                    window.location.hash = hash;
                    return;
                }

                setActiveSettingNav($(this));
                var module = $(this).attr('data-module');
                var method = $(this).attr('data-method');
                getSettingSection(module, method);
            });

            $(window).on('hashchange', function() {
                loadSettingSectionFromHash();
            });

            function loadSettingSectionFromHash() {
                var hash = (window.location.hash || '').replace('#', '');
                var targetNav = null;

                if (hash) {
                    targetNav = $('.setting-menu-nav').filter(function() {
                        return ($(this).attr('href') || '') === '#' + hash;
                    }).first();
                }

                if (!targetNav || !targetNav.length) {
                    targetNav = $('.setting-menu-nav').first();
                }

                if (targetNav && targetNav.length) {
                    setActiveSettingNav(targetNav);
                    var module = targetNav.attr('data-module');
                    var method = targetNav.attr('data-method');
                    getSettingSection(module, method);
                } else {
                    getSettingSection('Base');
                }
            }

            function setActiveSettingNav(navItem) {
                $('.setting-menu-nav').removeClass('active');
                navItem.addClass('active');
            }

            function getSettingSection(module,method = null) {

                var url = '<?php echo e(route("setting.section.get", ["module" => ":module", "method" => ":method"])); ?>';
                url = url.replace(':module', module);
                url = url.replace(':method', method ? method : '');

                $.ajax({
                    url: url,
                    type: 'get',
                    beforeSend: function() {
                        $(".loader-wrapper").removeClass('d-none');
                    },
                    success: function(data) {
                        $(".loader-wrapper").addClass('d-none');

                        if (data.status == 200) {
                            $('.setting-menu-div').empty();
                            $('.setting-menu-div').append(data.html);
                        } else {
                            // error code
                        }
                    },
                    error: function(xhr) {
                        $(".loader-wrapper").addClass('d-none');
                        toastrs('Error', xhr.responseJSON.error, 'error');
                    }
                });
            }
        </script>

    <script>
        /* Open Test Mail Modal */
        $(document).on('click', '.test-mail', function(e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');
            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');

                $.post(url, {
                    custom_email: $("#custom_email").val(),
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_host: $("#mail_host").val(),

                    _token: "<?php echo e(csrf_token()); ?>",
                }, function(data) {
                    $('#commonModal .body').html(data);
                });
            }
        })
        /* End Test Mail Modal */

        /* Test Mail Send
        ----------------------------------------*/

        $(document).on('click', '#test-send-mail', function() {
            $('#test-mail-form').ajaxForm({
                beforeSend: function() {
                    $(".loader-wrapper").removeClass('d-none');
                },
                success: function(res) {
                    $(".loader-wrapper").addClass('d-none');
                    if (res.flag == 1) {
                        toastrs('Success', res.msg, 'success');
                        $('#commonModal').modal('hide');
                    } else {
                        toastrs('Error', res.msg, 'error');
                    }
                },
                error: function(xhr) {
                    $(".loader-wrapper").addClass('d-none');
                    toastrs('Error', xhr.responseJSON.error, 'error');
                }
            }).submit();
        });
    </script>

    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/settings/index.blade.php ENDPATH**/ ?>
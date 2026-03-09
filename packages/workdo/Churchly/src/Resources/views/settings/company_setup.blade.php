<div id="church-sidenav" class="card">
    <div class="card-header p-3">
        <h5>{{ __('Church Setup') }}</h5>
        <small class="text-muted">{{ __('Manage branch, department, designation, forms, messaging, and pathway setup.') }}</small>
    </div>
    <div class="card-body p-3">
        @include('churchly::layouts.churchly_setup')
    </div>
</div>

@extends('layouts.main')

@section('page-title')
    {{ __('App Builder') }}
@endsection

@section('page-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('App Builder') }}</li>
@endsection

@section('page-action')
    <div>
        <a href="{{ route('app-builder.publish') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-upload"></i> {{ __('Publish Settings') }}
        </a>
        <a href="{{ route('app-builder.layout') }}" class="btn btn-sm btn-outline-secondary ms-2">
            <i class="ti ti-apps"></i> {{ __('Home Layout') }}
        </a>
        <a href="{{ route('churchly.api.docs') }}" class="btn btn-sm btn-outline-info ms-2">
            <i class="ti ti-book"></i> {{ __('API Docs') }}
        <a href="{{ route('churchly.google.credentials') }}" class="btn btn-sm btn-outline-success ms-2">
            <i class="ti ti-brand-google"></i> {{ __("Google Integration") }}
        <a href="{{ route('cms.pages') }}" class="btn btn-sm btn-outline-primary ms-2">
            <i class="ti ti-layout"></i> {{ __("Website CMS") }}
        </a>
        </a>
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="appBuilderTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="branding-tab" data-bs-toggle="tab" data-bs-target="#branding" type="button" role="tab">
                            <i class="ti ti-palette"></i> {{ __('Branding') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab">
                            <i class="ti ti-toggle-left"></i> {{ __('Features') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button" role="tab">
                            <i class="ti ti-layout-grid"></i> {{ __('Menu Layout') }}
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="appBuilderTabsContent">
                    <div class="tab-pane fade show active" id="branding" role="tabpanel" aria-labelledby="branding-tab">
                        @include('churchly::app-builder._branding')
                    </div>
                    <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                        @include('churchly::app-builder._features')
                    </div>
                    <div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
                        @include('churchly::app-builder._menu')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Live Preview Side Panel --}}
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card shadow-sm">
            <div class="card-header"><h6>{{ __('Live Preview') }}</h6></div>
            <div class="card-body text-center">
                <div id="livePreviewContainer" class="phone-frame mx-auto">
                    <div id="phoneScreen" class="phone-screen d-flex flex-column justify-content-between">
                        {{-- Header --}}
                        <div class="phone-header text-white p-2 fw-bold" id="previewHeader">
                            {{ optional($profile)->app_name ?? 'Church App' }}
                        </div>

                        {{-- Body / Feature area --}}
                        <div class="phone-body flex-grow-1 d-flex align-items-center justify-content-center">
                            <div id="previewFeatures" class="w-100 px-2 text-center">
                                <i class="ti ti-device-mobile text-white-50" style="font-size:64px;"></i>
                                <div class="mt-2 small text-white-50">{{ __('Toggle features to preview') }}</div>
                            </div>
                        </div>

                        {{-- Bottom Menu --}}
                        <div class="phone-nav d-flex justify-content-around p-2" id="previewMenu">
                            @foreach($menus as $item)
                                @if($item->visible)
                                <div class="nav-item text-center">
                                    <i class="{{ $item->icon_name ?? 'ti ti-circle' }} text-white"></i><br>
                                    <small class="text-white-50">{{ $item->title }}</small>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <small class="text-muted d-block mt-2">{{ __('Preview updates live as you edit') }}</small>
            </div>

        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.phone-frame {
    width: 240px; height: 480px;
    border: 12px solid #000; border-radius: 30px;
    overflow: hidden; position: relative;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
}
.phone-screen {
    width: 100%; height: 100%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
}
</style>

<style>
.phone-frame {
    width: 260px; height: 520px;
    border: 12px solid #000; border-radius: 30px;
    overflow: hidden; position: relative;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    background: #4A6CF7;
}
.phone-screen {
    width: 100%; height: 100%;
    color: #fff; font-family: "Inter", sans-serif;
}
.phone-header { background: rgba(255,255,255,0.15); text-align:center; }
.phone-body { background: transparent; }
.phone-nav {
    background: rgba(0,0,0,0.25);
    backdrop-filter: blur(3px);
}
.phone-nav .nav-item { width: 25%; font-size: 12px; }

#phoneScreen, #previewMenu, #previewHeader {
    transition: all .4s ease;
}

</style>

@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const colorInputs = document.querySelectorAll('input[type=color]');
    const nameInput = document.querySelector('input[name=app_name]');
    const preview = document.getElementById('appPreview');

    function updatePreview() {
        const primary = document.querySelector('input[name=primary_color]').value;
        const name = nameInput.value || 'Church App';
        preview.style.backgroundColor = primary;
        preview.querySelector('p').innerText = name;
    }

    colorInputs.forEach(i => i.addEventListener('input', updatePreview));
    nameInput.addEventListener('input', updatePreview);
});
</script>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const appNameInput = document.querySelector('input[name=app_name]');
    const primaryInput = document.querySelector('input[name=primary_color]');
    const menuTable = document.getElementById('sortableMenu');
    const previewHeader = document.getElementById('previewHeader');
    const previewScreen = document.getElementById('phoneScreen');
    const previewMenu = document.getElementById('previewMenu');

    function updatePreview() {
        const appName = appNameInput?.value || 'Church App';
        const primary = primaryInput?.value || '#4A6CF7';

        previewHeader.innerText = appName;
        previewScreen.style.backgroundColor = primary;

        // rebuild menu icons live
        const rows = menuTable?.querySelectorAll('tr') || [];
        let html = '';
        rows.forEach(row => {
            const title = row.querySelector('input[name*="[title]"]')?.value || '';
            const icon = row.querySelector('input[name*="[icon_name]"]')?.value || 'ti ti-circle';
            const visible = row.querySelector('input[name*="[visible]"]')?.checked;
            if (visible && title) {
                html += `
                    <div class="nav-item text-center">
                        <i class="${icon} text-white"></i><br>
                        <small class="text-white-50">${title}</small>
                    </div>`;
            }
        });
        previewMenu.innerHTML = html || '<div class="text-white-50 small w-100 text-center">No menu</div>';

        // features preview (pills)
        const featureChecks = document.querySelectorAll('#features input[type=checkbox][name^="features"][name$="[enabled]"]');
        let fhtml = '';
        featureChecks.forEach((chk, idx) => {
            const keyInput = chk.parentElement?.querySelector('input[type=hidden][name^="features"][name$="[feature_key]"]');
            const key = keyInput?.value || '';
            if (chk.checked && key) {
                fhtml += `<span class="badge rounded-pill bg-white text-dark m-1">${key}</span>`;
            }
        });
        const feats = document.getElementById('previewFeatures');
        if (feats) feats.innerHTML = fhtml || '<i class="ti ti-device-mobile text-white-50" style="font-size:64px;"></i><div class="mt-2 small text-white-50">'+"{{ __('Toggle features to preview') }}"+'</div>';
    }

    // color and name
    [appNameInput, primaryInput].forEach(el => el?.addEventListener('input', updatePreview));

    // listen for menu changes (delegation)
    document.addEventListener('input', function(e){
        if(e.target.closest('#sortableMenu') || e.target.closest('#features')) updatePreview();
    });

    updatePreview(); // initial render
});
</script>
@endpush

@endpush

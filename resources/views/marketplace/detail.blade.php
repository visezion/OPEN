@extends($layout)

@php
    $description = trim((string) ($module->description ?? ''));
    if ($description === '') {
        $description = __('This add-on is installed and available in the system, but it does not include a custom marketplace detail page. Use the links below to explore pricing or continue to the add-on catalog.');
    }

    $screenshots = $marketplaceAssets ?? [];
    $heroImage = $screenshots[0] ?? ($module->image ?? null);
    $galleryImages = count($screenshots) > 1 ? array_slice($screenshots, 1) : [];
@endphp

@section('page-title')
    {{ __('Software Details') }}
@endsection

@section('content')
    <div class="wrapper">
        <section class="product-main-section padding-bottom padding-top">
            <div class="offset-container offset-left">
                <div class="row row-gap align-items-center pdp-summery-row">
                    <div class="col-lg-6 col-md-6 col-12 pdp-left-side">
                        <div class="pdp-summery">
                            <div class="section-title">
                                <div class="subtitle">{{ __('Add-on') }}</div>
                                <h2>{{ $module->alias }}</h2>
                            </div>
                            <p>{{ $description }}</p>
                            <div class="price">
                                <ins>
                                    <span class="currency-type">{{ super_currency_format_with_sym($module->monthly_price ?? 0) }}</span>
                                    <span class="time-lbl text-muted">{{ __('/Month') }}</span>
                                </ins>
                                <ins>
                                    <span class="currency-type">{{ super_currency_format_with_sym($module->yearly_price ?? 0) }}</span>
                                    <span class="time-lbl text-muted">{{ __('/Year') }}</span>
                                </ins>
                            </div>
                            <div class="cart-view btn-group">
                                <a href="{{ route('apps.pricing') }}" class="btn-secondary">{{ __('Buy Now') }}</a>
                                <a href="{{ route('apps.software') }}" class="link-btn">{{ __('Browse Add-ons') }}</a>
                            </div>
                            <div class="mt-4">
                                <p class="mb-1"><strong>{{ __('Module') }}:</strong> {{ $module->name }}</p>
                                <p class="mb-1"><strong>{{ __('Package Namespace') }}:</strong> {{ $module->package_name ?? __('N/A') }}</p>
                                <p class="mb-0"><strong>{{ __('Version') }}:</strong> {{ $module->version ?? '1.0' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 pdp-left-side">
                        <div class="pdp-image-wrapper">
                            <div class="pdp-media banner-img-wrapper">
                                @if (!empty($heroImage))
                                    <img src="{{ $heroImage }}" alt="{{ $module->alias }}" class="inner-frame-img">
                                @else
                                    <img src="{{ asset('market_assets/images/banner-image.png') }}" alt="{{ $module->alias }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (count($galleryImages) > 0)
            <section class="screenshot-section padding-top padding-bottom">
                <div class="container">
                    <div class="section-title text-center">
                        <h2>{{ __('Screenshots') }}</h2>
                    </div>
                    <div class="screenshot-slider">
                        @foreach ($galleryImages as $image)
                            <div class="screenshot-itm">
                                <div class="screenshot-image">
                                    <a href="{{ $image }}" target="_blank" class="img-zoom">
                                        <img src="{{ $image }}" alt="{{ $module->alias }}">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="bg-white padding-top padding-bottom">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ __('Explore More Add-ons') }}</h2>
                    <p>{{ __('Browse other installed modules from the marketplace catalog.') }}</p>
                </div>
                @if (count($modules) > 0)
                    <div class="row product-row">
                        @foreach ($modules as $relatedModule)
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 product-card">
                                <div class="product-card-inner">
                                    <div class="product-img">
                                        <a href="{{ route('software.details', $relatedModule->alias) }}">
                                            <img src="{{ $relatedModule->image }}" alt="{{ $relatedModule->alias }}">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="{{ route('software.details', $relatedModule->alias) }}">{{ $relatedModule->alias }}</a>
                                        </h4>
                                        <div class="price">
                                            <ins>
                                                <span class="currency-type">{{ super_currency_format_with_sym($relatedModule->monthly_price ?? 0) }}</span>
                                                <span class="time-lbl text-muted">{{ __('/Month') }}</span>
                                            </ins>
                                            <ins>
                                                <span class="currency-type">{{ super_currency_format_with_sym($relatedModule->yearly_price ?? 0) }}</span>
                                                <span class="time-lbl text-muted">{{ __('/Year') }}</span>
                                            </ins>
                                        </div>
                                        <a href="{{ route('software.details', $relatedModule->alias) }}" class="btn cart-btn">{{ __('View Details') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

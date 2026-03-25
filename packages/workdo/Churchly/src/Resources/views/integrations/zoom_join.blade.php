@extends('layouts.main')

@section('page-title', __('Join Zoom Meeting'))

@push('css')
    <link rel="stylesheet" href="https://source.zoom.us/5.1.4/css/bootstrap.css">
    <link rel="stylesheet" href="https://source.zoom.us/5.1.4/css/react-select.css">
    <style>
        .zoom-join-page {
            --zoom-ink: #17324d;
            --zoom-muted: #6b7d90;
            --zoom-line: #d7e0e8;
            --zoom-soft: #f6f8fb;
            --zoom-primary: #1f5f93;
            --zoom-primary-soft: #ecf4fb;
            --zoom-success: #2e7d5a;
            --zoom-success-soft: #edf8f1;
            --zoom-warning: #9c6a14;
            --zoom-warning-soft: #fff6e6;
            --zoom-danger: #a13b3b;
            --zoom-danger-soft: #fdeeee;
            color: var(--zoom-ink);
        }

        .zoom-join-page .card {
            border: 1px solid var(--zoom-line) !important;
            border-radius: 14px;
            box-shadow: none !important;
            background: #fff;
        }

        .zoom-join-page .card-body,
        .zoom-join-page .card-header {
            padding: 1.2rem 1.25rem;
        }

        .zoom-join-page .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(215, 224, 232, 0.9) !important;
        }

        .zoom-hero {
            overflow: hidden;
            border-top: 3px solid var(--zoom-primary);
            background: linear-gradient(135deg, rgba(31, 95, 147, 0.05), rgba(31, 95, 147, 0)), #fff;
        }

        .zoom-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            background: var(--zoom-primary-soft);
            color: var(--zoom-primary);
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .zoom-hero-title {
            margin: 0.9rem 0 0.55rem;
            font-size: clamp(1.75rem, 2.6vw, 2.35rem);
            line-height: 1.1;
            font-weight: 800;
            color: #102840;
        }

        .zoom-hero-copy {
            max-width: 760px;
            margin: 0;
            color: var(--zoom-muted);
            line-height: 1.7;
        }

        .zoom-hero-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.9rem;
            margin-top: 1.25rem;
        }

        .zoom-hero-stat,
        .zoom-note,
        .zoom-step {
            border: 1px solid rgba(215, 224, 232, 0.9);
            border-radius: 12px;
            background: var(--zoom-soft);
        }

        .zoom-hero-stat {
            padding: 0.95rem 1rem;
        }

        .zoom-hero-stat small,
        .zoom-meta-label,
        .zoom-section-label {
            display: block;
            color: var(--zoom-muted);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .zoom-hero-stat strong {
            display: block;
            margin-top: 0.45rem;
            font-size: 1.55rem;
            line-height: 1;
            color: #102840;
        }

        .zoom-hero-stat span,
        .zoom-meta-value-sub,
        .zoom-note p {
            display: block;
            margin-top: 0.4rem;
            color: var(--zoom-muted);
            font-size: 0.84rem;
            line-height: 1.6;
        }

        .zoom-meta-grid {
            display: grid;
            gap: 0.85rem;
        }

        .zoom-meta-row {
            display: grid;
            grid-template-columns: minmax(0, 120px) 1fr;
            gap: 0.85rem;
            align-items: start;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid rgba(215, 224, 232, 0.8);
        }

        .zoom-meta-row:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .zoom-meta-value {
            font-weight: 700;
            color: #102840;
            word-break: break-word;
        }

        .zoom-platform-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.3rem 0.65rem;
            border-radius: 999px;
            background: var(--zoom-primary-soft);
            color: var(--zoom-primary);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .zoom-readiness {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid rgba(215, 224, 232, 0.9);
        }

        .zoom-readiness.is-ready {
            background: var(--zoom-success-soft);
            border-color: rgba(46, 125, 90, 0.18);
        }

        .zoom-readiness.is-warn {
            background: var(--zoom-warning-soft);
            border-color: rgba(156, 106, 20, 0.18);
        }

        .zoom-readiness-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1rem;
        }

        .zoom-readiness.is-ready .zoom-readiness-icon {
            background: rgba(46, 125, 90, 0.12);
            color: var(--zoom-success);
        }

        .zoom-readiness.is-warn .zoom-readiness-icon {
            background: rgba(156, 106, 20, 0.12);
            color: var(--zoom-warning);
        }

        .zoom-readiness-title {
            font-weight: 800;
            color: #102840;
        }

        .zoom-readiness-copy {
            margin-top: 0.25rem;
            color: var(--zoom-muted);
            line-height: 1.65;
        }

        .zoom-actions-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-top: 0.85rem;
        }

        .zoom-checklist {
            display: grid;
            gap: 0.7rem;
        }

        .zoom-step {
            display: flex;
            gap: 0.8rem;
            align-items: flex-start;
            padding: 0.85rem 0.95rem;
        }

        .zoom-step-index {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #fff;
            border: 1px solid rgba(215, 224, 232, 0.95);
            font-size: 0.83rem;
            font-weight: 800;
            color: var(--zoom-primary);
        }

        .zoom-step strong {
            display: block;
            font-size: 0.94rem;
            color: #102840;
        }

        .zoom-step span {
            display: block;
            margin-top: 0.18rem;
            color: var(--zoom-muted);
            font-size: 0.83rem;
            line-height: 1.55;
        }

        .zoom-room-card {
            overflow: hidden;
        }

        .zoom-room-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem;
            align-items: start;
        }

        .zoom-room-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
            color: #102840;
        }

        .zoom-room-copy {
            margin: 0.25rem 0 0;
            color: var(--zoom-muted);
            line-height: 1.6;
        }

        .zoom-room-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
        }

        .zoom-room-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.38rem 0.7rem;
            border-radius: 999px;
            border: 1px solid rgba(215, 224, 232, 0.95);
            background: var(--zoom-soft);
            color: var(--zoom-muted);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .zoom-status-panel {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.95rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(215, 224, 232, 0.95);
            background: var(--zoom-soft);
            color: #102840;
            margin-bottom: 1rem;
        }

        .zoom-status-panel::before {
            content: "";
            width: 11px;
            height: 11px;
            border-radius: 999px;
            background: var(--zoom-primary);
            box-shadow: 0 0 0 5px rgba(31, 95, 147, 0.12);
            flex: 0 0 11px;
        }

        .zoom-status-panel.is-success {
            background: var(--zoom-success-soft);
            border-color: rgba(46, 125, 90, 0.18);
        }

        .zoom-status-panel.is-success::before {
            background: var(--zoom-success);
            box-shadow: 0 0 0 5px rgba(46, 125, 90, 0.12);
        }

        .zoom-status-panel.is-warning {
            background: var(--zoom-warning-soft);
            border-color: rgba(156, 106, 20, 0.18);
        }

        .zoom-status-panel.is-warning::before {
            background: var(--zoom-warning);
            box-shadow: 0 0 0 5px rgba(156, 106, 20, 0.12);
        }

        .zoom-status-panel.is-danger {
            background: var(--zoom-danger-soft);
            border-color: rgba(161, 59, 59, 0.18);
        }

        .zoom-status-panel.is-danger::before {
            background: var(--zoom-danger);
            box-shadow: 0 0 0 5px rgba(161, 59, 59, 0.12);
        }

        #zmmtg-root {
            display: none;
        }

        #meetingSDKElement {
            min-height: 720px;
            background: linear-gradient(180deg, rgba(12, 26, 43, 0.08), rgba(12, 26, 43, 0.02)), #f3f6fa;
            border: 1px solid rgba(215, 224, 232, 0.95);
            border-radius: 14px;
            overflow: hidden;
        }

        .zoom-note {
            padding: 0.9rem 1rem;
        }

        .zoom-note p {
            margin: 0.3rem 0 0;
        }

        @media (max-width: 991.98px) {
            .zoom-hero-grid {
                grid-template-columns: 1fr;
            }

            .zoom-meta-row {
                grid-template-columns: 1fr;
                gap: 0.35rem;
            }
        }
    </style>
@endpush

@section('page-action')
    @if($canStartMeeting)
        <a href="{{ $attendanceEvent->host_start_url }}" target="_blank" rel="noopener" class="btn btn-warning btn-sm">
            <i class="ti ti-player-play"></i> {{ __('Start As Host') }}
        </a>
    @endif
    @if($attendanceEvent->meeting_link)
        <a href="{{ $attendanceEvent->meeting_link }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
            <i class="ti ti-external-link"></i> {{ __('Open Zoom Fallback') }}
        </a>
    @endif
    <a href="{{ route('churchly.events.show', $attendanceEvent->event_id) }}" class="btn btn-light btn-sm">
        <i class="ti ti-arrow-left"></i> {{ __('Back to Event') }}
    </a>
@endsection

@section('content')
    <div class="zoom-join-page">
        <div class="card zoom-hero mb-4">
            <div class="card-body">
                <span class="zoom-eyebrow"><i class="ti ti-video"></i>{{ __('Church Meeting Room') }}</span>
                <h2 class="zoom-hero-title">{{ $attendanceEvent->event->title ?? __('Zoom Meeting') }}</h2>
                <p class="zoom-hero-copy">{{ __('Launch, monitor, and join this live church meeting without leaving OPEN. Meeting access, readiness, and room status are kept together on one operational screen.') }}</p>
                <div class="zoom-hero-grid">
                    <div class="zoom-hero-stat">
                        <small>{{ __('Meeting Number') }}</small>
                        <strong>{{ $attendanceEvent->meeting_id ?? '-' }}</strong>
                        <span>{{ __('Primary Zoom identifier for this session.') }}</span>
                    </div>
                    <div class="zoom-hero-stat">
                        <small>{{ __('Access Mode') }}</small>
                        <strong>{{ $meetingSdkEnabled ? __('In-App Join') : __('Fallback Link') }}</strong>
                        <span>{{ $meetingSdkEnabled ? __('Meeting SDK is available for embedded access.') : __('Zoom credentials still need to be completed.') }}</span>
                    </div>
                    <div class="zoom-hero-stat">
                        <small>{{ __('Role Access') }}</small>
                        <strong>{{ $canStartMeeting ? __('Host + Member') : __('Member Join') }}</strong>
                        <span>{{ $canStartMeeting ? __('This account can start the meeting and monitor the room.') : __('This account can join the active session.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xl-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-1">{{ __('Session Details') }}</h5>
                        <p class="text-muted mb-0">{{ __('Core Zoom metadata for this event room.') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="zoom-meta-grid">
                            <div class="zoom-meta-row">
                                <div class="zoom-meta-label">{{ __('Meeting ID') }}</div>
                                <div class="zoom-meta-value">{{ $attendanceEvent->meeting_id ?? '-' }}</div>
                            </div>
                            <div class="zoom-meta-row">
                                <div class="zoom-meta-label">{{ __('Passcode') }}</div>
                                <div>
                                    <div class="zoom-meta-value">{{ $attendanceEvent->meeting_passcode ?: '-' }}</div>
                                    <span class="zoom-meta-value-sub">{{ __('Use this only if Zoom prompts outside the embedded room.') }}</span>
                                </div>
                            </div>
                            <div class="zoom-meta-row">
                                <div class="zoom-meta-label">{{ __('Platform') }}</div>
                                <div><span class="zoom-platform-pill"><i class="ti ti-brand-zoom"></i>{{ ucfirst($attendanceEvent->online_platform ?: 'zoom') }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-1">{{ __('Readiness') }}</h5>
                        <p class="text-muted mb-0">{{ __('Current meeting access and fallback options.') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="zoom-readiness {{ $meetingSdkEnabled ? 'is-ready' : 'is-warn' }}">
                            <span class="zoom-readiness-icon"><i class="ti {{ $meetingSdkEnabled ? 'ti-check' : 'ti-alert-triangle' }}"></i></span>
                            <div>
                                <div class="zoom-readiness-title">{{ $meetingSdkEnabled ? __('Embedded room is ready') : __('Embedded room not fully configured') }}</div>
                                <div class="zoom-readiness-copy">{{ $meetingSdkEnabled ? __('Meeting SDK credentials are available, so users can join inside OPEN and keep church activity in one place.') : __('Users can still open Zoom directly, but Meeting SDK keys should be configured to restore the in-app room.') }}</div>
                                <div class="zoom-actions-inline">
                                    @if($meeting_link = $attendanceEvent->meeting_link)
                                        <a href="{{ $meeting_link }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-external-link me-1"></i>{{ __('Open Zoom Fallback') }}
                                        </a>
                                    @endif
                                    @unless($meetingSdkEnabled)
                                        <a href="{{ route('churchly.zoom.index') }}" class="btn btn-sm btn-light">
                                            <i class="ti ti-settings me-1"></i>{{ __('Configure Zoom SDK') }}
                                        </a>
                                    @endunless
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-1">{{ __('Join Flow') }}</h5>
                        <p class="text-muted mb-0">{{ __('What this screen is doing behind the scenes.') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="zoom-checklist">
                            <div class="zoom-step">
                                <span class="zoom-step-index">1</span>
                                <div>
                                    <strong>{{ __('Secure session request') }}</strong>
                                    <span>{{ __('OPEN requests a server-generated Zoom signature before opening the room.') }}</span>
                                </div>
                            </div>
                            <div class="zoom-step">
                                <span class="zoom-step-index">2</span>
                                <div>
                                    <strong>{{ __('Embedded room first') }}</strong>
                                    <span>{{ __('The page tries the in-app component view before any external fallback.') }}</span>
                                </div>
                            </div>
                            <div class="zoom-step">
                                <span class="zoom-step-index">3</span>
                                <div>
                                    <strong>{{ __('Client fallback if needed') }}</strong>
                                    <span>{{ __('If embedded mode cannot initialize, the client view is used automatically.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card zoom-room-card">
                    <div class="card-header">
                        <div class="zoom-room-header">
                            <div>
                                <h5 class="zoom-room-title">{{ __('Live Meeting Room') }}</h5>
                                <p class="zoom-room-copy">{{ __('Keep this page open while the room loads. Status updates and Zoom initialization messages will appear below.') }}</p>
                            </div>
                            <div class="zoom-room-badges">
                                <span class="zoom-room-badge"><i class="ti ti-shield-check"></i>{{ __('Secure Signature') }}</span>
                                <span class="zoom-room-badge"><i class="ti ti-app-window"></i>{{ __('In-App Experience') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="zoom-status" class="zoom-status-panel is-info">
                            {{ __('Preparing Zoom meeting room...') }}
                        </div>
                        <div id="meetingSDKElement"></div>
                        <div class="zoom-note mt-3">
                            <small class="zoom-section-label">{{ __('Operator Note') }}</small>
                            <p>{{ __('If this room cannot load because of SDK or browser restrictions, use the fallback Zoom link from the left panel while keeping event activity managed inside OPEN.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if($meetingSdkEnabled)
        <script src="https://source.zoom.us/5.1.4/lib/vendor/react.min.js" data-zoom-vendor="react" onload="this.dataset.loaded='1'"></script>
        <script src="https://source.zoom.us/5.1.4/lib/vendor/react-dom.min.js" data-zoom-vendor="react-dom" onload="this.dataset.loaded='1'"></script>
        <script src="https://source.zoom.us/5.1.4/lib/vendor/redux.min.js" data-zoom-vendor="redux" onload="this.dataset.loaded='1'"></script>
        <script src="https://source.zoom.us/5.1.4/lib/vendor/redux-thunk.min.js" data-zoom-vendor="redux-thunk" onload="this.dataset.loaded='1'"></script>
        <script src="https://source.zoom.us/5.1.4/lib/vendor/lodash.min.js" data-zoom-vendor="lodash" onload="this.dataset.loaded='1'"></script>
        <script src="https://source.zoom.us/5.1.4/zoom-meeting-embedded-5.1.4.min.js" data-zoom-embedded-sdk="1" onload="this.dataset.loaded='1'"></script>
        <script>
            document.addEventListener('DOMContentLoaded', async function () {
                const statusBox = document.getElementById('zoom-status');
                const rootElement = document.getElementById('meetingSDKElement');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || @json(csrf_token());
                const zoomEmbeddedSdkUrl = 'https://source.zoom.us/5.1.4/zoom-meeting-embedded-5.1.4.min.js';
                const zoomClientSdkUrl = 'https://source.zoom.us/5.1.4/zoom-meeting-5.1.4.min.js';
                const zoomVendorScripts = [
                    { selector: 'script[data-zoom-vendor="react"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/react.min.js' },
                    { selector: 'script[data-zoom-vendor="react-dom"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/react-dom.min.js' },
                    { selector: 'script[data-zoom-vendor="redux"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/redux.min.js' },
                    { selector: 'script[data-zoom-vendor="redux-thunk"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/redux-thunk.min.js' },
                    { selector: 'script[data-zoom-vendor="lodash"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/lodash.min.js' },
                ];

                function setStatus(message, type = 'info') {
                    const classMap = {
                        info: 'zoom-status-panel is-info',
                        success: 'zoom-status-panel is-success',
                        warning: 'zoom-status-panel is-warning',
                        danger: 'zoom-status-panel is-danger',
                    };

                    statusBox.className = classMap[type] || classMap.info;
                    statusBox.textContent = message;
                }

                function getZoomEmbeddedSdk() {
                    return window.ZoomMtgEmbedded || window.ReactWidgets || window.zoomMtgEmbedded || null;
                }

                function getZoomClientSdk() {
                    return window.ZoomMtg || null;
                }

                async function ensureScript(selector, src, errorMessage) {
                    await new Promise((resolve, reject) => {
                        let script = document.querySelector(selector);

                        if (!script) {
                            script = document.createElement('script');
                            script.src = src;
                            script.async = true;

                            const attributeMatch = selector.match(/\[([^=]+)="([^"]+)"\]/);

                            if (attributeMatch) {
                                script.setAttribute(attributeMatch[1], attributeMatch[2]);
                            }

                            document.body.appendChild(script);
                        }

                        if (script.dataset.loaded === '1') {
                            resolve();
                            return;
                        }

                        script.addEventListener('load', function handleLoad() {
                            script.dataset.loaded = '1';
                            resolve();
                        }, { once: true });

                        script.addEventListener('error', function handleError() {
                            reject(new Error(errorMessage));
                        }, { once: true });
                    });
                }

                async function ensureZoomEmbeddedSdk() {
                    await Promise.all(
                        zoomVendorScripts.map((vendor) => ensureScript(vendor.selector, vendor.src, 'Unable to load Zoom Meeting SDK vendor assets.'))
                    );
                    await ensureScript('script[data-zoom-embedded-sdk="1"]', zoomEmbeddedSdkUrl, 'Unable to load Zoom Meeting SDK embedded assets.');

                    const loadedSdk = getZoomEmbeddedSdk();

                    if (!loadedSdk?.createClient) {
                        throw new Error('Zoom Meeting SDK loaded, but the embedded client is unavailable.');
                    }

                    return loadedSdk;
                }

                async function ensureZoomClientSdk() {
                    await Promise.all(
                        zoomVendorScripts.map((vendor) => ensureScript(vendor.selector, vendor.src, 'Unable to load Zoom Meeting SDK vendor assets.'))
                    );

                    let loadedSdk = getZoomClientSdk();

                    if (!loadedSdk?.init) {
                        await ensureScript('script[data-zoom-client-sdk="1"]', zoomClientSdkUrl, 'Unable to load Zoom Meeting SDK client assets.');
                        loadedSdk = getZoomClientSdk();
                    }

                    if (!loadedSdk?.init) {
                        throw new Error('Zoom Meeting SDK client view is unavailable.');
                    }

                    loadedSdk.preLoadWasm?.();
                    loadedSdk.prepareWebSDK?.();
                    loadedSdk.i18n?.load('en-US');
                    loadedSdk.i18n?.reload('en-US');

                    return loadedSdk;
                }

                async function joinWithClientView(payload) {
                    const ZoomMtg = await ensureZoomClientSdk();

                    rootElement.innerHTML = '';
                    rootElement.style.background = '#ffffff';
                    document.getElementById('zmmtg-root')?.style.setProperty('display', 'block');

                    return await new Promise((resolve, reject) => {
                        ZoomMtg.init({
                            leaveUrl: @json(route('churchly.events.show', $attendanceEvent->event_id)),
                            patchJsMedia: true,
                            leaveOnPageUnload: true,
                            success: function () {
                                ZoomMtg.join({
                                    sdkKey: payload.sdkKey,
                                    signature: payload.signature,
                                    meetingNumber: payload.meetingNumber,
                                    passWord: payload.password || '',
                                    userName: payload.userName,
                                    userEmail: payload.userEmail || '',
                                    success: function () {
                                        resolve();
                                    },
                                    error: function (error) {
                                        reject(new Error(error?.reason || error?.message || 'Unable to join Zoom meeting.'));
                                    },
                                });
                            },
                            error: function (error) {
                                reject(new Error(error?.reason || error?.message || 'Unable to initialize Zoom client view.'));
                            },
                        });
                    });
                }

                try {
                    setStatus('Requesting secure Zoom session...', 'info');

                    const response = await fetch(@json(route('churchly.zoom.meetings.signature', $attendanceEvent->id)), {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ _token: csrfToken }),
                    });

                    const payload = await response.json();

                    if (!response.ok) {
                        throw new Error(payload.message || 'Unable to create Zoom session.');
                    }

                    payload.meetingNumber = String(payload.meetingNumber || '').replace(/\D+/g, '');

                    if (!payload.meetingNumber) {
                        throw new Error('Zoom meeting number is invalid for this event.');
                    }

                    setStatus('Joining meeting...', 'info');

                    try {
                        const ZoomEmbedded = await ensureZoomEmbeddedSdk();
                        const client = ZoomEmbedded.createClient();

                        await client.init({
                            zoomAppRoot: rootElement,
                            language: 'en-US',
                            patchJsMedia: true,
                            leaveOnPageUnload: true,
                        });

                        await client.join({
                            sdkKey: payload.sdkKey,
                            signature: payload.signature,
                            meetingNumber: payload.meetingNumber,
                            password: payload.password || '',
                            userName: payload.userName,
                            userEmail: payload.userEmail || '',
                        });
                    } catch (embeddedError) {
                        setStatus('Embedded view unavailable. Switching to Zoom client view...', 'warning');
                        await joinWithClientView(payload);
                    }

                    setStatus('Connected to Zoom meeting.', 'success');
                } catch (error) {
                    setStatus(error.message || 'Zoom meeting failed to load.', 'danger');
                }
            });
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const statusBox = document.getElementById('zoom-status');
                statusBox.className = 'zoom-status-panel is-warning';
                statusBox.textContent = 'Embedded Zoom join is unavailable until Meeting SDK credentials are configured.';
            });
        </script>
    @endif
@endpush

@extends('layouts.main')

@section('page-title', __('Join Zoom Meeting'))

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/integrations.css') }}">
    <link rel="stylesheet" href="https://source.zoom.us/5.1.4/css/bootstrap.css">
    <link rel="stylesheet" href="https://source.zoom.us/5.1.4/css/react-select.css">
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
    <a href="{{ route('churchmeet.events.show', $attendanceEvent->event_id) }}" class="btn btn-light btn-sm">
        <i class="ti ti-arrow-left"></i> {{ __('Back to Event') }}
    </a>
@endsection

@section('content')
    @php
        $eventTitle = optional($attendanceEvent->event)->title ?: __('Zoom Meeting');
        $rawMeetingId = trim((string) ($attendanceEvent->meeting_id ?? ''));
        $parsedMeetingNumber = null;

        foreach ([(string) $attendanceEvent->zoom_join_url, (string) $attendanceEvent->meeting_link] as $zoomUrl) {
            if ($zoomUrl !== '' && preg_match('#/(?:j|wc|s)/(\d{9,})#', $zoomUrl, $matches)) {
                $parsedMeetingNumber = $matches[1];
                break;
            }
        }

        $displayMeetingNumber = $parsedMeetingNumber ?: ($rawMeetingId !== '' ? preg_replace('/\D+/', '', $rawMeetingId) : '-');
        $normalizedStoredMeetingId = $rawMeetingId !== '' ? preg_replace('/\D+/', '', $rawMeetingId) : null;
        $meetingNumberMismatch = $parsedMeetingNumber && $normalizedStoredMeetingId && $normalizedStoredMeetingId !== $parsedMeetingNumber;
    @endphp

    <div class="churchmeet-zoom-join">
        <div class="card join-hero mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                    <div>
                        <span class="chip"><i class="ti ti-brand-zoom"></i>{{ __('ChurchMeet Live Room') }}</span>
                        <h3 class="mt-3 mb-1">{{ $eventTitle }}</h3>
                        <p class="hero-copy mb-0">{{ __('Join this Zoom meeting inside OPEN. Meeting session status and fallback controls stay on this page.') }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-dark border">{{ strtoupper((string) ($attendanceEvent->online_platform ?: 'zoom')) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <span class="kpi-label">{{ __('Meeting Number') }}</span>
                    <span class="kpi-value">{{ $displayMeetingNumber ?: '-' }}</span>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <span class="kpi-label">{{ __('Join Mode') }}</span>
                    <span class="kpi-value">{{ $meetingSdkEnabled ? __('In-App SDK') : __('External Fallback') }}</span>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <span class="kpi-label">{{ __('Host Access') }}</span>
                    <span class="kpi-value">{{ $canStartMeeting ? __('Available') : __('Member Only') }}</span>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <span class="kpi-label">{{ __('Passcode') }}</span>
                    <span class="kpi-value">{{ $attendanceEvent->meeting_passcode ?: '-' }}</span>
                </div>
            </div>
        </div>

        @if($meetingNumberMismatch)
            <div class="alert alert-warning border mb-3">
                {{ __('Stored meeting ID differs from Zoom join URL number. The system will use the Zoom URL meeting number to avoid join failures.') }}
            </div>
        @endif

        <div class="row g-3">
            <div class="col-xl-4">
                <div class="card mb-3">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">{{ __('Meeting Details') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="meta-grid">
                            <div class="meta-item">
                                <label>{{ __('Stored Meeting ID') }}</label>
                                <span>{{ $attendanceEvent->meeting_id ?: '-' }}</span>
                            </div>
                            <div class="meta-item">
                                <label>{{ __('Resolved Number') }}</label>
                                <span>{{ $displayMeetingNumber ?: '-' }}</span>
                            </div>
                            <div class="meta-item">
                                <label>{{ __('Passcode') }}</label>
                                <span>{{ $attendanceEvent->meeting_passcode ?: '-' }}</span>
                            </div>
                            <div class="meta-item">
                                <label>{{ __('Join URL') }}</label>
                                <span>{{ $attendanceEvent->meeting_link ?: '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">{{ __('Join Checklist') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="checklist">
                            <div class="check-item">
                                <span class="check-index">1</span>
                                <div>
                                    <strong>{{ __('Load secure signature') }}</strong>
                                    <p>{{ __('OPEN requests a server-generated Zoom signature before join.') }}</p>
                                </div>
                            </div>
                            <div class="check-item">
                                <span class="check-index">2</span>
                                <div>
                                    <strong>{{ __('Try embedded view first') }}</strong>
                                    <p>{{ __('The page starts with embedded SDK join for in-app experience.') }}</p>
                                </div>
                            </div>
                            <div class="check-item">
                                <span class="check-index">3</span>
                                <div>
                                    <strong>{{ __('Fallback to client view') }}</strong>
                                    <p>{{ __('If embedded client is unavailable, Zoom client view is used.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ __('Live Meeting Room') }}</h6>
                            <p class="muted-copy mb-0 small">{{ __('Keep this page open while the room initializes.') }}</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge bg-light text-dark border">{{ __('Secure Signature') }}</span>
                            <span class="badge bg-light text-dark border">{{ __('In-App Join') }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="zoom-status" class="zoom-status-panel is-info">
                            {{ __('Preparing Zoom meeting room...') }}
                        </div>
                        <div id="meetingSDKElement"></div>
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
                const meetingPresenceUrl = @json(route('churchmeet.meetings.presence', $attendanceEvent->id));
                const zoomEmbeddedSdkUrl = 'https://source.zoom.us/5.1.4/zoom-meeting-embedded-5.1.4.min.js';
                const zoomClientSdkUrl = 'https://source.zoom.us/5.1.4/zoom-meeting-5.1.4.min.js';
                const zoomVendorScripts = [
                    { selector: 'script[data-zoom-vendor="react"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/react.min.js' },
                    { selector: 'script[data-zoom-vendor="react-dom"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/react-dom.min.js' },
                    { selector: 'script[data-zoom-vendor="redux"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/redux.min.js' },
                    { selector: 'script[data-zoom-vendor="redux-thunk"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/redux-thunk.min.js' },
                    { selector: 'script[data-zoom-vendor="lodash"]', src: 'https://source.zoom.us/5.1.4/lib/vendor/lodash.min.js' },
                ];
                let joinPresenceSent = false;
                let leavePresenceSent = false;
                let clientStatusListenerBound = false;

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

                async function sendPresence(action = 'join', keepalive = false) {
                    if (action === 'join' && joinPresenceSent) {
                        return;
                    }

                    if (action === 'leave' && leavePresenceSent) {
                        return;
                    }

                    const response = await fetch(meetingPresenceUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        keepalive: keepalive,
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            _token: csrfToken,
                            action: action
                        }),
                    });

                    if (!response.ok) {
                        throw new Error('Attendance update failed.');
                    }

                    if (action === 'join') {
                        joinPresenceSent = true;
                    }

                    if (action === 'leave') {
                        leavePresenceSent = true;
                    }
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

                    if (!clientStatusListenerBound && typeof ZoomMtg.inMeetingServiceListener === 'function') {
                        clientStatusListenerBound = true;
                        ZoomMtg.inMeetingServiceListener('onMeetingStatus', function (data) {
                            if (Number(data?.meetingStatus) === 3) {
                                sendPresence('leave', true).catch(() => {});
                            }
                        });
                    }

                    return await new Promise((resolve, reject) => {
                        ZoomMtg.init({
                            leaveUrl: @json(route('churchmeet.events.show', $attendanceEvent->event_id)),
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
                                    success: async function () {
                                        try {
                                            await sendPresence('join');
                                        } catch (presenceError) {
                                            console.warn(presenceError);
                                        }
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

                    const response = await fetch(@json(route('churchmeet.zoom.meetings.signature', $attendanceEvent->id)), {
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

                        if (typeof client.on === 'function') {
                            client.on('connection-change', function (payload) {
                                const state = String(payload?.state || '').toLowerCase();
                                if (state.includes('closed') || state.includes('disconnect')) {
                                    sendPresence('leave', true).catch(() => {});
                                }
                            });
                        }

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

                        try {
                            await sendPresence('join');
                        } catch (presenceError) {
                            console.warn(presenceError);
                        }
                    } catch (embeddedError) {
                        setStatus('Embedded view unavailable. Switching to Zoom client view...', 'warning');
                        await joinWithClientView(payload);
                    }

                    setStatus('Connected to Zoom meeting.', 'success');
                } catch (error) {
                    setStatus(error.message || 'Zoom meeting failed to load.', 'danger');
                }

                window.addEventListener('beforeunload', function () {
                    sendPresence('leave', true).catch(() => {});
                });
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

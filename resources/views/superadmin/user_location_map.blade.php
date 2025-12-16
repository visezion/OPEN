@extends('layouts.main')

@section('page-title')
    {{ __('Global User Locations') }}
@endsection

@section('page-breadcrumb')
    {{ __('User Map') }}
@endsection

@push('styles')
    <style>
        #globeCard {
            min-height: 520px;
            padding: 0;
            border-radius: 1rem;
            overflow: hidden;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px);
        }
        #globeViz {
            width: 100%;
            height: 480px;
            background: transparent;
        }
        .pin {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.8);
            position: absolute;
            transform: translate(-50%, -50%);
        }
        .pin.high { background: #ff4f4f; box-shadow: 0 0 12px rgba(255, 79, 79, 0.9); }
        .pin.medium { background: #ffa726; box-shadow: 0 0 12px rgba(255, 167, 38, 0.8); }
        .pin.low { background: #42a5f5; box-shadow: 0 0 12px rgba(66, 165, 245, 0.7); }
    </style>
@endpush

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="card shadow-sm" id="globeCard">
                <div class="card-body p-0">
                    <div id="globeViz"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gy-3 mt-3">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">{{ __('Top Countries') }}</h6>
                    <ul class="list-group list-group-flush">
                        @forelse($countrySummary as $country)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $country['country'] }}</span>
                                <strong>{{ number_format($country['requests']) }}</strong>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">{{ __('No data yet, monitor activity to fill this in.') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/three@0.149.0/build/three.min.js"></script>
    <script src="https://unpkg.com/globe.gl"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const locations = @json($globePoints);
            const arcs = [];
            for (let i = 0; i < locations.length; i++) {
                for (let j = i + 1; j < locations.length; j++) {
                    arcs.push({
                        startLat: locations[i].lat,
                        startLng: locations[i].lng,
                        endLat: locations[j].lat,
                        endLng: locations[j].lng,
                        color: locations[i].color,
                    });
                }
            }

            const globe = Globe()
                .globeImageUrl("https://unpkg.com/three-globe/example/img/earth-night.jpg")
                .bumpImageUrl("https://raw.githubusercontent.com/vasturiano/three-globe/master/example/img/earth-blue-marble.jpg")
                .showAtmosphere(true)
                .atmosphereColor("#ffffff")
                .atmosphereAltitude(0.3)
                .arcsData(arcs)
                .arcStartLat(d => d.startLat)
                .arcStartLng(d => d.startLng)
                .arcEndLat(d => d.endLat)
                .arcEndLng(d => d.endLng)
                .arcColor(d => [d.color, d.color])
                .arcAltitude(0.15)
                .arcStroke(0.7)
                .arcDashLength(0.35)
                .arcDashGap(0.7)
                .arcDashAnimateTime(1100)
                .htmlElementsData(locations)
                .htmlLat(d => d.lat)
                .htmlLng(d => d.lng)
                .htmlAltitude(0.01)
                .htmlElement(d => {
                    const el = document.createElement("div");
                    const level = d.requests >= 4 ? 'high' : d.requests >= 2 ? 'medium' : 'low';
                    el.className = `pin ${level}`;
                    el.style.background = d.color;
                    el.title = `${d.country} (${d.requests} requests)`;
                    return el;
                });

            globe(document.getElementById("globeViz"));
            const controls = globe.controls();
            controls.autoRotate = true;
            controls.autoRotateSpeed = 0.8;
        });
    </script>
@endpush

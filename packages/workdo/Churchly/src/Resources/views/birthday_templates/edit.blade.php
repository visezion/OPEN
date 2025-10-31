@extends('layouts.main')

@section('page-title', __('Edit Template Visually'))

@push('styles')
<style>
    .template-canvas {
        position: relative;
        display: inline-block;
        border: 2px solid #ddd;
        overflow: hidden;
    }
    .template-bg {
        display: block;
        width: 100%;
        height: auto;
    }
    .draggable {
        position: absolute;
        cursor: grab;
        user-select: none;
        z-index: 10;
    }
    .draggable:active {
        cursor: grabbing;
    }
    .photo-placeholder {
        border-radius: 50%;
        border: 3px dashed #007bff;
        overflow: hidden;
        background: #eee;
        width: {{ $template->photo_width ?? 150 }}px;
        height: {{ $template->photo_height ?? 150 }}px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .photo-placeholder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .text-placeholder {
        font-size: 22px;
        font-weight: bold;
        color: #000;
        white-space: nowrap;
        background: rgba(255,255,255,0.2);
        padding: 2px 6px;
        border-radius: 4px;
    }
    .slogan-placeholder {
        font-size: 16px;
        font-weight: normal;
        color: #444;
        white-space: nowrap;
        background: rgba(255,255,255,0.2);
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body text-center">
        <h5 class="mb-3">Drag & Drop to Set Positions</h5>

        <div class="template-canvas" id="canvas">
            <!-- Background Template -->
            <img src="{{ asset('storage/'.$template->file_path) }}" class="template-bg" alt="Template">

            <!-- Profile photo placeholder -->
            <div id="photo" class="draggable photo-placeholder"
                style="top:{{ $template->photo_y ?? 100 }}px; left:{{ $template->photo_x ?? 100 }}px;">
                <img src="{{ asset('images/avatar-sample.png') }}" alt="Avatar">
            </div>

            <!-- Name placeholder -->
            <div id="name" class="draggable text-placeholder"
                style="top:{{ $template->name_y ?? 300 }}px; left:{{ $template->name_x ?? 100 }}px;">
                Min. SAMPLE NAME
            </div>

            <!-- Slogan placeholder -->
            <div id="slogan" class="draggable slogan-placeholder"
                style="top:{{ $template->slogan_y ?? 360 }}px; left:{{ $template->slogan_x ?? 100 }}px;">
                This is your year of recovery...
            </div>
        </div>

        <!-- Save Form -->
        <form action="{{ route('birthday_templates.update', $template->id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')

            <input type="hidden" id="photo_x" name="photo_x" value="{{ $template->photo_x }}">
            <input type="hidden" id="photo_y" name="photo_y" value="{{ $template->photo_y }}">
            <input type="hidden" id="name_x" name="name_x" value="{{ $template->name_x }}">
            <input type="hidden" id="name_y" name="name_y" value="{{ $template->name_y }}">
            <input type="hidden" id="slogan_x" name="slogan_x" value="{{ $template->slogan_x }}">
            <input type="hidden" id="slogan_y" name="slogan_y" value="{{ $template->slogan_y }}">

            <button type="submit" class="btn btn-primary mt-3">Save Positions</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.draggable').forEach(el => {
        el.addEventListener('mousedown', function(e) {
            e.preventDefault();
            const canvas = document.getElementById('canvas');
            let shiftX = e.clientX - el.getBoundingClientRect().left;
            let shiftY = e.clientY - el.getBoundingClientRect().top;

            function moveAt(pageX, pageY) {
                let newLeft = pageX - shiftX - canvas.getBoundingClientRect().left;
                let newTop = pageY - shiftY - canvas.getBoundingClientRect().top;

                el.style.left = newLeft + 'px';
                el.style.top = newTop + 'px';
            }

            function onMouseMove(event) {
                moveAt(event.pageX, event.pageY);
            }

            document.addEventListener('mousemove', onMouseMove);

            el.onmouseup = function () {
                document.removeEventListener('mousemove', onMouseMove);
                el.onmouseup = null;

                // Save instantly to hidden inputs
                document.getElementById(el.id + '_x').value = parseInt(el.style.left);
                document.getElementById(el.id + '_y').value = parseInt(el.style.top);
            };
        });

        el.ondragstart = () => false;
    });
</script>
@endpush

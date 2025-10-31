<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Troubleshoot</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin: 2rem; }
        .card { max-width: 720px; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.25rem; }
        .row { margin-bottom: 1rem; }
        .btn { display: inline-block; background: #111827; color: #fff; padding: .6rem 1rem; border-radius: 6px; text-decoration: none; }
        .btn:disabled { opacity: .6; cursor: not-allowed; }
        .muted { color: #6b7280; font-size: .9rem; }
        .ok { color: #065f46; }
        .warn { color: #92400e; }
        .flash { margin-bottom: 1rem; padding:.75rem 1rem; border-radius:6px; }
        .flash.success { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
        .flash.error { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    </style>
    @csrf
</head>
<body>
<div class="card">
    <h2>System Troubleshoot</h2>
    <p class="muted">Common fixes when images or uploads are not visible.</p>

    @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
    @endif

    <div class="row">
        <strong>Public storage link</strong>
        <div class="muted">{{ $publicStorage }}</div>
        @if($linkExists)
            <div class="ok">Link or directory exists.</div>
        @else
            <div class="warn">Missing. Create the symlink below.</div>
        @endif
    </div>

    <div class="row">
        <strong>Storage public path</strong>
        <div class="muted">{{ $storagePublic }}</div>
        @if($targetExists)
            <div class="ok">Target directory exists.</div>
        @else
            <div class="warn">Directory missing. Ensure storage/app/public exists and is writable.</div>
        @endif
    </div>

    <form action="{{ route('superadmin.troubleshoot.storage-link') }}" method="POST">
        @csrf
        <button class="btn" type="submit">Create/Repair Storage Symlink</button>
    </form>
</div>
</body>
</html>


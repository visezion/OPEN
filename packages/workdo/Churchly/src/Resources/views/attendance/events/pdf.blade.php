
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $event->title }} — Event Report</title>
    <style>
        /* ======== GLOBAL STYLES ======== */
        body {
            font-family: "Segoe UI", "Helvetica Neue", Arial, sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #2c3e50;
            background: #fff;
        }

        h1, h2 {
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 8px;
        }

        h1 {
            font-size: 20px;
            border-bottom: 2px solid #0e3964ff;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        h2 {
            margin-top: 25px;
            font-size: 16px;
            border-left: 4px solid #0e3964ff;
            padding-left: 8px;
            color: #0e3964ff;
        }

        /* ======== META SECTION ======== */
        .meta {
            background: #f9fafb;
            border: 1px solid #e1e4e8;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .meta p {
            margin: 4px 0;
            line-height: 1.4;
        }

        .meta strong {
            width: 110px;
            display: inline-block;
            color: #555;
        }

        /* ======== TABLE ======== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            border: 1px solid #ddd;
        }

        th {
            background: #0e3964ff;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            padding: 8px;
            border: 1px solid #0e3964ff;
        }

        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) td {
            background: #f8f9fa;
        }

        tr:hover td {
            background: #eef5ff;
        }

        /* ======== FOOTER ======== */
        footer {
            text-align: right;
            font-size: 11px;
            color: #777;
            margin-top: 25px;
            border-top: 1px dashed #ccc;
            padding-top: 6px;
        }

        /* ======== BRAND TAG ======== */
        .brand {
            font-size: 11px;
            color: #888;
            text-align: center;
            margin-top: 20px;
        }

        /* ======== PRINT FRIENDLY ======== */
        @media print {
            body { margin: 20mm; }
            h1 { color: #000; border-color: #000; }
            h2 { color: #000; border-color: #000; }
            th { background: #444 !important; color: #fff !important; }
        }
    </style>
</head>
<body>

    <h1>{{ $event->title }}</h1>

    <div class="meta">
        <p><strong>Type:</strong> {{ ucfirst($event->event_type) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>
        <p><strong>Venue:</strong> {{ $event->venue ?? '-' }}</p>
         <p><strong>Date:</strong> {{ $event->start_time ? date('d M Y', strtotime($event->start_time)) : '—' }}</p>
        <p><strong>Start Time:</strong> {{ $event->start_time ? date('h:i A', strtotime($event->start_time)) : '—' }}</p>
        <p><strong>End Time:</strong> {{ $event->end_time ? date('h:i A', strtotime($event->end_time)) : '—' }}</p>
        <p><strong>Recurrence:</strong> {{ ucfirst($event->recurrence ?? 'none') }}</p>
       
        @if(!empty($event->description))
            <p><strong>Description:</strong> {{ $event->description }}</p>
        @endif
    </div>

    <h2>Program Schedule</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Program Item</th>
                <th>Duration</th>
                <th>Time Range</th>
                <th>Leader</th>
               
            </tr>
        </thead>
        <tbody>
            @php
                $currentTime = \Carbon\Carbon::parse($event->start_time);
            @endphp
            @foreach($event->programs as $i => $p)
                @php
                    $start = $currentTime->copy();
                    $end = $currentTime->copy()->addMinutes($p->duration ?? 0);
                    $timeRange = $start->format('H:i') . ' – ' . $end->format('H:i');
                    $currentTime = $end;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->program_item }}</td>
                    <td>{{ $p->duration }} min</td>
                    <td>{{ $timeRange }}</td>
                    <td>{{ $p->leader->name ?? '-' }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        Generated on {{ now()->format('d M Y, H:i') }}
    </footer>

    <div class="brand">
        © 2025 Churchly Event System · Automated Report
    </div>

</body>
</html>

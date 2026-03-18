<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@props(['workspace' => null])
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/ui-clean.css') }}">
    </head>
    <body class="font-sans text-gray-900 antialiased ui-border-clean">
        @php
            $workspaceParam = $workspace ?? null;
            $workspaceForLayout = $workspaceParam ?? \App\Models\WorkSpace::find(getActiveWorkSpace());
            $workspaceProfile = $workspaceForLayout
                ? \Workdo\Churchly\Entities\ChurchAppProfile::where('workspace_id', $workspaceForLayout->id)->first()
                : null;
            $primaryColor = $workspaceProfile->primary_color ?? '#040418ff';
            $secondaryColor = $workspaceProfile->accent_color ?? '#0a174dff';
            $backgroundColor = $workspaceProfile->background_color ?? '#f4f6fb';
            $textColor = $workspaceProfile->text_color ?? '#0f172a';
            $primaryRgb = [
                hexdec(substr($primaryColor, 1, 2)),
                hexdec(substr($primaryColor, 3, 2)),
                hexdec(substr($primaryColor, 5, 2)),
            ];
            $companyLogo = null;
            if ($workspaceForLayout?->created_by) {
                $companySettings = getCompanyAllSetting($workspaceForLayout->created_by, $workspaceForLayout->id);
                $logoCandidate = null;
                if (!empty($companySettings['logo_light']) && check_file($companySettings['logo_light'])) {
                    $logoCandidate = get_file($companySettings['logo_light']);
                } elseif (!empty($companySettings['logo_dark']) && check_file($companySettings['logo_dark'])) {
                    $logoCandidate = get_file($companySettings['logo_dark']);
                }
                $companyLogo = $logoCandidate;
            }
            $logoUrl = $workspaceProfile && $workspaceProfile->logo_path
                ? asset(\Illuminate\Support\Facades\Storage::url($workspaceProfile->logo_path))
                : ($companyLogo ?? asset('uploads/logo/logo_light.png'));
            $workspaceSlug = $workspaceForLayout?->slug ?: 'workspace';
            $workspaceUrl = url($workspaceSlug === 'workspace' ? '/' : $workspaceSlug);
        @endphp

        <style>
            :root {
                --guest-primary: {{ $primaryColor }};
                --guest-secondary: {{ $secondaryColor }};
            }

            body {
                background: {{ $backgroundColor }};
                color: {{ $textColor }};
            }

            .workspace-banner {
                background: linear-gradient(15deg, {{ $primaryColor }}, {{ $secondaryColor }});
            }
        </style>
        
        <div class="min-h-screen flex flex-col items-center ">
         <div class="rounded-3xl bg-white/20 shadow-2xl border border-slate-900">    
         <div class="px-8 py-4 text-center workspace-banner">   <br>
            <div class="items-center flex gap-6 mb-4" style="justify-content: center;">
                <a href="{{ $workspaceUrl }}" class="flex items-center gap-3">
                    <img src="{{ $logoUrl }}" alt="logo" class="h-16 w-auto">
                </a>
            </div>
            <div class="text-white text-sm font-semibold">{{ $workspaceForLayout?->name ?? config('app.name') }}</div>
            @if (!empty($workspaceProfile?->short_description))
                <p class="text-white/80 text-xs mt-1 max-w-[320px] mx-auto">
                    {{ $workspaceProfile->short_description }}
                </p>
            @endif
            {{ $slot }}
        </div>
        </div>
        </div>
    </body>
</html>

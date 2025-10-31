@php
  $i = $idx ?? 0; $t = $type ?? 'banner_carousel'; $c = $settings ?? [];
@endphp
@switch($t)
  @case('banner_carousel')
    <div class="row g-2">
      <div class="col-md-8"><textarea class="form-control" rows="2" name="widgets[{{ $i }}][images_text]" placeholder="One image URL per line">{{ isset($c['images']) && is_array($c['images']) ? implode("\n", $c['images']) : '' }}</textarea></div>
      <div class="col-md-2 form-check form-switch">
        <input class="form-check-input" type="checkbox" name="widgets[{{ $i }}][autoplay]" value="1" {{ !empty($c['autoplay']) ? 'checked' : '' }}> Autoplay
      </div>
      <div class="col-md-2"><input type="number" class="form-control" name="widgets[{{ $i }}][interval]" value="{{ $c['interval'] ?? 3000 }}" placeholder="3000"></div>
    </div>
    @break
  @case('quick_links')
    <div class="row g-2">
      <div class="col-md-12"><textarea class="form-control" rows="2" name="widgets[{{ $i }}][links_text]" placeholder="Title|ti ti-icon|target per line">@if(!empty($c['links']) && is_array($c['links']))@foreach($c['links'] as $l){{ ($l['title']??'') }}|{{ ($l['icon_name']??'') }}|{{ ($l['target']??'') }}
@endforeach @endif</textarea></div>
    </div>
    @break
  @case('latest_sermons')
    <div class="row g-2">
      <div class="col-md-3"><input type="number" min="1" class="form-control" name="widgets[{{ $i }}][limit]" value="{{ $c['limit'] ?? 5 }}" placeholder="Limit"></div>
      <div class="col-md-9"><input class="form-control" name="widgets[{{ $i }}][source]" value="{{ $c['source'] ?? '' }}" placeholder="Playlist/Channel ID (optional)"></div>
    </div>
    @break
  @case('upcoming_events')
    <div class="row g-2">
      <div class="col-md-3"><input type="number" min="1" class="form-control" name="widgets[{{ $i }}][limit]" value="{{ $c['limit'] ?? 5 }}" placeholder="Limit"></div>
      <div class="col-md-3 form-check form-switch"><input class="form-check-input" type="checkbox" name="widgets[{{ $i }}][show_past]" value="1" {{ !empty($c['show_past']) ? 'checked' : '' }}> Show past</div>
    </div>
    @break
  @case('custom_html')
  @default
    <textarea class="form-control" rows="3" name="widgets[{{ $i }}][html]" placeholder="&lt;div&gt;...&lt;/div&gt;">{{ $c['html'] ?? '' }}</textarea>
@endswitch


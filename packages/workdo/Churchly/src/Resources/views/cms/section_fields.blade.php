@php
  $i = $idx ?? 0; $t = $type ?? 'text'; $c = $content ?? [];
@endphp
@switch($t)
  @case('hero')
    <div class="row g-2 section-details">
      <div class="col-md-4"><input class="form-control" name="sections[{{ $i }}][title_text]" value="{{ $c['title_text'] ?? '' }}" placeholder="Title"></div>
      <div class="col-md-4"><input class="form-control" name="sections[{{ $i }}][subtitle]" value="{{ $c['subtitle'] ?? '' }}" placeholder="Subtitle"></div>
      <div class="col-md-4"><input class="form-control" name="sections[{{ $i }}][background_image]" value="{{ $c['background_image'] ?? '' }}" placeholder="Background image URL"></div>
      <div class="col-md-4"><input class="form-control" name="sections[{{ $i }}][button_text]" value="{{ $c['button_text'] ?? '' }}" placeholder="Button text"></div>
      <div class="col-md-8"><input class="form-control" name="sections[{{ $i }}][button_link]" value="{{ $c['button_link'] ?? '' }}" placeholder="Button link URL"></div>
    </div>
    @break
  @case('text')
    <div class="row g-2 section-details">
      <div class="col-md-4"><input class="form-control" name="sections[{{ $i }}][heading]" value="{{ $c['heading'] ?? '' }}" placeholder="Heading"></div>
      <div class="col-md-8"><textarea class="form-control" rows="2" name="sections[{{ $i }}][body]" placeholder="Body">{{ $c['body'] ?? '' }}</textarea></div>
      <div class="col-md-3">
        <select class="form-select" name="sections[{{ $i }}][align]">
          @foreach(['left','center','right'] as $opt)
            <option value="{{ $opt }}" {{ ($c['align'] ?? 'left')===$opt?'selected':'' }}>{{ ucfirst($opt) }}</option>
          @endforeach
        </select>
      </div>
    </div>
    @break
  @case('gallery')
    <div class="row g-2 section-details">
      <div class="col-md-12">
        <textarea class="form-control" rows="2" name="sections[{{ $i }}][images_text]" placeholder="One image URL per line">{{ isset($c['images']) && is_array($c['images']) ? implode("\n", $c['images']) : '' }}</textarea>
      </div>
    </div>
    @break
  @case('cta')
    <div class="row g-2 section-details">
      <div class="col-md-4"><input class="form-control" name="sections[{{ $i }}][title_text]" value="{{ $c['title_text'] ?? '' }}" placeholder="Title"></div>
      <div class="col-md-5"><input class="form-control" name="sections[{{ $i }}][text]" value="{{ $c['text'] ?? '' }}" placeholder="Text"></div>
      <div class="col-md-3"><input class="form-control" name="sections[{{ $i }}][link_text]" value="{{ $c['link_text'] ?? '' }}" placeholder="Link text"></div>
      <div class="col-md-12"><input class="form-control" name="sections[{{ $i }}][link_url]" value="{{ $c['link_url'] ?? '' }}" placeholder="Link URL"></div>
    </div>
    @break
  @case('events')
    <div class="row g-2 section-details">
      <div class="col-md-3"><input type="number" min="1" class="form-control" name="sections[{{ $i }}][limit]" value="{{ $c['limit'] ?? 5 }}" placeholder="Limit"></div>
      <div class="col-md-3 form-check form-switch">
        <input class="form-check-input" type="checkbox" name="sections[{{ $i }}][show_past]" value="1" {{ !empty($c['show_past']) ? 'checked' : '' }}> Show past
      </div>
    </div>
    @break
  @case('sermon')
    <div class="row g-2 section-details">
      <div class="col-md-6"><input class="form-control" name="sections[{{ $i }}][video_url]" value="{{ $c['video_url'] ?? '' }}" placeholder="Video URL (YouTube/Vimeo)"></div>
      <div class="col-md-6"><input class="form-control" name="sections[{{ $i }}][title_text]" value="{{ $c['title_text'] ?? '' }}" placeholder="Title"></div>
    </div>
    @break
  @default
    <div class="text-muted small">{{ __('Custom section: use Title and Active; extend later as needed.') }}</div>
@endswitch


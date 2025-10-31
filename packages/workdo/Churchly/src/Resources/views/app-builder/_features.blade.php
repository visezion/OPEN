<form method="POST" action="{{ route('app-builder.saveFeatures') }}">
    @csrf
    <div class="row">
        @php
            $featureList = [
                'attendance' => 'Attendance',
                'events' => 'Events',
                'giving' => 'Giving',
                'sermons' => 'Sermons',
                'groups' => 'Groups',
                'announcements' => 'Announcements',
                'bible_reading' => 'Bible Reading',
                'livestream' => 'Live Stream'
            ];
        @endphp

        @foreach($featureList as $key => $label)
            @php $enabled = $features->where('feature_key',$key)->first()?->enabled ?? false; @endphp
            <div class="col-md-6 mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="features[{{ $loop->index }}][enabled]" value="1" {{ $enabled ? 'checked' : '' }}>
                    <input type="hidden" name="features[{{ $loop->index }}][feature_key]" value="{{ $key }}">
                    <label class="form-check-label">{{ __($label) }}</label>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-end mt-3">
        <button class="btn btn-primary" type="submit">{{ __('Save Features') }}</button>
    </div>
</form>

@for($i = 1; $i <= 15; $i++)
    @if(config("pligg.extra_fields.{$i}.enabled"))
        <div class="control-group">
            <label for="link_field{{ $i }}" class="control-label">
                {{ config("pligg.extra_fields.{$i}.title") }}:
            </label>
            <p>{{ config("pligg.extra_fields.{$i}.instructions") }}</p>
            <div class="controls">
                <input type="text" name="link_field{{ $i }}" 
                       class="form-control" id="link_field{{ $i }}" 
                       value="{{ old("link_field{$i}", ${"submit_link_field{$i}"} ?? '') }}" 
                       size="60" />
            </div>
        </div>
    @endif
@endfor

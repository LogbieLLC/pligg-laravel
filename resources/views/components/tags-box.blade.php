@if(config('pligg.enable_tags') && $pagename !== 'cloud')
    @hook('tpl_widget_tags_start')

    <div class="headline">
        <div class="sectiontitle">
            <a href="{{ route('tags.cloud') }}">
                {{ __('pligg.top_5_tags') }}
                @if($category_name)
                    {{ __('pligg.in') }} {{ $category_name }}
                @endif
            </a>
        </div>
    </div>

    <div class="boxcontent tagformat">
        @foreach($tags as $index => $tag)
            <span style="font-size: {{ $tag_size[$index] }}pt">
                <a href="{{ $tag_url[$index] }}">{{ $tag_name[$index] }}</a>
            </span>
        @endforeach
    </div>

    @hook('tpl_widget_tags_end')
@endif

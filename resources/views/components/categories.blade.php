@if(config('pligg.show_categories', true))
    <nav class="navbar navbar-default" id="categories">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    @foreach($categories as $category)
                        <li class="{{ request()->route('category') == $category->slug ? 'active' : '' }}">
                            <a href="{{ route('category.show', $category->slug) }}">
                                {{ $category->name }}
                                @if(config('pligg.show_category_counts', true))
                                    <span class="badge">{{ $category->links_count }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
@endif

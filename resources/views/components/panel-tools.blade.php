<ul class="list-unstyled">
    @hook('tpl_pligg_panel_tools_start')
    
    <li>
        <a href="{{ route('admin.cache.clear') }}" 
           data-toggle="modal">
            {{ __('pligg.admin.delete_cache') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('admin.comments.delete') }}" 
           data-toggle="modal">
            {{ __('pligg.admin.delete_comments') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('admin.stories.delete') }}" 
           data-toggle="modal">
            {{ __('pligg.admin.delete_stories') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('admin.database.optimize') }}" 
           data-toggle="modal">
            {{ __('pligg.admin.optimize_database') }}
        </a>
    </li>
    
    @hook('tpl_pligg_panel_tools_end')
</ul>

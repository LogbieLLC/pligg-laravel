@unless(request()->routeIs('home'))
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
        @if(isset($category))
            <li><a href="{{ route('categories.index') }}">{{ __('Categories') }}</a></li>
            <li class="active">{{ $category->name }}</li>
        @endif
        @if(isset($user))
            <li><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
            <li class="active">{{ $user->name }}</li>
        @endif
        @if(isset($group))
            <li><a href="{{ route('groups.index') }}">{{ __('Groups') }}</a></li>
            <li class="active">{{ $group->name }}</li>
        @endif
        @if(isset($title))
            <li class="active">{{ $title }}</li>
        @endif
    </ol>
@endunless

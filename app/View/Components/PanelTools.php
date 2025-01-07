<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class PanelTools extends Component
{
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('components.panel-tools');
    }

    public function shouldRender(): bool
    {
        $user = Auth::user();
        return $user && method_exists($user, 'isAdmin') && $user->isAdmin();
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PanelTools extends Component
{
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('components.panel-tools');
    }

    public function shouldRender(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
}

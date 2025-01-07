<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Link;
use App\Models\Comment;

class SpamTrigger extends Component
{
    public $moderatedLinks;
    public $moderatedComments;

    public function __construct()
    {
        $this->moderatedLinks = Link::query()->where('link_status', 'moderated')->count();
        $this->moderatedComments = Comment::query()->where('comment_status', 'moderated')->count();
    }

    public function render()
    {
        return view('components.spam-trigger');
    }

    public function shouldRender()
    {
        return $this->moderatedLinks > 0 || $this->moderatedComments > 0;
    }
}

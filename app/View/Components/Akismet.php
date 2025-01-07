<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Services\AkismetService;

class Akismet extends Component
{
    public $spamLinksCount;
    public $spamCommentsCount;
    public $imagePath;

    public function __construct(AkismetService $akismet)
    {
        $this->spamLinksCount = $akismet->getSpamLinksCount();
        $this->spamCommentsCount = $akismet->getSpamCommentsCount();
        $this->imagePath = asset('images/widgets/akismet');
    }

    public function render()
    {
        return view('components.akismet');
    }

    public function shouldRender()
    {
        return config('services.akismet.enabled', false);
    }
}

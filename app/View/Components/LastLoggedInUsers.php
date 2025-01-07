<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;
use Carbon\Carbon;

class LastLoggedInUsers extends Component
{
    public $users;
    public $limit;

    public function __construct(int $limit = 10)
    {
        $this->limit = $limit;
        $this->users = User::query()
            ->where('user_enabled', 1)
            ->orderBy('user_lastlogin', 'desc')
            ->take($limit)
            ->get()
            ->map(function ($user) {
                $user->is_new = $user->created_at->gt(now()->subDays(3));
                $user->last_login_relative = Carbon::parse($user->user_lastlogin)->diffForHumans();
                return $user;
            });
    }

    public function render()
    {
        return view('components.last-logged-in-users');
    }

    public function shouldRender()
    {
        return true;
    }
}

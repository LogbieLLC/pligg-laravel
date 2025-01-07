<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Link;
use App\Models\Vote;
use App\Models\Comment;
use App\Models\Group;

class Statistics extends Component
{
    public $version_number;
    public $members;
    public $grouptotal;
    public $total;
    public $published_submissions_count;
    public $new_submissions_count;
    public $votes;
    public $comments;
    public $last_user;
    public $php_version;
    public $mysql_version;
    public $dbsize;

    public function __construct()
    {
        $this->version_number = config('pligg.version', '1.0.0');
        $this->members = User::query()->count();
        $this->grouptotal = Group::query()->count();
        $this->total = Link::query()->count();
        $this->published_submissions_count = Link::query()->where('link_status', 'published')->count();
        $this->new_submissions_count = Link::query()->where('link_status', 'new')->count();
        $this->votes = Vote::query()->count();
        $this->comments = Comment::query()->count();
        $this->last_user = User::query()->latest('created_at')->first()?->name;
        $this->php_version = PHP_VERSION;
        $this->mysql_version = DB::select('select version() as version')[0]->version;

        // Calculate database size
        $dbsize = DB::select(
            "
            SELECT SUM(data_length + index_length) as size 
            FROM information_schema.TABLES 
            WHERE table_schema = ?",
            [config('database.connections.mysql.database')]
        );
        $this->dbsize = number_format($dbsize[0]->size / 1024 / 1024, 2) . ' MB';
    }

    public function render()
    {
        return view('components.statistics');
    }

    public function shouldRender()
    {
        return true;
    }
}

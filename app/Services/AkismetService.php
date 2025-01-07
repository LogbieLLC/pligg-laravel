<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Link;
use App\Models\Comment;

class AkismetService
{
    protected $apiKey;
    protected $blogUrl;
    protected $isEnabled;

    public function __construct()
    {
        $this->apiKey = config('services.akismet.key');
        $this->blogUrl = config('app.url');
        $this->isEnabled = !empty($this->apiKey);
    }

    public function getSpamLinksCount(): int
    {
        return Cache::remember('akismet_spam_links_count', 300, function () {
            return Link::query()->where('link_status', 'spam')->count();
        });
    }

    public function getSpamCommentsCount(): int
    {
        return Cache::remember('akismet_spam_comments_count', 300, function () {
            return Comment::query()->where('comment_status', 'spam')->count();
        });
    }

    public function checkContent($content, $author, $email, $type = 'comment'): bool
    {
        if (!$this->isEnabled) {
            return false;
        }

        $response = Http::asForm()
            ->post("https://{$this->apiKey}.rest.akismet.com/1.1/comment-check", [
                'blog' => $this->blogUrl,
                'user_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer' => request()->header('referer'),
                'comment_type' => $type,
                'comment_author' => $author,
                'comment_author_email' => $email,
                'comment_content' => $content,
            ]);

        return $response->successful() && $response->body() === 'true';
    }

    public function submitSpam($content, $author, $email, $type = 'comment'): bool
    {
        if (!$this->isEnabled) {
            return false;
        }

        $response = Http::asForm()
            ->post("https://{$this->apiKey}.rest.akismet.com/1.1/submit-spam", [
                'blog' => $this->blogUrl,
                'user_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer' => request()->header('referer'),
                'comment_type' => $type,
                'comment_author' => $author,
                'comment_author_email' => $email,
                'comment_content' => $content,
            ]);

        return $response->successful();
    }

    public function submitHam($content, $author, $email, $type = 'comment'): bool
    {
        if (!$this->isEnabled) {
            return false;
        }

        $response = Http::asForm()
            ->post("https://{$this->apiKey}.rest.akismet.com/1.1/submit-ham", [
                'blog' => $this->blogUrl,
                'user_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer' => request()->header('referer'),
                'comment_type' => $type,
                'comment_author' => $author,
                'comment_author_email' => $email,
                'comment_content' => $content,
            ]);

        return $response->successful();
    }
}

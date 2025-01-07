<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vote;
use App\Models\Link;
use App\Models\Comment;
use App\Models\Formula;

class KarmaService
{
    /**
     * Calculate karma for a vote based on the voter's karma and vote value
     */
    public function calculateVoteKarma(Vote $vote): float
    {
        $formula = Formula::query()
            ->where('type', 'karma')
            ->where('enabled', true)
            ->first();

        /** @var float $userKarma */
        $userKarma = config('pligg.default_karma', 1.0);
        if ($vote->user !== null) {
            $userKarma = (float)$vote->user->karma;
        }

        if (!$formula) {
            // Default formula if none exists
            return $vote->value * ($userKarma / 100);
        }

        /** @var float $targetKarma */
        $targetKarma = 0.0;
        if ($vote->link !== null) {
            $targetKarma = (float)$vote->link->karma;
        } elseif ($vote->comment !== null && $vote->comment->karma !== null) {
            $targetKarma = (float)$vote->comment->karma;
        }

        return $this->executeFormula($formula->formula, [
            'vote_value' => $vote->value,
            'user_karma' => $userKarma,
            'target_karma' => $targetKarma,
        ]);
    }

    /**
     * Update karma for a link and its author
     */
    public function updateLinkKarma(Link $link): void
    {
        $totalKarma = $link->votes()
            ->where('type', 'links')
            ->sum('karma');

        $link->karma = $totalKarma;
        $link->save();

        // Update author's karma
        $link->author->updateKarma($totalKarma / 10); // Author gets 10% of link karma
    }

    /**
     * Update karma for a comment and its author
     */
    public function updateCommentKarma(Comment $comment): void
    {
        $totalKarma = $comment->votes()
            ->where('type', 'comments')
            ->sum('karma');

        $comment->karma = $totalKarma;
        $comment->save();

        /** @var \App\Models\User|null $author */
        $author = $comment->user()->first();
        if ($author !== null) {
            $author->updateKarma($totalKarma / 5); // Author gets 20% of comment karma
        }
    }

    /**
     * Execute a karma formula with given variables
     */
    private function executeFormula(string $formula, array $variables): float
    {
        $expression = $formula;
        foreach ($variables as $key => $value) {
            $expression = str_replace('{' . $key . '}', (string)(float)$value, $expression);
        }

        try {
            return eval('return ' . $expression . ';');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error executing karma formula: ' . $e->getMessage());
            return 0;
        }
    }
}

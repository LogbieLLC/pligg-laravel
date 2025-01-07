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

        if (!$formula) {
            // Default formula if none exists
            return $vote->value * ($vote->user->karma / 100);
        }

        // Execute the stored formula
        return $this->executeFormula($formula->formula, [
            'vote_value' => $vote->value,
            'user_karma' => $vote->user->karma,
            'target_karma' => $vote->link?->karma ?? $vote->comment?->karma ?? 0,
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

        // Update author's karma
        $comment->user->updateKarma($totalKarma / 5); // Author gets 20% of comment karma
    }

    /**
     * Execute a karma formula with given variables
     */
    private function executeFormula(string $formula, array $variables): float
    {
        $expression = $formula;
        foreach ($variables as $key => $value) {
            $expression = str_replace('{' . $key . '}', (float) $value, $expression);
        }

        try {
            return eval('return ' . $expression . ';');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error executing karma formula: ' . $e->getMessage());
            return 0;
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Config;

class CsrfTokenService
{
    private string $key;
    private string $algorithm = 'HS256';

    public function __construct()
    {
        $this->key = config('app.key');
    }

    /**
     * Generate a new CSRF token
     */
    public function generate(): string
    {
        $payload = [
            'random' => Str::random(config('pligg.csrf_token_length', 40)),
            'timestamp' => now()->timestamp,
            'exp' => now()->addMinutes(config('pligg.csrf_token_expiration', 60))->timestamp,
        ];

        return JWT::encode($payload, $this->key, $this->algorithm);
    }

    /**
     * Validate a CSRF token
     */
    public function validate(string $token): bool
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, $this->algorithm));
            
            // Check if token has expired
            if ($decoded->exp < now()->timestamp) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Refresh a CSRF token
     */
    public function refresh(string $token): string
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, $this->algorithm));
            
            // Create new token with same random string but updated timestamps
            $payload = [
                'random' => $decoded->random,
                'timestamp' => now()->timestamp,
                'exp' => now()->addMinutes(config('pligg.csrf_token_expiration', 60))->timestamp,
            ];

            return JWT::encode($payload, $this->key, $this->algorithm);
        } catch (\Exception $e) {
            // If token is invalid, generate a new one
            return $this->generate();
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    protected $key;
    protected $algorithm = 'HS256';
    protected $tokenLifetime = 3600; // 1 hour

    public function __construct()
    {
        $this->key = config('app.key');
    }

    public function generateToken(): string
    {
        $payload = [
            'random' => Str::random(32),
            'timestamp' => time(),
            'exp' => time() + $this->tokenLifetime
        ];

        return JWT::encode($payload, $this->key, $this->algorithm);
    }

    public function validateToken(string $token): bool
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, $this->algorithm));

            // Check if token has expired
            if ($decoded->exp < time()) {
                return false;
            }

            // Validate timestamp is within acceptable range
            if (($decoded->timestamp + $this->tokenLifetime) < time()) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getMetaTag(): string
    {
        return sprintf(
            '<meta name="csrf-token" content="%s">',
            $this->generateToken()
        );
    }

    public function getFormField(): string
    {
        return sprintf(
            '<input type="hidden" name="_token" value="%s">',
            $this->generateToken()
        );
    }
}

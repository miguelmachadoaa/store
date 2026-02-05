<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailMarketingService
{
    protected string $apiKey;

    protected string $baseUrl = 'https://api.brevo.com/v3';

    public function __construct()
    {
        $this->apiKey = config('services.brevo.key') ?? '';
    }

    /**
     * Sync a user to Brevo.
     */
    public function syncUser(User $user, array $tags = []): bool
    {
        $setting = \App\Models\Setting::first();
        if (! $setting || ! $setting->use_brevo) {
            return false;
        }

        if (empty($this->apiKey)) {
            Log::warning('Brevo API key is not set.');

            return false;
        }

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post("{$this->baseUrl}/contacts", [
            'email' => $user->email,
            'attributes' => [
                'NOMBRE' => $user->name,
                'ROL' => $user->role,
            ],
            'listIds' => [2], // Example list ID
            'updateEnabled' => true,
        ]);

        if ($response->failed()) {
            Log::error('Failed to sync user to Brevo: '.$response->body());

            return false;
        }

        return true;
    }
}

<?php

namespace App\Services;

use Supabase\CreateClient;

class SupabaseService
{
    private CreateClient $client;

    public function __construct()
    {
        $url = env('SUPABASE_URL');
        $host = parse_url($url, PHP_URL_HOST) ?: '';
        $scheme = parse_url($url, PHP_URL_SCHEME) ?: 'https';

        $parts = explode('.', $host);
        $reference = env('SUPABASE_PROJECT_REF') ?: ($parts[0] ?? '');
        $domain = implode('.', array_slice($parts, 1)) ?: 'supabase.co';

        $this->client = new CreateClient(
            env('SUPABASE_ANON_KEY'),
            $reference,
            [],
            $domain,
            $scheme
        );
    }

    public function auth()
    {
        return $this->client->auth;
    }

    public function from(string $table)
    {
        return $this->client->from($table);
    }

    public function rpc(string $fn, array $params = [])
    {
        return $this->client->rpc($fn, $params);
    }
}

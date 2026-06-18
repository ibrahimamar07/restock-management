<?php

namespace App\Services;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use Supabase\CreateClient;

class SupabaseService
{
    private CreateClient $client;

    private HttpClient $http;

    private string $url;

    private ?string $serviceKey;

    private ?string $anonKey;

    public function __construct()
    {
        $url = env('SUPABASE_URL');
        $this->url = rtrim($url, '/');
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

        $this->serviceKey = env('SUPABASE_SERVICE_KEY');
        $this->anonKey = env('SUPABASE_ANON_KEY');

        $this->http = new HttpClient([
            'base_uri' => $this->url.'/storage/v1/',
            'headers' => [
                'apikey' => $this->anonKey,
            ],
            'http_errors' => false,
        ]);
    }

    /**
     * Upload a file to a Supabase Storage bucket.
     */
    public function uploadFile(string $bucket, string $path, string $contents, string $contentType = 'application/octet-stream'): bool
    {
        $headers = [
            'Authorization' => 'Bearer '.($this->serviceKey ?? ''),
            'Content-Type' => $contentType,
            'apikey' => $this->anonKey,
        ];

        $response = $this->http->request('PUT', "object/{$bucket}/".ltrim($path, '/'), [
            'headers' => $headers,
            'body' => $contents,
            'query' => ['upsert' => 'true'],
        ]);

        return $this->isSuccess($response);
    }

    /**
     * Get public URL for an object in a public bucket.
     */
    public function getPublicUrl(string $bucket, string $path): string
    {
        return $this->url.'/storage/v1/object/public/'.$bucket.'/'.ltrim($path, '/');
    }

    /**
     * Delete a file from a Supabase Storage bucket.
     */
    public function deleteFile(string $bucket, string $path): bool
    {
        $headers = [
            'Authorization' => 'Bearer '.($this->serviceKey ?? ''),
            'apikey' => $this->anonKey,
        ];

        $response = $this->http->request('DELETE', "object/{$bucket}/".ltrim($path, '/'), [
            'headers' => $headers,
        ]);

        return $this->isSuccess($response);
    }

    private function isSuccess(ResponseInterface $response): bool
    {
        $code = $response->getStatusCode();

        return $code >= 200 && $code < 300;
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

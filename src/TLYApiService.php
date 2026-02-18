<?php

namespace TLY\LaravelUrlShortener;

use Illuminate\Support\Facades\Http;

class TLYApiService
{
    protected $apiBaseUrl;
    protected $apiToken;

    public function __construct(string $apiToken, string $apiBaseUrl = 'https://api.t.ly/api/v1')
    {
        $this->apiToken = $apiToken;
        $this->apiBaseUrl = rtrim($apiBaseUrl, '/');
    }

    private function headers()
    {
        return [
            'Authorization' => 'Bearer '.$this->apiToken,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    private function endpoint(string $path): string
    {
        return "{$this->apiBaseUrl}/".ltrim($path, '/');
    }

    private function getJson(string $path, array $query = [])
    {
        return Http::withHeaders($this->headers())
            ->get($this->endpoint($path), $query)
            ->json();
    }

    private function postJson(string $path, array $payload = [])
    {
        return Http::withHeaders($this->headers())
            ->post($this->endpoint($path), $payload)
            ->json();
    }

    private function putJson(string $path, array $payload = [])
    {
        return Http::withHeaders($this->headers())
            ->put($this->endpoint($path), $payload)
            ->json();
    }

    private function deleteJson(string $path, array $payload = [])
    {
        return Http::withHeaders($this->headers())
            ->delete($this->endpoint($path), $payload)
            ->json();
    }

    // Short Link endpoints
    public function create(array $data)
    {
        return $this->postJson('link/shorten', $data);
    }

    public function get(string $shortUrl)
    {
        return $this->getJson('link', ['short_url' => $shortUrl]);
    }

    public function update(array $data)
    {
        return $this->putJson('link', $data);
    }

    public function delete(string $shortUrl)
    {
        return $this->deleteJson('link', ['short_url' => $shortUrl]);
    }

    public function list(array $params = [])
    {
        return $this->listShortLinks($params);
    }

    public function listShortLinks(array $params = [])
    {
        return $this->getJson('link/list', $params);
    }

    public function expand(string $shortUrl, ?string $password = null, array $payload = [])
    {
        $data = array_merge($payload, ['short_url' => $shortUrl]);

        if ($password !== null) {
            $data['password'] = $password;
        }

        return $this->postJson('link/expand', $data);
    }

    public function bulk(array $payload)
    {
        return $this->postJson('link/bulk', $payload);
    }

    public function bulkUpdate(array $payload)
    {
        return $this->postJson('link/bulk/update', $payload);
    }

    public function stats(string $shortUrl, array $params = [])
    {
        return $this->getJson('link/stats', array_merge($params, ['short_url' => $shortUrl]));
    }

    // UTM Preset endpoints
    public function createUtmPreset(array $payload)
    {
        return $this->postJson('link/utm-preset', $payload);
    }

    public function listUtmPresets(array $params = [])
    {
        return $this->getJson('link/utm-preset', $params);
    }

    public function getUtmPreset($id)
    {
        return $this->getJson("link/utm-preset/{$id}");
    }

    public function updateUtmPreset($id, array $payload)
    {
        return $this->putJson("link/utm-preset/{$id}", $payload);
    }

    public function deleteUtmPreset($id)
    {
        return $this->deleteJson("link/utm-preset/{$id}");
    }

    // OneLink endpoints
    public function oneLinkStats(string $shortUrl, ?string $startDate = null, ?string $endDate = null, array $params = [])
    {
        $query = array_merge($params, ['short_url' => $shortUrl]);

        if ($startDate !== null) {
            $query['start_date'] = $startDate;
        }

        if ($endDate !== null) {
            $query['end_date'] = $endDate;
        }

        return $this->getJson('onelink/stats', $query);
    }

    public function deleteOneLinkStats(string $shortUrl)
    {
        return $this->deleteJson('onelink/stat', ['short_url' => $shortUrl]);
    }

    public function listOneLinks(array $params = [])
    {
        return $this->getJson('onelink/list', $params);
    }

    // Pixel endpoints
    public function createPixel(array $payload)
    {
        return $this->postJson('link/pixel', $payload);
    }

    public function listPixels(array $params = [])
    {
        return $this->getJson('link/pixel', $params);
    }

    public function getPixel($id)
    {
        return $this->getJson("link/pixel/{$id}");
    }

    public function updatePixel($id, array $payload)
    {
        return $this->putJson("link/pixel/{$id}", $payload);
    }

    public function deletePixel($id)
    {
        return $this->deleteJson("link/pixel/{$id}");
    }

    // QR Code endpoints
    public function getQrCode(string $shortUrl, array $params = [])
    {
        return $this->getJson('link/qr-code', array_merge($params, ['short_url' => $shortUrl]));
    }

    public function updateQrCode(array $payload)
    {
        return $this->putJson('link/qr-code', $payload);
    }

    // Tag endpoints
    public function listTags(array $params = [])
    {
        return $this->getJson('link/tag', $params);
    }

    public function createTag(array $payload)
    {
        return $this->postJson('link/tag', $payload);
    }

    public function getTag($id)
    {
        return $this->getJson("link/tag/{$id}");
    }

    public function updateTag($id, array $payload)
    {
        return $this->putJson("link/tag/{$id}", $payload);
    }

    public function deleteTag($id)
    {
        return $this->deleteJson("link/tag/{$id}");
    }
}

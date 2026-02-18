# T.LY Laravel URL Shortener API

Laravel wrapper for the [T.LY API](https://t.ly/docs), including full support for the endpoints in the current Postman collection.

## Create an API Key

1. Register a [T.LY account](https://t.ly/register).
2. Create an [API token](https://t.ly/settings#/api).

## Installation

```bash
composer require tly/laravel-url-shortener-api
```

Publish config:

```bash
php artisan vendor:publish --provider="TLY\\LaravelUrlShortener\\TLYServiceProvider" --tag=config
```

Set environment values:

```dotenv
TLY_API_TOKEN=your_api_token_here
TLY_API_BASE_URL=https://api.t.ly/api/v1
```

## Usage

```php
use TLY\LaravelUrlShortener\Facades\TLYApi;
```

All methods return decoded JSON from the T.LY API.

### Short Link Methods

- `create(array $data)`
- `get(string $shortUrl)`
- `update(array $data)`
- `delete(string $shortUrl)`
- `list(array $params = [])`
- `listShortLinks(array $params = [])`
- `expand(string $shortUrl, ?string $password = null, array $payload = [])`
- `bulk(array $payload)`
- `bulkUpdate(array $payload)`
- `stats(string $shortUrl, array $params = [])`

Example:

```php
$response = TLYApi::create([
    'long_url' => 'https://example.com',
    'description' => 'Example link',
]);
```

### OneLink Methods

- `oneLinkStats(string $shortUrl, ?string $startDate = null, ?string $endDate = null, array $params = [])`
- `deleteOneLinkStats(string $shortUrl)`
- `listOneLinks(array $params = [])`

Example:

```php
$stats = TLYApi::oneLinkStats(
    'https://t.ly/one',
    '2024-06-01',
    '2024-06-08'
);
```

### UTM Preset Methods

- `createUtmPreset(array $payload)`
- `listUtmPresets(array $params = [])`
- `getUtmPreset($id)`
- `updateUtmPreset($id, array $payload)`
- `deleteUtmPreset($id)`

### Pixel Methods

- `createPixel(array $payload)`
- `listPixels(array $params = [])`
- `getPixel($id)`
- `updatePixel($id, array $payload)`
- `deletePixel($id)`

### QR Code Methods

- `getQrCode(string $shortUrl, array $params = [])`
- `updateQrCode(array $payload)`

Example:

```php
$qr = TLYApi::getQrCode('https://t.ly/c55j', [
    'output' => 'base64',
    'format' => 'eps',
]);
```

### Tag Methods

- `listTags(array $params = [])`
- `createTag(array $payload)`
- `getTag($id)`
- `updateTag($id, array $payload)`
- `deleteTag($id)`

## License

MIT

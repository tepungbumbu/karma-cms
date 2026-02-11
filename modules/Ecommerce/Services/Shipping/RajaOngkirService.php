<?php

namespace Karma\Ecommerce\Services\Shipping;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class RajaOngkirService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $accountType;

    public function __construct()
    {
        $this->apiKey = config('ecommerce.shipping.rajaongkir.api_key');
        $this->baseUrl = config('ecommerce.shipping.rajaongkir.base_url', 'https://api.rajaongkir.com/starter/');
        $this->accountType = config('ecommerce.shipping.rajaongkir.account_type', 'starter');
    }

    public function getProvinces(): array
    {
        return Cache::remember('rajaongkir_provinces', 86400, function () {
            $response = Http::withHeaders(['key' => $this->apiKey])->get($this->baseUrl . 'province');
            return $response->json()['rajaongkir']['results'] ?? [];
        });
    }

    public function getCities(int $provinceId): array
    {
        return Cache::remember("rajaongkir_cities_{$provinceId}", 86400, function () use ($provinceId) {
            $response = Http::withHeaders(['key' => $this->apiKey])->get($this->baseUrl . 'city', [
                'province' => $provinceId
            ]);
            return $response->json()['rajaongkir']['results'] ?? [];
        });
    }

    public function calculateCost(int $origin, int $destination, int $weight, string $courier): array
    {
        $cacheKey = "rajaongkir_cost_{$origin}_{$destination}_{$weight}_{$courier}";
        
        return Cache::remember($cacheKey, 3600, function () use ($origin, $destination, $weight, $courier) {
            try {
                $response = Http::withHeaders(['key' => $this->apiKey])->post($this->baseUrl . 'cost', [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courier
                ]);

                if ($response->successful()) {
                    return $response->json()['rajaongkir']['results'][0]['costs'] ?? [];
                }
            } catch (Exception $e) {
                // Log error
            }

            return [];
        });
    }
}

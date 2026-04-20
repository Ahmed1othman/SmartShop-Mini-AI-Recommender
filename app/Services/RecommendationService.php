<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smpita\ConfigAs\ConfigAs;
use Smpita\TypeAs\TypeAs;

class RecommendationService
{
    /**
     * @param  array<int, int>  $viewedProductIds
     * @return Collection<int, Product>
     */
    public function getRecommendations(array $viewedProductIds): Collection
    {
        if (empty($viewedProductIds)) {
            return $this->fallback();
        }

        // 1. Build a unique cache key based on viewed products and auth status
        sort($viewedProductIds);
        $userSuffix = auth()->check() ? 'u'.(string) auth()->id() : 'guest';
        $cacheKey = "ai_rec_{$userSuffix}_".md5(implode(',', $viewedProductIds));

        if (Cache::has($cacheKey)) {
            Log::info("AI Tracker - [CACHE HIT] Recommendations retrieved from cache. Key: {$cacheKey}");
        } else {
            Log::info("AI Tracker - [CACHE MISS] Fetching new recommendations from AI API. Key: {$cacheKey}");
        }

        // 2. Try to get from cache, or call AI and store result
        /** @var Collection<int, Product> $results */
        $results = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($viewedProductIds) {
            $viewedProducts = Product::whereIn('id', $viewedProductIds)->get();

            if ($viewedProducts->isEmpty()) {
                return null;
            }

            return $this->fetchFromAi($viewedProducts);
        }) ?? $this->fallback();

        return $results;
    }

    /**
     * @param  Collection<int, Product>  $viewedProducts
     */
    protected function buildAiPrompt(Collection $viewedProducts): string
    {
        /** @var array<string, string> $allProducts */
        $allProducts = Cache::remember('ai_all_products_list', now()->addHour(), function () {
            return Product::pluck('name', 'slug')->toArray();
        });

        $prompt = "A user viewed these products:\n";
        foreach ($viewedProducts as $product) {
            /** @var Product $product */
            $prompt .= "- {$product->name}\n";
        }

        $prompt .= "\nChoose EXACTLY 3 products from this list that they might like:\n";
        foreach ($allProducts as $slug => $name) {
            $prompt .= "- {$name} (id: {$slug})\n";
        }

        $prompt .= "\nReturn ONLY a JSON array of exactly 3 recommended 'id' strings. No text, no markdown.";

        return $prompt;
    }

    /**
     * @return array<int, string>
     */
    protected function parseAiResponse(string $content): array
    {
        $content = mb_trim($content);

        if (str_starts_with($content, '```')) {
            $content = (string) preg_replace('/^```json\s*|\s*```$/i', '', $content);
        }

        $data = json_decode($content, true);

        return is_array($data) ? array_values(array_filter($data, 'is_string')) : [];
    }

    /**
     * @return Collection<int, Product>
     */
    protected function fallback(): Collection
    {
        return Product::inRandomOrder()->limit(3)->get();
    }

    /**
     * @param  Collection<int, Product>  $viewedProducts
     * @return Collection<int, Product>|null
     */
    private function fetchFromAi(Collection $viewedProducts): ?Collection
    {
        $prompt = $this->buildAiPrompt($viewedProducts);

        try {
            $baseUrl = ConfigAs::string('services.ai.base_url', 'https://api.openai.com/v1');
            $key = ConfigAs::string('services.ai.key');
            $model = ConfigAs::string('services.ai.model', 'gpt-4o-mini');

            $url = mb_rtrim($baseUrl, '/').'/chat/completions';

            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$key,
            ])->timeout(10)->post($url, [
                'model' => $model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => 200,
                'temperature' => 0.3,
            ]);

            if ($response->successful()) {
                Log::info("AI Tracker - API Response Received using {$model}");
                $content = TypeAs::string($response->json('choices.0.message.content'));

                return $this->processAiContent($content);
            }

            Log::error('AI Tracker - API Call Failed', ['status' => $response->status()]);
        } catch (Exception $e) {
            Log::error('AI Recommendation Exception: '.$e->getMessage());
        }

        return null;
    }

    /**
     * @return Collection<int, Product>|null
     */
    private function processAiContent(string $content): ?Collection
    {
        $slugs = $this->parseAiResponse($content);

        if (empty($slugs)) {
            return null;
        }

        $recommendations = Product::whereIn('slug', $slugs)->limit(3)->get();

        return $recommendations->isNotEmpty() ? $recommendations : null;
    }
}

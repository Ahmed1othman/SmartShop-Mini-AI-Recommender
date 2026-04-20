<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Smpita\TypeAs\TypeAs;

class ProductHistoryService
{
    private const SESSION_KEY = 'recently_viewed';

    private const LIMIT = 3;

    public function track(Product $product): void
    {
        $viewed = collect(TypeAs::array(session()->get(self::SESSION_KEY, [])))
            ->reject(fn (int $id) => $id === $product->id)
            ->prepend($product->id)
            ->take(self::LIMIT);

        session()->put(self::SESSION_KEY, $viewed->all());
    }

    /**
     * @return array<int, int>
     */
    public function getRecentlyViewedIds(): array
    {
        /** @var array<int, int> $result */
        $result = TypeAs::array(session()->get(self::SESSION_KEY, []));

        return $result;
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductHistoryService;
use App\Services\RecommendationService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected ProductHistoryService $history,
        protected RecommendationService $recommendations
    ) {}

    public function index(): View
    {
        // get all products
        $products = Product::all();

        // get recently viewed products
        $viewedIds = $this->history->getRecentlyViewedIds();

        // get recommended products using ai
        $recommendedProducts = $this->recommendations->getRecommendations($viewedIds);

        return view('home', compact('products', 'recommendedProducts'));
    }
}

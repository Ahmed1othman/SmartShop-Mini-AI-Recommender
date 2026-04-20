<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductHistoryService;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductHistoryService $history
    ) {}

    public function show(Product $product): View
    {
        $this->history->track($product);

        return view('products.show', compact('product'));
    }
}

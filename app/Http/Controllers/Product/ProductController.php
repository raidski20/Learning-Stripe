<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Stripe\PriceService;
use App\Services\Stripe\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function create(): View
    {
        return view('product.create');
    }

    public function store(Request $request, ProductService $productService, PriceService $priceService)
    {
        $productData = $request->only(['name', 'price', 'currency', 'payment_type', 'interval']);

        $stripeProductObj = $productService->create($productData);

        $productData['stripe_price'] = $priceService->create($productData, $stripeProductObj->id)->id;

        unset($productData['payment_type'], $productData['interval']);

        Product::create($productData);

        return to_route('products.index');
    }
}

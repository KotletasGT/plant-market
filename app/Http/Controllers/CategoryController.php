<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $sort = $request->query('sort', '');

        $products = Product::where('category_id', $id)->where('approved', true);

        if ($sort === 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $products->orderBy('price', 'desc');
        } elseif ($sort === 'newest') {
            $products->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $products->orderBy('created_at', 'asc');
        } elseif ($sort === 'rating_asc') {
            $products->where('rating', '>', 0)->orderBy('rating', 'asc');
        } elseif ($sort === 'rating_desc') {
            $products->where('rating', '>', 0)->orderBy('rating', 'desc');
        }

        return view('category', [
            'products' => $products->get(),
            'category' => $category,
            'sort' => $sort,
        ]);
    }
}

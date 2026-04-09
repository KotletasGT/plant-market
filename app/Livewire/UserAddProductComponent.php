<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Http;

class UserAddProductComponent extends Component
{
    use WithFileUploads;

    public $title, $description, $price, $image, $categories, $category_id;

    public $products;

    public $stockValues = [];
    public $editTitle = [];
    public $editDescription = [];
    public $editPrice = [];
    public $editCategory = [];
    public $newPhoto = [];

    public function mount()
    {
        $this->categories = Category::all();
        $this->products = Product::where('user_id', auth()->id())->with('category')->get();
        $this->stockValues = $this->products->pluck('stock', 'id')->toArray();

        foreach ($this->products as $product) {
            $this->editTitle[$product->id] = $product->title;
            $this->editDescription[$product->id] = $product->description;
            $this->editPrice[$product->id] = $product->price;
            $this->editCategory[$product->id] = $product->category_id;
        }
    }

    public function saveProduct()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:2048',
            'image' => 'required|image|max:2048' //2mb upload
        ]);

        $userDescription = $this->description;

        $prompt = "Write a concise plant care guide (max 100 words) for a beginner who just bought a {$this->title}. Include light, watering, and temperature. Be practical and clear.";

        $apiKey = config('services.gemini.api_key');

        if ($apiKey) {
            try {
                $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key=' . $apiKey;
                $response = Http::post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $careGuide = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    $this->description = $userDescription . "\n\n" . $careGuide;
                } else {
                    $this->description = $userDescription;
                }
            } catch (\Exception $e) {
                $this->description = $userDescription;
            }
        } else {
            $this->description = $userDescription;
        }

        $path = $this->image->store('products', 'public');

        Product::create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $path,
            'user_id' => auth()->id(),
        ]);

        $this->reset(['title', 'description', 'price', 'image', 'category_id']);
        $this->refreshData();

        session()->flash('message', 'Product added successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->user_id !== auth()->id()) {
            session()->flash('error', 'You can only delete your own products.');
            return;
        }

        $product->delete();
        $this->refreshData();
        session()->flash('message', 'Product deleted successfully!');
    }

    private function refreshData()
    {
        $this->products = Product::where('user_id', auth()->id())->with('category')->get();
        $this->stockValues = $this->products->pluck('stock', 'id')->toArray();

        foreach ($this->products as $product) {
            $this->editTitle[$product->id] = $product->title;
            $this->editDescription[$product->id] = $product->description;
            $this->editPrice[$product->id] = $product->price;
            $this->editCategory[$product->id] = $product->category_id;
        }
    }

    public function render()
    {
        return view('livewire.user-add-product-component')->layout('components.layouts.app');
    }

    public function updateProduct($productId)
    {
        $product = Product::find($productId);

        if (!$product || $product->user_id !== auth()->id()) {
            session()->flash('error', 'You can only edit your own products.');
            return;
        }

        $product->title = $this->editTitle[$productId] ?? $product->title;
        $product->description = $this->editDescription[$productId] ?? $product->description;
        $product->price = $this->editPrice[$productId] ?? $product->price;
        $product->category_id = $this->editCategory[$productId] ?? $product->category_id;
        $product->stock = $this->stockValues[$productId] ?? $product->stock;
        $product->save();

        $this->refreshData();
        session()->flash('message', 'Product updated successfully!');
    }

    public function updateProductImage($productId)
    {
        $product = Product::find($productId);

        if (!$product || $product->user_id !== auth()->id()) {
            session()->flash('error', 'You can only edit your own products.');
            return;
        }

        if (isset($this->newPhoto[$productId])) {
            $path = $this->newPhoto[$productId]->store('products', 'public');
            $product->image = $path;
            $product->save();
            $this->refreshData();
            session()->flash('message', 'Product image updated successfully!');
        }
    }
}
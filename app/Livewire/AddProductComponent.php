<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Http;

class AddProductComponent extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $title, $description, $price, $image, $categories, $category_id;

    public $stockValues = [];
    public $editTitle = [];
    public $editDescription = [];
    public $editPrice = [];
    public $editCategory = [];
    public $newPhoto = [];

    public function mount()

    {

        $this->categories = Category::all();
        $allProducts = Product::with('category')->get();
        $this->stockValues = $allProducts->pluck('stock', 'id')->toArray();

        foreach ($allProducts as $product) {
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
    'description' => 'required|string',   
	'image' => 'required|image|max:2048' //2mb uploadui    

	]);

        $userDescription = $this->description;

        $prompt = "Write a concise plant care guide (max 100 words) for a beginner who just bought a {$this->title}. Include light, watering, and temperature. Be practical and clear. Do not leave extra space between bullet points. The entire response will be used as description for the plant. If the plant name is in Lithuanian answer in that language. If it is not a plant answer - plant with this name unknown";

        $apiKey = config('services.gemini.api_key');

        if ($apiKey) {
            try {
                $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;
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

            // 'stock' => 0,

            'image' => $path,

            'user_id' => auth('admin')->check() ? auth('admin')->id() : null,

            'approved' => auth('admin')->check() ? true : false,

        ]);

        $this->reset(['title', 'description', 'price', 'image', 'category_id']);
        $this->refreshData();

        //$this->products = Product::with('category')->get();

        session()->flash('message', 'Product added successfully!');

    }

    public function deleteProduct($id)

    {

        Product::findOrFail($id)->delete();

        $this->refreshData();  

        //$this->products = Product::with('category')->get();

        session()->flash('message', 'Product deleted successfully!');

    }

  private function refreshData()
    {
        $allProducts = Product::with('category')->get();
        $this->stockValues = $allProducts->pluck('stock', 'id')->toArray();

        foreach ($allProducts as $product) {
            $this->editTitle[$product->id] = $product->title;
            $this->editDescription[$product->id] = $product->description;
            $this->editPrice[$product->id] = $product->price;
            $this->editCategory[$product->id] = $product->category_id;
        }
    }    

    public function render()

    {
        $products = Product::with('category')->paginate(4);
        return view('livewire.add-product-component', ['products' => $products])->layout('components.layouts.admin');

    }

/*    public function updateStock($productId)
    
    {
    $product = Product::find($productId);
    if ($product) {
        $product->stock = $this->stockValues[$productId] ?? 0;
        $product->save();

        $this->products = Product::with('category')->get();
        session()->flash('message', 'Stock updated successfully!');
    }
    }*/

    public function updateProduct($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            $product->title = $this->editTitle[$productId] ?? $product->title;
            $product->description = $this->editDescription[$productId] ?? $product->description;
            $product->price = $this->editPrice[$productId] ?? $product->price;
            $product->category_id = $this->editCategory[$productId] ?? $product->category_id;
            $product->stock = $this->stockValues[$productId] ?? $product->stock;
            $product->save();

            $this->refreshData();
            //$this->products = Product::with('category')->get();
            session()->flash('message', 'Product updated successfully!');
        }
    }

        public function updateProductImage($productId)
    {
        $this->validate([
            'newPhoto.' . $productId => 'required|image|max:2048',
        ]);

        $product = Product::find($productId);
        if ($product && isset($this->newPhoto[$productId])) {
            $path = $this->newPhoto[$productId]->store('products', 'public');
            $product->image = $path;
            $product->save();

            $this->newPhoto[$productId] = null;
            $this->refreshData();
            session()->flash('message', 'Photo updated successfully!');
        }
    }


}

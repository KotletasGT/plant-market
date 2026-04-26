<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-3xl shadow-lg border-2 border-[#091235] space-y-8">

    <div class="text-center border-b-4 border-green-400 pb-4">
        <h2 class="text-3xl font-bold text-gray-800">➕ Add New Product</h2>
        <p class="text-gray-600 mt-2">List your product for sale on our marketplace</p>
    </div>

    <form wire:submit.prevent="saveProduct" class="space-y-6">

        <!-- Product Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">📝 Product Title</label>
            <input
                type="text"
                wire:model="title"
                placeholder="Enter product name..."
                required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition"
            />
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">📄 Description</label>
            <textarea
                wire:model="description"
                placeholder="Describe your product in detail..."
                required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl resize-none focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition"
                rows="4"
            ></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Price -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">💰 Price (€)</label>
                <input
                    type="number"
                    wire:model="price"
                    placeholder="0.00"
                    step="0.01"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition"
                />
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">🏷️ Category</label>
                <select
                    wire:model="category_id"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition"
                >
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Image Upload -->
        <div class="bg-gradient-to-br from-green-50 to-blue-50 p-6 rounded-2xl border-2 border-dashed border-green-300">
            <label class="block text-sm font-semibold text-gray-700 mb-3">🖼️ Product Image</label>
            <input
                type="file"
                wire:model="image"
                required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition"
            />
            <p class="text-xs text-gray-600 mt-2">📦 Max filesize: 2MB</p>

            @error('image')
             <p class="text-red-500 text-sm mt-2 font-semibold">⚠️ {{ "The file you are trying to upload is too large" }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-black font-bold py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition transform hover:scale-105 shadow-lg"
        >
            ✅ List Product
        </button>
    </form>

    <!-- Status Messages -->
    @if (session()->has('message'))
        <div class="p-4 rounded-xl bg-green-100 border-l-4 border-green-500 text-green-700 font-semibold">
            ✅ {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 rounded-xl bg-red-100 border-l-4 border-red-500 text-red-700 font-semibold">
            ❌ {{ session('error') }}
        </div>
    @endif

    <!-- Products Section -->
    <div class="border-t-4 border-blue-400 pt-8 mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📦 Your Products</h2>

        <div class="row g-3">
            @forelse ($products as $product)
                <div class="col-lg-6 col-md-12 mb-4 d-flex justify-content-center">
                    <div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 border-4 border-green-800 rounded-2xl shadow-lg hover:shadow-2xl transition w-100">
                        <div class="space-y-4">
                            <!-- Product Image -->
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 180px; height: 140px; object-fit: cover;" class="rounded-lg shadow-md">
                            </div>

                            <!-- Product Title -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Product Name</label>
                                <input type="text" wire:model.defer="editTitle.{{ $product->id }}" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-400" />
                            </div>

                            <!-- Price & Category -->
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Price -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Price (€)</label>
                                    <input type="number" step="0.01" wire:model.defer="editPrice.{{ $product->id }}" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-400" />
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Stock</label>
                                    <input type="number" wire:model.defer="stockValues.{{ $product->id }}" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-400" />
                                </div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Category</label>
                                <select wire:model.defer="editCategory.{{ $product->id }}" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Description</label>
                                <textarea wire:model.defer="editDescription.{{ $product->id }}" class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-green-400" rows="2"></textarea>
                            </div>

                            @if(!$product->approved)
                                <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded text-yellow-800">
                                    Listing awaiting approval
                                </div>
                            @endif

                            <!-- Photo Upload -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Change Photo</label>
                                <div class="flex gap-2">
                                    <input type="file" wire:model="newPhoto.{{ $product->id }}" class="w-full text-sm" />
                                    <button wire:click="updateProductImage({{ $product->id }})" class="bg-indigo-600 text-black px-3 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold text-sm whitespace-nowrap">Update</button>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3 justify-between pt-2">
                                <button wire:click="updateProduct({{ $product->id }})" class="bg-blue-600 text-black px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold text-sm flex-1">✏️ Update</button>
                                <button wire:click="deleteProduct({{ $product->id }})" class="bg-red-600 text-black px-4 py-2 rounded-lg hover:bg-red-700 transition font-semibold text-sm">🗑️ Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-gray-500 text-lg">📭 You haven't listed any products yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>

</div>
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-lg space-y-6">

    <h2 class="text-2xl font-bold text-gray-800">Add New Product</h2>

    <form wire:submit.prevent="saveProduct" class="space-y-4">

        <input
            type="text"
            wire:model="title"
            placeholder="Title"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <textarea
            wire:model="description"
            placeholder="Description"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
            rows="4"
        ></textarea>

        <input
            type="number"
            wire:model="price"
            placeholder="Price"
            step="0.01"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <select
            wire:model="category_id"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <input
            type="file"
            wire:model="image"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        Max filesize: 2MB

        @error('image')
         <p class="text-red-500 text-sm mt-1">{{ "The file you are trying to upload is too large" }}</p>
        @enderror

        <button
            type="submit"
            class="bg-blue-600 text-white w-full py-2 rounded-lg hover:bg-blue-700 transition"
        >
            Add Product
        </button>
    </form>

    @if (session()->has('message'))
        <p class="text-green-600 font-medium bg-green-100 p-2 rounded">
            {{ session('message') }}
        </p>
    @endif


    <h2 class="text-xl font-bold text-gray-800 mb-4">Existing Products</h2>

@foreach ($products as $product)
    <div class="p-4 mb-4 border border-gray-200 rounded-lg shadow-sm bg-gray-50">
        <div class="flex justify-between items-start">
            <div class="w-full space-y-2">
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" style="width: 240px; height: 180px; object-fit: cover;" class="rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" wire:model.defer="editTitle.{{ $product->id }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded text-sm" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description:</label>
                    <textarea wire:model.defer="editDescription.{{ $product->id }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded text-sm resize-none" rows="3"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Price ($):</label>
                    <input type="number" step="0.01" wire:model.defer="editPrice.{{ $product->id }}" class="w-32 mt-1 px-3 py-2 border border-gray-300 rounded text-sm" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Category:</label>
                    <select wire:model.defer="editCategory.{{ $product->id }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded text-sm">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock:</label>
                    <input type="number" wire:model.defer="stockValues.{{ $product->id }}" class="w-24 mt-1 px-3 py-2 border border-gray-300 rounded text-sm" />
                </div>

                <div class="flex space-x-2 items-center mt-2">
                    <input type="file" wire:model="newPhoto.{{ $product->id }}" class="text-sm" />
                    <button wire:click="updateProductImage({{ $product->id }})" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-sm">Change Photo</button>
                </div>

                <div class="mt-2">
                    <button wire:click="updateProduct({{ $product->id }})" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">Update</button>
                </div>
            </div>

            <button wire:click="deleteProduct({{ $product->id }})" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-sm">
                Remove
            </button>
        </div>
    </div>
@endforeach

</div>

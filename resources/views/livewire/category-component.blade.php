<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-lg space-y-6">

    <h2 class="text-2xl font-bold text-gray-800">Manage Categories</h2>

    <form wire:submit.prevent="saveCategory" class="flex items-center gap-4">
        <input
            type="text"
            wire:model="name"
            placeholder="Category Name"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
        >
            Add Category
        </button>
    </form>

    @if (session()->has('message'))
        <div class="text-green-600 font-medium bg-green-100 p-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    <ul class="divide-y divide-gray-200">
        @forelse ($categories as $category)
        <li class="py-2 flex justify-between items-center text-gray-700">
            <span>{{ $category->name }}</span>
            <button
                wire:click="deleteCategory({{ $category->id }})"
                class="text-red-600 hover:text-red-800 text-sm font-medium"
            >
                Remove
            </button>
        </li>
        @empty
        <li class="py-2 text-gray-500 text-center">No categories added yet.</li>
        @endforelse
    </ul>

</div>

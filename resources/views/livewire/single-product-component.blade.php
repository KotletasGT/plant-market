<div class="max-w-5xl mx-auto py-10 px-6 bg-white rounded-2xl shadow-lg">

    @if (session()->has('message'))
        <div class="mb-6 text-green-700 bg-green-100 p-3 rounded font-medium">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row items-start gap-10">
        <!-- Product Image -->
        <div class="w-full md:w-1/2">
            <img
                src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->title }}"
                class="w-full h-auto rounded-xl border border-gray-200 shadow-sm"
            >
        </div>

        <!-- Product Details -->
        <div class="w-full md:w-1/2 space-y-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $product->title }}</h1>

            <p class="text-sm text-gray-500">Category: 
                <span class="font-medium">{{ $product->category->name ?? 'Uncategorized' }}</span>
            </p>

            <p class="text-gray-600">{{ $product->description }}</p>

            <p class="text-lg text-gray-700">In Stock: 
                <span class="font-semibold">{{ $product->stock }}</span>
            </p>

            <!-- Star Rating Display -->
            <div class="flex items-center space-x-0.5">
                @for ($i = 1; $i <= floor($product->rating); $i++)
                    ★ 
                @endfor
                <span class="text-sm text-gray-600 ml-2">({{ number_format($product->rating, 1) }}/5)</span>
            </div>

            <!-- Add to Cart -->
            <div>
                <button
                    wire:click="addToCart({{ $product->id }})"
                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition"
                >
                    Add to Cart
                </button>
            </div>

            <!-- Rating Form -->
            @if(auth()->check())
                <div class="pt-6 border-t mt-6">
                    <h3 class="text-lg font-semibold mb-2">Leave a Review</h3>
                    <form wire:submit.prevent="submitReview" class="space-y-4">
                        <select wire:model="rating" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">Rate this product</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>

                        <textarea
                            wire:model="comment"
                            placeholder="Optional comment..."
                            class="w-full border border-gray-300 rounded px-4 py-2 resize-none focus:ring-2 focus:ring-blue-500"
                            rows="3"
                        ></textarea>

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition"
                        >
                            Submit Review
                        </button>
                    </form>
                </div>
            @else
                <p class="mt-4 text-sm text-gray-500">
                    You must <a href="{{ route('login') }}" class="text-blue-600 underline">log in</a> to leave a review.
                </p>
            @endif

            <!-- Previous Reviews -->
            @if ($product->reviews->count())
                <div class="mt-10 border-t pt-6 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Customer Reviews</h3>
                    @foreach ($product->reviews as $review)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-700">
                                    {{ $review->user->name ?? 'Anonymous' }}
                                </div>
                                <div class="flex items-center space-x-0.5">
                                    @for ($i = 1; $i <= floor($review->rating); $i++)
                                        ★ 
                                    @endfor
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="mt-2 text-sm text-gray-600">{{ $review->comment }}</p>
                            @endif

                <!-- Show Remove button if the review belongs to the logged in user -->
                @if (auth()->check() && $review->user_id === auth()->id())
                    <div class="mt-2 text-right">
                        <button 
                            wire:click="removeReview({{ $review->id }})" 
                            class="text-red-600 text-sm hover:underline"
                        >
                            Remove
                        </button>
                    </div>
                @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>


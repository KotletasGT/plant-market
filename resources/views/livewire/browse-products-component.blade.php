<div class="col-12">
    <h1 class="text-center mt-5 mb-4">Browse Products</h1>

    @if (session()->has('message'))
        <div class="alert alert-success text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="row">
        @foreach ($products as $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="product_card">
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->title }}"
                        class="product_img"
                    />

                    <div class="pc_content">
                        <h2>{{ $product->title }}</h2>
                        <p class="pcc_in">In <a href="#!">{{ $product->category->name ?? 'Uncategorized' }}</a></p>
<p class="pcc_price">€{{ number_format($product->price, 2) }}</p>

                        <div class="pcc_btns">
                            <button
                                wire:click="addToCart({{ $product->id }})"
                                class="addtocart"
                            >
                                Add To Cart
                            </button>

                            <a href="{{ route('product.show', $product->id) }}" class="viewbtn">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="col-12">
    <h1 class="text-center mt-4 mb-4">Moderation — Pending Listings</h1>

    @if (session()->has('message'))
        <div class="alert alert-success text-center">
            {{ session('message') }}
        </div>
    @endif

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width:120px;height:90px;object-fit:cover;border-radius:6px;" />
                            <div class="flex-grow-1">
                                <input type="text" class="form-control mb-2" wire:model.defer="editTitle.{{ $product->id }}" />
                                <textarea class="form-control mb-2" wire:model.defer="editDescription.{{ $product->id }}" rows="3"></textarea>

                                <div class="d-flex gap-2 mb-2">
                                    <input type="number" step="0.01" class="form-control" wire:model.defer="editPrice.{{ $product->id }}" />
                                    <select class="form-select" wire:model.defer="editCategory.{{ $product->id }}">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex gap-2 align-items-center">
                                    <input type="file" wire:model="newPhoto.{{ $product->id }}" />
                                    <button wire:click="updateProductImage({{ $product->id }})" class="btn btn-sm btn-secondary">Update Photo</button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button wire:click="updateProduct({{ $product->id }})" class="btn btn-sm btn-primary">Save</button>
                            <button wire:click="approveProduct({{ $product->id }})" class="btn btn-sm btn-success">Approve</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No pending listings.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>

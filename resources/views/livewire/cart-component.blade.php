<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-lg space-y-6">

    <h2 class="text-2xl font-bold text-gray-800">Shopping Cart</h2>

    @if (session()->has('message'))
        <p class="text-green-600 bg-green-100 p-2 rounded font-medium">
            {{ session('message') }}
        </p>
    @endif

    @if (session()->has('error'))
        <p class="text-red-600 bg-red-100 p-2 rounded font-medium">
            {{ session('error') }}
        </p>
    @endif

    @if (empty($cart))
        <p class="text-gray-600">Your cart is empty.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($cart as $productId => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $item['title'] }}</td>
                            <td class="px-4 py-2">${{ number_format($item['price'], 2) }}</td>
                            <td class="px-4 py-2">
                                <input
                                    type="number"
                                    min="1"
                                    wire:model.lazy="cart.{{ $productId }}.quantity"
                                    wire:change="updateQuantity({{ $productId }}, $event.target.value)"
                                    class="w-20 px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                                >
                            </td>
                            <td class="px-4 py-2">
                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                            </td>
                            <td class="px-4 py-2">
                                <button
                                    wire:click="removeFromCart({{ $productId }})"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition"
                                >
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray-50">
                        <td colspan="5" class="px-4 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input
                                        type="text"
                                        wire:model="city"
                                        placeholder="Enter your city"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Street</label>
                                    <input
                                        type="text"
                                        wire:model="street"
                                        placeholder="Enter your street"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">House</label>
                                    <input
                                        type="text"
                                        wire:model="house"
                                        placeholder="Enter your house number"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mt-6">
            <h3 class="text-xl font-bold text-gray-800">Total: ${{ number_format($total, 2) }}</h3>

            <button
                wire:click="confirmOrder"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
            >
                Confirm Order
            </button>
        </div>
    @endif

</div>

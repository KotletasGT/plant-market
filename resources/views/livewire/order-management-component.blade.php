<div class="max-w-7xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-lg">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Order Management</h1>

    <div class="overflow-x-auto">
        <table class="admin-table min-w-full divide-y divide-gray-200 text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2">Order ID</th>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Price Per Item</th>
                    <th class="px-4 py-2">Total Price</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">City</th>
                    <th class="px-4 py-2">Street</th>
                    <th class="px-4 py-2">House</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->product->title }}</td>
                        <td class="px-4 py-2">{{ $order->quantity }}</td>
                        <td class="px-4 py-2">${{ number_format($order->price_per_item, 2) }}</td>
                        <td class="px-4 py-2">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-4 py-2">{{ $order->user->name }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $order->status === 'approved' ? 'bg-green-100 text-green-800' :
                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                   'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $order->city }}</td>
                        <td class="px-4 py-2">{{ $order->street }}</td>
                        <td class="px-4 py-2">{{ $order->house }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <button
                                wire:click="approveOrder({{ $order->id }})"
                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition"
                            >
                                Approve
                            </button>
                            <button
                                wire:click="cancelOrder({{ $order->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition"
                            >
                                Cancel
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4 text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

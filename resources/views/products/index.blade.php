<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4">{{ $product->name }}</h2>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                            <div class="space-y-2">
                                <p>RAM: {{ $product->ram }}MB</p>
                                <p>CPU: {{ $product->cpu }}%</p>
                                <p>Storage: {{ $product->disk }}MB</p>
                                <p>Bandwidth: {{ $product->bandwidth }}GB</p>
                            </div>
                            <div class="mt-6">
                                <span class="text-3xl font-bold">€{{ $product->price }}</span>
                                <button 
                                    onclick="purchase({{ $product->id }})"
                                    class="w-full mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition"
                                >
                                    Purchase Now
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function purchase(productId) {
            fetch('/purchase', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = data.url;
            });
        }
    </script>
</x-app-layout>

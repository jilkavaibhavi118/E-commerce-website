    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- HEADER -->
    <header class="bg-blue-600 text-white p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Checkout</h1>
            <a href="{{ route('dashboard') }}" class="bg-green-500 px-3 py-1 rounded hover:bg-green-700">Back to Dashboard</a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto mt-6 p-4">

        <h2 class="text-2xl font-semibold mb-5">Checkout</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- BILLING FORM -->
            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-semibold mb-4">Billing Details</h3>

                <form action="{{ route('checkout.placeOrder') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" name="name"
                               value="{{ auth()->user()->name }}"
                               class="w-full border px-3 py-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email"
                               value="{{ auth()->user()->email }}"
                               class="w-full border px-3 py-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Phone</label>
                        <input type="text" name="phone"
                               value="{{ auth()->user()->phone }}"
                               class="w-full border px-3 py-2 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Address</label>
                        <textarea name="address"
                                  class="w-full border px-3 py-2 rounded" required></textarea>
                    </div>

                    <button type="submit"
                            class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Place Order
                    </button>
                </form>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="bg-white p-6 rounded-lg shadow border">
                <h3 class="text-lg font-semibold mb-4">Order Summary</h3>

                <div class="flex justify-between mb-2">
                    <p class="text-gray-600">Subtotal</p>
                    <p class="font-medium">₹{{ number_format($subtotal, 2) }}</p>
                </div>

                <div class="flex justify-between mb-2">
                    <p class="text-gray-600">Discount</p>
                    <p class="font-medium text-green-600">- ₹{{ number_format($discount, 2) }}</p>
                </div>

                <hr class="my-3">

                <div class="flex justify-between text-xl font-semibold">
                    <p>Total</p>
                    <p>₹{{ number_format($total, 2) }}</p>
                </div>

            </div>

        </div>

    </main>

</body>
</html>

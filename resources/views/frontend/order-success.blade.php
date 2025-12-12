<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- HEADER -->
    <header class="bg-blue-600 text-white p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Order Successful</h1>
            <a href="{{ route('dashboard') }}" class="bg-green-500 px-3 py-1 rounded hover:bg-green-700">Back to Dashboard</a>
        </div>
    </header>

    <!-- MAIN -->
    <main class="max-w-lg mx-auto mt-10 p-6">

        <div class="bg-white p-8 rounded-lg shadow text-center">

            <div class="text-green-600 text-5xl mb-4">✔</div>

            <h2 class="text-2xl font-semibold mb-3">Order Placed Successfully!</h2>

            <p class="text-gray-600 mb-6">
                Thank you for shopping with us. Your order has been placed and is currently being processed.
            </p>

            <div class="flex justify-center gap-3">
                <a href="{{ route('orders.index') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    View My Orders
                </a>

                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Continue Shopping
                </a>
            </div>

        </div>

    </main>

</body>
</html>

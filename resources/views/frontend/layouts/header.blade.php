<header class="bg-[#131921] text-white">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">

        <!-- Logo -->
        <a href="/" class="flex items-center space-x-1">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg"
                 class="h-6" alt="Logo">
        </a>

        <!-- Deliver to -->
        <div class="hidden md:flex items-center space-x-1 cursor-pointer">
            <svg class="w-5 h-5" fill="currentColor"><path d="M12 2C8.1 2 5 5.1..."/></svg>
            <div class="text-sm leading-tight">
                <p class="text-gray-300">Deliver to</p>
                <p class="font-bold">India</p>
            </div>
        </div>

        <!-- Search -->
        <div class="flex-1 px-4">
            <form action="{{ route('search') }}" method="GET" class="flex">
                <input type="text" name="query"
                    class="w-full rounded-l-md px-4 py-2 text-black"
                    placeholder="Search products...">
                <button class="bg-yellow-500 px-4 rounded-r-md">
                    <svg class="w-6 h-6 text-black"><path d="M..." /></svg>
                </button>
            </form>
        </div>

        <!-- Account -->
        <div class="hidden md:block text-sm cursor-pointer">
            @auth
                <p>Hello, {{ auth()->user()->name }}</p>
                <p class="font-bold">Account & Lists</p>
            @else
                <a href="{{ route('login') }}">
                    <p>Hello, Sign in</p>
                    <p class="font-bold">Account & Lists</p>
                </a>
            @endauth
        </div>

        <!-- Orders -->
        <a href="{{ route('frontend.orders.index') }}" class="hidden md:block text-sm cursor-pointer">
            <p>Returns</p>
            <p class="font-bold">& Orders</p>
        </a>

        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="relative cursor-pointer">
            <svg class="w-8 h-8"><path d="M..." /></svg>
            <span id="cart-count" class="absolute -top-1 -right-1 bg-yellow-500 text-black text-xs font-bold rounded-full px-1">
                {{ $cartCount ?? 0 }}
            </span>

        </a>

    </div>

    {{-- Sub Navbar --}}
    <div class="bg-[#232f3e] text-white">
        <div class="container mx-auto flex items-center px-4 py-2 space-x-6 text-sm">
            <span class="font-bold cursor-pointer">All</span>
            <span class="cursor-pointer">Today's Deals</span>
            <span class="cursor-pointer">Customer Service</span>
            <span class="cursor-pointer">Gift Cards</span>
            <span class="cursor-pointer">Amazon Pay</span>
            <span class="cursor-pointer">Fashion</span>
            <span class="cursor-pointer hidden md:block">Electronics</span>
        </div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function () {
                let productId = this.dataset.id;

                fetch("{{ route('cart.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {

                        // Update cart count dynamically
                        document.getElementById("cart-count").innerText = data.cart_count;

                    }
                });
            });
        });

    });
    </script>

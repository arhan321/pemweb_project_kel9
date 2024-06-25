<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hans Restaurants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('assets_makan/css/makanss.css') }}">
 
</head>

<body>
    <header>
        <div class="nav container">
            <a href="" class="logo"><span>HANS</span> Restaurants</a>
            <i class='bx bx-shopping-bag' id="cart-icon"></i>
            <div class="cart">
                <h2 class="cart-title">Your Cart</h2>
                <div class="cart-content">
                    @foreach ($cart as $item)
                    <div class="cart-box">
                        <img src="{{ $item['img'] }}" alt="" class="cart-img">
                        <div class="detail-box">
                            <div class="cart-product-title">{{ $item['name'] }}</div>
                            <div class="cart-quantity-wrapper">
                                <button type="button" class="btn-quantity decrease" data-product-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}">-</button>
                                <input type="number" value="{{ $item['quantity'] }}" class="cart-quantity" data-product-id="{{ $item['id'] }}" data-stock="{{ $item['stock'] }}" data-price="{{ $item['price'] }}">
                                <button type="button" class="btn-quantity increase" data-product-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}">+</button>
                            </div>
                            <div class="cart-price" data-product-id="{{ $item['id'] }}">Rp{{ number_format($item['price'], 2, ',', '.') }}</div>
                            <!-- Mulai form di sini -->
                            <form method="post" action="{{ route('makan.removeFromCart') }}" class="remove-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn-remove"><i class='bx bxs-trash-alt'></i></button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="total">
                    <div class="total-title">Total</div>
                    <div class="total-price">Rp{{ number_format($total_price, 2, ',', '.') }}</div>
                </div>
                <button type="button" class="btn-buy">Buy Now</button>
                <i class='bx bx-x' id="cart-close"></i>
            </div>
        </div>
    </header>

    <section class="shop container">
        <div class="input-group mb=3">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
        </div>
        <h2 class="section-title">Shop Products</h2>
        <section id="menu" class="menu section-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Menu</h2>
                    <p>Check Our Tasty Menu</p>
                </div>
            </div>
        </section>

        <div class="shop-content">
            <div class="product-wrapper">
                @foreach ($products as $product)
                    <div class="product-box">
                        <img src="{{ $product->getFirstMediaUrl('image', 'preview') }}" alt="{{ $product->name }}" class="product-img">
                        <div class="product-details">
                            <h2 class="product-title">{{ $product->name }}</h2>
                            <span class="product-price">Rp{{ number_format($product->price, 2, ',', '.') }}</span>
                            <form method="post" action="{{ route('makan.addToCart') }}" class="add-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_name" value="{{ $product->name }}">
                                <input type="hidden" name="product_price" value="{{ $product->price }}">
                                <input type="hidden" name="product_img" value="{{ $product->getFirstMediaUrl('image', 'preview') }}">
                                <button type="submit" class="btn-add-cart"><i class='bx bx-shopping-bag add-cart'></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .cart-quantity-wrapper {
            display: flex;
            align-items: center;
        }

        .btn-quantity {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            margin: 0 5px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-quantity:hover {
            background-color: #e0e0e0;
            border-color: #bbb;
        }

        .btn-quantity:active {
            background-color: #d0d0d0;
            border-color: #aaa;
        }

        .btn-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: #ff0000;
            font-size: 24px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets_makan/js_makan/mainsss.js') }}"></script>

    <script>
   document.addEventListener('DOMContentLoaded', function() {
    const cartContent = document.querySelector('.cart-content');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    cartContent.addEventListener('click', function(event) {
        const target = event.target;
        if (target.classList.contains('increase') || target.classList.contains('decrease')) {
            const isIncrease = target.classList.contains('increase');
            const input = target.closest('.cart-box').querySelector('.cart-quantity');
            const productId = input.dataset.productId;
            const stock = parseInt(input.dataset.stock);
            const price = parseFloat(input.dataset.price);
            let currentQuantity = parseInt(input.value);

            if (isIncrease && currentQuantity < stock) {
                currentQuantity++;
            } else if (!isIncrease && currentQuantity > 1) {
                currentQuantity--;
            }

            input.value = currentQuantity;
            updateCart(productId, isIncrease ? 'increase' : 'decrease', currentQuantity, price);
        }
    });
});

function updateCart(productId, action, quantity, price) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const updateCartUrl = '/makan/update-cart';  // Jika tidak dapat menggunakan Blade syntax
    const newTotalPrice = quantity * price;
    document.querySelector(`.cart-price[data-product-id="${productId}"]`).innerText = `Rp${newTotalPrice.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;

    let newGrandTotal = 0;
    document.querySelectorAll('.cart-quantity').forEach(input => {
        const productPrice = parseFloat(input.dataset.price);
        newGrandTotal += productPrice * parseInt(input.value);
    });

    document.querySelector('.total-price').innerText = `Rp${newGrandTotal.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;

    fetch(updateCartUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ product_id: productId, action: action, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Update successful:', data);
    })
    .catch(error => console.error('Error updating cart:', error));
}

</script>
</body>

</html>

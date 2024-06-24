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
                                <div class="cart-price">Rp{{ number_format($item['price'], 2, ',', '.') }}</div>
                                <div class="cart-quantity-wrapper">
                                    <form method="post" action="{{ route('makan.updateCart') }}" class="update-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <input type="hidden" name="action" value="decrease">
                                        <button type="submit" class="btn-quantity">-</button>
                                    </form>
                                    <input type="number" value="{{ $item['quantity'] }}" class="cart-quantity" disabled>
                                    <form method="post" action="{{ route('makan.updateCart') }}" class="update-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" class="btn-quantity">+</button>
                                    </form>
                                </div>
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
document.addEventListener("DOMContentLoaded", function() {
    const cartIcon = document.querySelector("#cart-icon");
    const cart = document.querySelector(".cart");
    const closeCart = document.querySelector("#cart-close");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    cartIcon.addEventListener("click", () => {
        cart.classList.add("active");
    });

    closeCart.addEventListener("click", () => {
        cart.classList.remove("active");
    });

    // Add event listeners to forms
    addEventListenersToForms();

    function handleFormSubmit(event) {
        event.preventDefault();
        let form = event.target;
        let formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        }).then(response => response.json()).then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                updateCartView(data.cart, data.total_price);
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    function addEventListenersToForms() {
        document.querySelectorAll(".add-cart-form").forEach(form => {
            form.addEventListener("submit", handleFormSubmit);
        });

        document.querySelectorAll(".update-cart-form").forEach(form => {
            form.addEventListener("submit", handleFormSubmit);
        });

        document.querySelectorAll(".remove-cart-form").forEach(form => {
            form.addEventListener("submit", handleFormSubmit);
        });
    }

    function updateCartView(cart, total_price) {
        const cartContent = document.querySelector(".cart-content");
        cartContent.innerHTML = '';
        cart.forEach(item => {
            const cartBox = document.createElement("div");
            cartBox.classList.add("cart-box");
            cartBox.innerHTML = `
                <img src="${item.img}" alt="" class="cart-img">
                <div class="detail-box">
                    <div class="cart-product-title">${item.name}</div>
                    <div class="cart-price">Rp${item.price.toLocaleString('id-ID', { minimumFractionDigits: 2 })}</div>
                    <div class="cart-quantity-wrapper">
                        <form method="post" action="/makan/update-cart" class="update-cart-form">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="product_id" value="${item.id}">
                            <input type="hidden" name="action" value="decrease">
                            <button type="submit" class="btn-quantity">-</button>
                        </form>
                        <input type="number" value="${item.quantity}" class="cart-quantity" disabled>
                        <form method="post" action="/makan/update-cart" class="update-cart-form">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="product_id" value="${item.id}">
                            <input type="hidden" name="action" value="increase">
                            <button type="submit" class="btn-quantity">+</button>
                        </form>
                    </div>
                    <form method="post" action="/makan/remove-from-cart" class="remove-cart-form">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="product_id" value="${item.id}">
                        <button type="submit" class="btn-remove"><i class='bx bxs-trash-alt'></i></button>
                    </form>
                </div>
            `;
            cartContent.appendChild(cartBox);
        });
        document.querySelector(".total-price").innerText = `Rp${total_price.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;
        addEventListenersToForms(); // Tambahkan kembali event listeners ke elemen formulir baru
    }
});

    </script>
</body>

</html>

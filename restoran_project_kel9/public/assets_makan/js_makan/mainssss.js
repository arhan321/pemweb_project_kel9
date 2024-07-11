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
          updateCartView(data.cart, data.total_price);
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
      addEventListenersToForms(); 
  }
});

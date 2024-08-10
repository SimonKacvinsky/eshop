let putToCart = document.querySelectorAll(".cart_wrapper .cart"),
    clickedProductsId = JSON.parse(localStorage.getItem('clickedProductsId')) || [];
// Aktualizácia zobrazenia počtu produktov na základe predtým uložených dát
document.querySelector('#number_of_products').textContent = clickedProductsId.length;

putToCart.forEach((cart) => {
    cart.addEventListener("click", () => {
        let productContainer = cart.closest('.product_container').classList[1];
        clickedProductsId.push(productContainer);

        // Aktualizácia počtu produktov
        document.querySelector('#number_of_products').textContent = clickedProductsId.length;

        // Uloženie do localStorage ako JSON string
        localStorage.setItem('clickedProductsId', JSON.stringify(clickedProductsId));
    });
});

let allProducts = document.querySelectorAll('.product_container'),
    productInfo = [];  // Pole, kam budete ukladať informácie o produktoch

allProducts.forEach((product) => {
    productInfo.push({
        id: product.classList[1],
        name: product.querySelector('.product_name').textContent,
        description: product.querySelector('.product_description').textContent,
        price: product.querySelector('.product_price').textContent,
        image: product.querySelector('.product_image').getAttribute('src'),
    });
});

// Uloženie poľa productInfo do localStorage ako JSON reťazec
localStorage.setItem('allProducts', JSON.stringify(productInfo));
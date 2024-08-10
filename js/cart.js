let clickedProductsId = JSON.parse(localStorage.getItem('clickedProductsId')) || [],
    max = Math.max(...clickedProductsId),
    storedProducts = JSON.parse(localStorage.getItem('allProducts')),
    mainContainer = document.querySelector('.cart_container');


storedProducts.forEach(function (product) {
    let numberOfProducts = 0;
    for (let i = 0; i < max; i++) {
        if (product.id === clickedProductsId[i]) {
            numberOfProducts += 1;
        }
        console.log(numberOfProducts)
    }
    if (clickedProductsId.includes(product.id)) {
        // Vytvorenie hlavného divu s triedou 'product_container'
        let productContainer = document.createElement('div');
        productContainer.className = 'product_container';

        // Vytvorenie img elementu
        let productImage = document.createElement('img');
        productImage.className = 'product_image';
        productImage.src = `../${product.image}`;

        // Vytvorenie divu pre názov a popis produktu
        let infoDiv = document.createElement('div');
        infoDiv.style.display = 'flex';
        infoDiv.style.flexDirection = 'column';

        // Vytvorenie názvu produktu
        let productName = document.createElement('h1');
        productName.className = 'product_name';
        productName.textContent = product.name;

        // Vytvorenie popisu produktu
        let productDescription = document.createElement('p');
        productDescription.className = 'product_description';
        productDescription.textContent = product.description;

        // Pridanie názvu a popisu do infoDiv
        infoDiv.appendChild(productName);
        infoDiv.appendChild(productDescription);

        // Vytvorenie divu pre množstvo a cenu
        let quantityPriceDiv = document.createElement('div');
        quantityPriceDiv.style.display = 'flex';
        quantityPriceDiv.style.flexDirection = 'column';
        quantityPriceDiv.style.justifyContent = 'center';
        quantityPriceDiv.style.gap = '10px';
        quantityPriceDiv.style.marginLeft = 'auto';

        // Vytvorenie divu pre množstvo
        let quantityDiv = document.createElement('div');
        quantityDiv.style.display = 'flex';
        quantityDiv.style.minWidth = '140px';
        quantityDiv.style.background = 'white';
        quantityDiv.style.justifyContent = 'center';

        // Pridanie prvého svg
        let svgMinus = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svgMinus.setAttribute('width', '20px');
        svgMinus.setAttribute('height', '20px');
        svgMinus.setAttribute('viewBox', '0 0 24.00 24.00');
        svgMinus.setAttribute('fill', 'none');
        let pathMinus = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        pathMinus.setAttribute('d', 'M6 12L18 12');
        pathMinus.setAttribute('stroke', '#2e9be8');
        pathMinus.setAttribute('stroke-width', '3');
        pathMinus.setAttribute('stroke-linecap', 'round');
        pathMinus.setAttribute('stroke-linejoin', 'round');
        svgMinus.appendChild(pathMinus);

        // Vytvorenie span pre množstvo
        let quantitySpan = document.createElement('span');
        quantitySpan.style.padding = '10px 10px';
        quantitySpan.innerHTML = `<span class="product_quantity">${numberOfProducts}</span>‎ ks`;

        // Pridanie druhého svg
        let svgPlus = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svgPlus.setAttribute('width', '20px');
        svgPlus.setAttribute('height', '20px');
        svgPlus.setAttribute('viewBox', '0 0 24 24');
        svgPlus.setAttribute('fill', 'none');
        let pathPlus = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        pathPlus.setAttribute('d', 'M4 12H20M12 4V20');
        pathPlus.setAttribute('stroke', '#2e9be8');
        pathPlus.setAttribute('stroke-width', '3');
        pathPlus.setAttribute('stroke-linecap', 'round');
        pathPlus.setAttribute('stroke-linejoin', 'round');
        svgPlus.appendChild(pathPlus);

        // Pridanie svg a span do quantityDiv
        quantityDiv.appendChild(svgMinus);
        quantityDiv.appendChild(quantitySpan);
        quantityDiv.appendChild(svgPlus);

        // Vytvorenie span pre cenu
        let priceSpan = document.createElement('span');
        priceSpan.style.textAlign = 'center';
        priceSpan.innerHTML = `<strong>${product.price}</strong> / ks`;

        // Pridanie quantityDiv a priceSpan do quantityPriceDiv
        quantityPriceDiv.appendChild(quantityDiv);
        quantityPriceDiv.appendChild(priceSpan);

        // Pridanie všetkých prvkov do hlavného divu 'product_container'
        productContainer.appendChild(productImage);
        productContainer.appendChild(infoDiv);
        productContainer.appendChild(quantityPriceDiv);

        // Pridanie 'product_container' do hlavného kontajnera 'mainContainer'
        mainContainer.appendChild(productContainer);
    }
});
